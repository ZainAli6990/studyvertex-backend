<?php

namespace App\Console\Commands;

use App\Models\Quiz;
use App\Models\User;
use App\Services\AlertService;
use Illuminate\Console\Command;

/**
 * OPTIONAL. Time-based alerts (study reminders, unfinished-quiz nudges)
 * are already created on demand whenever the app asks for a user's alerts
 * -- see AlertService::refreshFor() -- so this command is NOT required.
 *
 * Run it (or schedule it) only if you also want alerts prepared for people
 * who haven't opened the app in a while. It uses the very same rules as
 * the on-demand path, so both together never send anything twice.
 */
class GenerateAlerts extends Command
{
    protected $signature = 'alerts:generate
                            {--only= : Run just one job: "study" or "quizzes" (default: both)}';

    protected $description = 'Optional: create study reminders and unfinished-quiz nudges for everyone now';

    public function handle(): int
    {
        $only = $this->option('only');

        $study = 0;
        $quizzes = 0;

        if (! $only || $only === 'study') {
            $study = $this->studyReminders();
        }

        if (! $only || $only === 'quizzes') {
            $quizzes = $this->unfinishedQuizzes();
        }

        $this->info("Study reminders: {$study}, unfinished-quiz alerts: {$quizzes}");

        return self::SUCCESS;
    }

    private function studyReminders(): int
    {
        $created = 0;

        User::query()
            ->where('study_alerts_active', true)
            ->where('mcqs_per_hour', '>', 0)
            ->chunkById(200, function ($users) use (&$created) {
                foreach ($users as $user) {
                    if (AlertService::studyReminderIfDue($user)) {
                        $created++;
                    }
                }
            });

        return $created;
    }

    private function unfinishedQuizzes(): int
    {
        $created = 0;

        Quiz::query()
            ->where('status', Quiz::STATUS_PENDING)
            ->where('created_at', '<=', now()->subHour())
            ->where('created_at', '>=', now()->subDays(3))
            ->with(['subject:id,name', 'topic:id,name'])
            ->chunkById(200, function ($quizzes) use (&$created) {
                foreach ($quizzes as $quiz) {
                    if (AlertService::nudgeIfAbandoned($quiz)?->wasRecentlyCreated) {
                        $created++;
                    }
                }
            });

        return $created;
    }
}
