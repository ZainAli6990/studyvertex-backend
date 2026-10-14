<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Mcq;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Single place that creates alerts, so every feature (quiz, streaks,
 * imports, the scheduler) words and de-duplicates them the same way.
 *
 * Alerts are a nice-to-have on top of the real action (submitting a quiz,
 * answering a question, ...) -- so nothing in here is allowed to throw and
 * break that action.
 */
class AlertService
{
    /** Correct-answer streaks (in one subject) that earn a "keep it up" alert. */
    public const STREAK_MILESTONES = [5, 10, 15, 20, 25, 50, 100];

    /** Newest study reminders kept per user; older ones are pruned. */
    public const STUDY_REMINDERS_KEPT = 40;

    /**
     * Create an alert. Returns null when it was skipped or failed.
     * With a $dedupeKey, the same key for the same user is only ever
     * created once (the existing alert is returned instead).
     */
    public static function notify(
        User|int $user,
        string $type,
        string $title,
        ?string $body = null,
        array $data = [],
        ?string $dedupeKey = null,
    ): ?Alert {
        $userId = $user instanceof User ? $user->id : $user;

        $values = [
            'type' => $type,
            'title' => Str::limit($title, 200, ''),
            'body' => $body,
            'data' => $data ?: null,
        ];

        try {
            if ($dedupeKey === null) {
                return Alert::create(['user_id' => $userId] + $values);
            }

            return Alert::firstOrCreate(
                ['user_id' => $userId, 'dedupe_key' => $dedupeKey],
                $values
            );
        } catch (UniqueConstraintViolationException) {
            // Two requests raced to create the same alert -- one is enough.
            return null;
        } catch (Throwable $e) {
            report($e);

            return null;
        }
    }

    /** Result of a finished quiz -- tap to review the answers. */
    public static function quizResult(Quiz $quiz): ?Alert
    {
        $quiz->loadMissing(['subject:id,name', 'topic:id,name']);

        $total = max(1, (int) $quiz->mcqs_count);
        $score = (int) $quiz->score;
        $percent = (int) round($score / $total * 100);

        $verdict = match (true) {
            $percent >= 80 => 'Excellent work!',
            $percent >= 50 => 'Good effort - practise this topic a little more to improve.',
            default => 'Keep practising - review your answers to learn from the mistakes.',
        };

        $where = collect([$quiz->subject?->name, $quiz->topic?->name])
            ->filter()
            ->implode(' - ');

        return self::notify(
            $quiz->user_id,
            Alert::TYPE_QUIZ_RESULT,
            "Quiz result: {$score}/{$total} ({$percent}%)",
            $where !== '' ? "{$where}. {$verdict}" : $verdict,
            [
                'quiz_id' => $quiz->id,
                'subject_id' => $quiz->subject_id,
                'topic_id' => $quiz->topic_id,
            ],
            "quiz_result:{$quiz->id}"
        );
    }

    /** A quiz was started but never finished -- tap to continue it. */
    public static function pendingQuiz(Quiz $quiz): ?Alert
    {
        $quiz->loadMissing(['subject:id,name', 'topic:id,name']);

        $name = $quiz->topic?->name ?? $quiz->subject?->name ?? 'a topic';

        return self::notify(
            $quiz->user_id,
            Alert::TYPE_QUIZ_PENDING,
            'You have an unfinished quiz',
            "Your {$quiz->mcqs_count}-question quiz on {$name} is waiting. Tap to finish it.",
            ['quiz_id' => $quiz->id],
            "quiz_pending:{$quiz->id}"
        );
    }

    /** N correct answers in a row in one subject. */
    public static function streakMilestone(User|int $user, Subject $subject, int $streak, bool $isRecord): ?Alert
    {
        $body = "{$subject->name}: {$streak} questions answered correctly in a row.";

        if ($isRecord) {
            $body .= " That's your new best!";
        }

        return self::notify(
            $user,
            Alert::TYPE_STREAK,
            "{$streak} correct in a row!",
            $body,
            ['subject_id' => $subject->id, 'subject_name' => $subject->name],
            // One per subject / milestone / day, however often it is reached.
            "streak:{$subject->id}:{$streak}:" . now()->toDateString()
        );
    }

    /** New questions were added to a subject -- tells everyone who follows it. */
    public static function newMcqs(Subject $subject, int $count): int
    {
        if ($count < 1) {
            return 0;
        }

        $title = $count === 1 ? '1 new MCQ added' : "{$count} new MCQs added";
        $body = "{$subject->name} has new practice questions. Try them now!";
        $data = ['subject_id' => $subject->id, 'subject_name' => $subject->name];
        $sent = 0;

        DB::table('user_subjects')
            ->where('subject_id', $subject->id)
            ->where('is_active', true)
            ->orderBy('id')
            ->chunkById(500, function ($rows) use ($title, $body, $data, &$sent) {
                foreach ($rows as $row) {
                    if (self::notify($row->user_id, Alert::TYPE_NEW_MCQS, $title, $body, $data)) {
                        $sent++;
                    }
                }
            });

        return $sent;
    }

    /** A random question sent as a study reminder -- tap to answer it. */
    public static function studyReminder(User $user, Mcq $mcq): ?Alert
    {
        $mcq->loadMissing(['topic:id,name,subject_id', 'topic.subject:id,name']);

        $subjectName = $mcq->topic?->subject?->name;

        $alert = self::notify(
            $user,
            Alert::TYPE_STUDY_REMINDER,
            $subjectName ? "Time to practise: {$subjectName}" : 'Time to practise',
            Str::limit($mcq->question, 140),
            [
                'mcq_id' => $mcq->id,
                'topic_id' => $mcq->topic_id,
                'topic_name' => $mcq->topic?->name,
                'subject_id' => $mcq->topic?->subject_id,
                'subject_name' => $subjectName,
            ]
        );

        if ($alert) {
            self::pruneStudyReminders($user->id);
        }

        return $alert;
    }

