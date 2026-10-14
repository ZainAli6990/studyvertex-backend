<?php

namespace App\Console\Commands;

use App\Models\Mcq;
use App\Models\Subject;
use App\Models\Topic;
use App\Services\AlertService;
use Illuminate\Console\Command;

/**
 * Bulk-load a question bank from CSV, so the full set of questions for
 * a subject can be added without touching any code.
 *
 *   php artisan mcqs:import storage/app/bank.csv
 *
 * Expected header row (order matters, extra columns are ignored):
 *
 *   subject,topic,question,option_a,option_b,option_c,option_d,correct
 *
 * "correct" may be 1-4, or the letter A-D. Topics that don't exist yet
 * are created automatically under the named subject. Re-importing the
 * same file updates existing questions instead of duplicating them.
 */
class ImportMcqs extends Command
{
    protected $signature = 'mcqs:import {file : Path to the CSV file}
                            {--truncate-topic : Delete a topic\'s existing questions before importing into it}
                            {--no-alerts : Do not tell users who follow the subjects about the new questions}';

    protected $description = 'Import MCQs in bulk from a CSV file';

    public function handle(): int
    {
        $path = $this->argument('file');

        if (! is_file($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $handle = fopen($path, 'r');

        if ($handle === false) {
            $this->error("Could not open: {$path}");

            return self::FAILURE;
        }

        // Skip the header row.
        $header = fgetcsv($handle);

        if ($header === false) {
            $this->error('The file appears to be empty.');
            fclose($handle);

            return self::FAILURE;
        }

        $imported = 0;
        $skipped = 0;
        $line = 1;
        $clearedTopics = [];
        $subjectCache = [];
        $topicCache = [];
        $sortCounters = [];
        $newBySubject = [];

        while (($row = fgetcsv($handle)) !== false) {
            $line++;

            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) {
                continue;
            }

            if (count($row) < 8) {
                $this->warn("Line {$line}: needs 8 columns, skipped.");
                $skipped++;
                continue;
            }

            [$subjectName, $topicName, $question, $a, $b, $c, $d, $correct] = array_map(
                fn ($value) => trim((string) $value),
                array_slice($row, 0, 8)
            );

            $correctIndex = $this->correctIndex($correct);

            if ($subjectName === '' || $topicName === '' || $question === '' || $correctIndex === null) {
                $this->warn("Line {$line}: missing subject, topic, question or a valid correct answer, skipped.");
                $skipped++;
                continue;
            }

            $subject = $subjectCache[$subjectName]
                ??= Subject::where('name', $subjectName)->first();

            if (! $subject) {
                $this->warn("Line {$line}: no subject named \"{$subjectName}\", skipped.");
                $skipped++;
                continue;
            }

            $topicKey = $subject->id.'|'.$topicName;

            $topic = $topicCache[$topicKey] ??= Topic::firstOrCreate(
                ['subject_id' => $subject->id, 'name' => $topicName],
                [
                    'icon' => '📖',
                    'sort_order' => (int) Topic::where('subject_id', $subject->id)->max('sort_order') + 1,
                ]
            );

            if ($this->option('truncate-topic') && ! isset($clearedTopics[$topic->id])) {
                Mcq::where('topic_id', $topic->id)->delete();
                $clearedTopics[$topic->id] = true;
                $sortCounters[$topic->id] = 0;
            }

            $sortCounters[$topic->id] ??= (int) Mcq::where('topic_id', $topic->id)->max('sort_order');
            $sortCounters[$topic->id]++;

            $mcq = Mcq::updateOrCreate(
                ['topic_id' => $topic->id, 'question' => $question],
                [
                    'topic_id' => $topic->id,
                    'question' => $question,
                    'options' => [$a, $b, $c, $d],
                    'correct_index' => $correctIndex,
                    'sort_order' => $sortCounters[$topic->id],
                ]
            );

            if ($mcq->wasRecentlyCreated) {
                $newBySubject[$subject->id]['subject'] = $subject;
                $newBySubject[$subject->id]['count'] = ($newBySubject[$subject->id]['count'] ?? 0) + 1;
            }

            $imported++;

            if ($imported % 500 === 0) {
                $this->info("... {$imported} questions imported");
            }
        }

        fclose($handle);

        $this->newLine();
        $this->info("Imported/updated: {$imported}");

        if ($skipped > 0) {
            $this->warn("Skipped: {$skipped}");
        }

        $this->call('mcqs:sync-counts');

        // Tell everyone who follows a subject that it has new questions.
        if (! $this->option('no-alerts')) {
            foreach ($newBySubject as $entry) {
                $sent = AlertService::newMcqs($entry['subject'], $entry['count']);
                $this->info("Alerted {$sent} user(s) about {$entry['count']} new MCQ(s) in {$entry['subject']->name}.");
            }
        }

        return self::SUCCESS;
    }

    /**
     * Accept 1-4, 0-3 with a leading "#", or the letters A-D.
     */
    private function correctIndex(string $value): ?int
    {
        $value = strtoupper(trim($value));

        if ($value === '') {
            return null;
        }

        $letters = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3];

        if (isset($letters[$value])) {
            return $letters[$value];
        }

        if (is_numeric($value)) {
            $number = (int) $value;

            if ($number >= 1 && $number <= 4) {
                return $number - 1;
            }
        }

        return null;
    }
}