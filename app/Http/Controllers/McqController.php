<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use App\Models\Topic;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McqController extends Controller
{
    /**
     * Fetch one question to practice from this topic (used for the
     * first question, "Skip", and "Another Q").
     */
    public function next(Topic $topic)
    {
        $mcq = $topic->mcqs()->inRandomOrder()->first();

        if (! $mcq) {
            return response()->json([
                'success' => false,
                'message' => 'No MCQs available for this topic yet.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'subject' => [
                'id' => $topic->subject->id,
                'name' => $topic->subject->name,
            ],
            'topic' => [
                'id' => $topic->id,
                'name' => $topic->name,
            ],
            'mcq' => [
                'id' => $mcq->id,
                'question' => $mcq->question,
                'options' => $mcq->options,
            ],
        ], 200);
    }

    /**
     * One specific question -- opened when the user taps a study-reminder
     * alert. Same shape as next() so the Question screen can show either.
     */
    public function show(Mcq $mcq)
    {
        $mcq->load(['topic:id,name,subject_id', 'topic.subject:id,name']);

        if (! $mcq->topic) {
            return response()->json([
                'success' => false,
                'message' => 'This question is no longer available.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'subject' => [
                'id' => $mcq->topic->subject->id,
                'name' => $mcq->topic->subject->name,
            ],
            'topic' => [
                'id' => $mcq->topic->id,
                'name' => $mcq->topic->name,
            ],
            'mcq' => [
                'id' => $mcq->id,
                'question' => $mcq->question,
                'options' => $mcq->options,
            ],
        ], 200);
    }

    /**
     * "STUDY NOW" -- one random question pulled from across every
     * subject/topic, so the user can practice straight from the home
     * page without picking a subject first. Same shape as next().
     */
    public function studyNow(Request $request)
    {
        // Only questions from subjects this user added to "My Subjects".
        $mySubjectIds = $request->user()->subjects()->pluck('subjects.id');

        $mcq = Mcq::with(['topic:id,name,subject_id', 'topic.subject:id,name'])
            ->whereHas('topic', fn ($query) => $query->whereIn('subject_id', $mySubjectIds))
            ->inRandomOrder()
            ->first();

        if (! $mcq || ! $mcq->topic) {
            return response()->json([
                'success' => false,
                'message' => 'No MCQs available yet.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'subject' => [
                'id' => $mcq->topic->subject->id,
                'name' => $mcq->topic->subject->name,
            ],
            'topic' => [
                'id' => $mcq->topic->id,
                'name' => $mcq->topic->name,
            ],
            'mcq' => [
                'id' => $mcq->id,
                'question' => $mcq->question,
                'options' => $mcq->options,
            ],
        ], 200);
    }

    /**
     * Every question in a topic, with its options and which one is
     * correct -- this feeds the "TOPIC QUESTIONS" screen opened by
     * tapping the "{n} MCQs" badge on a topic card.
     */
    public function index(Topic $topic)
    {
        $topic->load('subject:id,name');

        $questions = $topic->mcqs()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->values()
            ->map(function (Mcq $mcq, int $position) {
                return [
                    'id' => $mcq->id,
                    'number' => $position + 1,
                    'question' => $mcq->question,
                    'options' => $mcq->options,
                    'correct_index' => (int) $mcq->correct_index,
                    'correct_text' => $mcq->options[$mcq->correct_index] ?? null,
                ];
            });

        return response()->json([
            'success' => true,
            'subject' => [
                'id' => $topic->subject?->id,
                'name' => $topic->subject?->name,
            ],
            'topic' => [
                'id' => $topic->id,
                'name' => $topic->name,
                'icon' => $topic->icon,
            ],
            'total' => $questions->count(),
            'questions' => $questions,
        ], 200);
    }

    /**
     * "Show" -- reveal the correct answer without attempting the
     * question. Doesn't touch the user's streak.
     */
    public function reveal(Request $request, Mcq $mcq)
    {
        // Counted on the REPORT screen (overall, and under its subject).
        $request->user()->increment('mcqs_shown');
        $this->bumpSubjectCounter($request->user()->id, $mcq->topic?->subject_id, 'mcqs_shown');

        return response()->json([
            'success' => true,
            'correct_index' => $mcq->correct_index,
            'correct_text' => $mcq->options[$mcq->correct_index] ?? null,
        ], 200);
    }

    /**
     * "Skip" -- move on without answering. Counted on the REPORT screen;
     * doesn't touch streaks (that would let a bad streak be dodged).
     */
    public function skip(Request $request)
    {
        $validated = $request->validate([
            'mcq_id' => ['nullable', 'integer', 'exists:mcqs,id'],
        ]);

        $request->user()->increment('mcqs_skipped');

        // The app sends the question it skipped, so the skip can also be
        // counted under that question's subject.
        if (! empty($validated['mcq_id'])) {
            $skipped = Mcq::with('topic')->find($validated['mcq_id']);

            $this->bumpSubjectCounter(
                $request->user()->id,
                $skipped?->topic?->subject_id,
                'mcqs_skipped'
            );
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Grade a submitted answer and update the user's current/maximum
     * answer streak for that subject.
     */
    public function submit(Request $request, Mcq $mcq)
    {
        $validated = $request->validate([
            'selected_index' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $isCorrect = (int) $validated['selected_index'] === (int) $mcq->correct_index;

        // Counted on the REPORT screen.
        $request->user()->increment($isCorrect ? 'mcqs_correct' : 'mcqs_incorrect');

        $userId = $request->user()->id;
        $subjectId = $mcq->topic->subject_id;

        $pivot = DB::table('user_subjects')
            ->where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->first();

        $currentStreak = $pivot->current_streak ?? 0;
        $maxStreak = $pivot->max_streak ?? 0;
        $previousMax = $maxStreak;

        if ($isCorrect) {
            $currentStreak += 1;
            $maxStreak = max($maxStreak, $currentStreak);
        } else {
            $currentStreak = 0;
        }

        if ($pivot) {
            DB::table('user_subjects')
                ->where('user_id', $userId)
                ->where('subject_id', $subjectId)
                ->update([
                    'current_streak' => $currentStreak,
                    'max_streak' => $maxStreak,
                    'updated_at' => now(),
                ]);
        } else {
            // The subject wasn't in "My Subjects" (edge case) -- add it
            // so the streak has somewhere to live.
            DB::table('user_subjects')->insert([
                'user_id' => $userId,
                'subject_id' => $subjectId,
                'is_active' => true,
                'current_streak' => $currentStreak,
                'max_streak' => $maxStreak,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Correct / Incorrect under this subject (REPORT > your name).
        $this->bumpSubjectCounter($userId, $subjectId, $isCorrect ? 'mcqs_correct' : 'mcqs_incorrect');

        // 5, 10, 15... correct in a row earns a "keep it up" alert.
        if ($isCorrect && in_array($currentStreak, AlertService::STREAK_MILESTONES, true)) {
            AlertService::streakMilestone(
                $userId,
                $mcq->topic->subject,
                $currentStreak,
                $currentStreak > $previousMax
            );
        }

        return response()->json([
            'success' => true,
            'correct' => $isCorrect,
            'correct_index' => $mcq->correct_index,
            'correct_text' => $mcq->options[$mcq->correct_index] ?? null,
            'current_streak' => $currentStreak,
            'max_streak' => $maxStreak,
        ], 200);
    }

    /**
     * Adds 1 to one of the per-subject counters on user_subjects. Only
     * touches an existing My Subjects row; $column is always one of our
     * own fixed column names (never request input).
     */
    private function bumpSubjectCounter(int $userId, ?int $subjectId, string $column): void
    {
        if (! $subjectId) {
            return;
        }

        DB::table('user_subjects')
            ->where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->increment($column, 1, ['last_scored_at' => now()]);
    }
}