    // ---------------------------------------------------------------
    // Time-based alerts, created ON DEMAND
    //
    // These used to need `php artisan schedule:work` running all the
    // time. Now they are created the moment the app asks for the user's
    // alerts (Home badge check, Alerts screen -- both poll every 30-60
    // seconds while the app is open). Alerts are only ever *seen* inside
    // the app, so nothing is lost -- and no terminal / cron is required.
    // The scheduler command (alerts:generate) still works as an optional
    // extra and uses exactly the same code.
    // ---------------------------------------------------------------

    /** Bring one user's time-based alerts up to date. Never throws. */
    public static function refreshFor(User $user): void
    {
        try {
            self::studyReminderIfDue($user);
            self::nudgeAbandonedQuizzes($user);
        } catch (Throwable $e) {
            report($e);
        }
    }

    /**
     * Send one random question if the user has reminders switched on, is
     * inside their start/stop window and their "MCQs per hour" says the
     * next one is due.
     */
    public static function studyReminderIfDue(User $user): ?Alert
    {
        if (! $user->study_alerts_active || (int) $user->mcqs_per_hour < 1) {
            return null;
        }

        $localTime = now(config('alerts.timezone'))->format('H:i');

        if (! self::withinWindow($localTime, $user->notify_start_at, $user->notify_stop_at)) {
            return null;
        }

        // 3 per hour = one every 20 minutes. The app checks every 30-60s,
        // so allow 30s of slack.
        $intervalSeconds = (int) round(3600 / max(1, (int) $user->mcqs_per_hour));
        $cutoff = now()->subSeconds(max(0, $intervalSeconds - 30));

        if ($user->last_study_alert_at && $user->last_study_alert_at->gt($cutoff)) {
            return null;
        }

        $mcq = self::pickQuestion($user);

        if (! $mcq) {
            return null;
        }

        // Claim this slot with one atomic UPDATE. If two requests arrive at
        // the same moment (two tabs, phone + laptop), only one wins.
        $claimed = User::query()
            ->whereKey($user->id)
            ->where(function ($query) use ($cutoff) {
                $query->whereNull('last_study_alert_at')
                    ->orWhere('last_study_alert_at', '<=', $cutoff);
            })
            ->update(['last_study_alert_at' => now()]);

        if ($claimed !== 1) {
            return null;
        }

        return self::studyReminder($user, $mcq);
    }

    /** One nudge for each of the user's quizzes that was abandoned. */
    public static function nudgeAbandonedQuizzes(User $user): void
    {
        Quiz::query()
            ->where('user_id', $user->id)
            ->where('status', Quiz::STATUS_PENDING)
            ->where('created_at', '<=', now()->subHour())
            ->where('created_at', '>=', now()->subDays(3))
            ->with(['subject:id,name', 'topic:id,name'])
            ->get()
            ->each(fn (Quiz $quiz) => self::nudgeIfAbandoned($quiz));
    }

    /**
     * A quiz counts as abandoned once its timer (+15 min, at least an
     * hour) has run out without a submit. One nudge per quiz, ever.
     */
    public static function nudgeIfAbandoned(Quiz $quiz): ?Alert
    {
        $due = $quiz->created_at->copy()->addMinutes(max(60, $quiz->minutes + 15));

        if ($due->isFuture()) {
            return null;
        }

        return self::pendingQuiz($quiz);
    }

    /**
     * Is "HH:MM" inside the user's start/stop window? Empty start/stop mean
     * "all day", and a window like 22:00-06:00 may run past midnight.
     */
    public static function withinWindow(string $time, ?string $start, ?string $stop): bool
    {
        $start = $start ?: '00:00';
        $stop = $stop ?: '23:59';

        if ($start <= $stop) {
            return $time >= $start && $time <= $stop;
        }

        return $time >= $start || $time <= $stop;
    }

    /**
     * A random question from the subjects the user has switched on under
     * "My Subjects" (null when there are none).
     */
    private static function pickQuestion(User $user): ?Mcq
    {
        $subjectIds = DB::table('user_subjects')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->pluck('subject_id');

        if ($subjectIds->isEmpty()) {
            return null;
        }

        return Mcq::query()
            ->whereHas('topic', fn ($query) => $query->whereIn('subject_id', $subjectIds))
            ->inRandomOrder()
            ->first();
    }

    /** First alert every new account sees, so the inbox is never empty. */
    public static function welcome(User $user): ?Alert
    {
        return self::notify(
            $user,
            Alert::TYPE_WELCOME,
            'Welcome to StudyVertex!',
            'Add subjects from "Find More", then try Study Now or create a quiz. '
                . 'Switch on Study Reminders here to get MCQs during the day.',
            [],
            'welcome'
        );
    }

    /** Keep only the newest STUDY_REMINDERS_KEPT reminders so the inbox never floods. */
    private static function pruneStudyReminders(int $userId): void
    {
        try {
            $keep = Alert::where('user_id', $userId)
                ->where('type', Alert::TYPE_STUDY_REMINDER)
                ->orderByDesc('id')
                ->limit(self::STUDY_REMINDERS_KEPT)
                ->pluck('id');

            Alert::where('user_id', $userId)
                ->where('type', Alert::TYPE_STUDY_REMINDER)
                ->whereNotIn('id', $keep)
                ->delete();
        } catch (Throwable $e) {
            report($e);
        }
    }
}
