<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Console\Command;

/**
 * Rewrite every subject's stored "mcqs_count" so it matches the number
 * of questions actually in the database, and refresh each category's
 * subject count.
 *
 *   php artisan mcqs:sync-counts
 *
 * Run this after importing a question bank. The API already counts
 * live, so this only keeps the stored column honest for anything that
 * reads it directly.
 */
class SyncMcqCounts extends Command
{
    protected $signature = 'mcqs:sync-counts';

    protected $description = 'Sync stored subject MCQ counts with the real number of questions';

    public function handle(): int
    {
        $subjects = Subject::withCount(['mcqs as real_mcqs_count'])->get();

        $changed = 0;

        foreach ($subjects as $subject) {
            $real = (int) $subject->real_mcqs_count;

            if ((int) $subject->getAttributes()['mcqs_count'] !== $real) {
                $subject->forceFill(['mcqs_count' => $real])->save();
                $changed++;
            }
        }

        foreach (Category::withCount('subjects')->get() as $category) {
            $category->forceFill(['subjects_count' => $category->subjects_count])->save();
        }

        $this->info("Subjects updated: {$changed} of {$subjects->count()}");
        $this->info('Total questions: '.$subjects->sum('real_mcqs_count'));

        return self::SUCCESS;
    }
}
