<?php

namespace Database\Seeders;

use App\Models\Mcq;
use App\Models\Subject;
use App\Models\Topic;

/**
 * Shared insert logic for every MCQ bank seeder.
 *
 * A bank is shaped:
 *   'Subject Name' => [
 *       'Topic Name' => [
 *           ['q' => '...', 'options' => ['a','b','c','d'], 'correct' => 2],
 *       ],
 *   ]
 *
 * Questions are matched on (topic_id, question) so re-running a seeder
 * updates instead of duplicating, and sort_order gives the stable
 * numbering used by the "TOPIC QUESTIONS" screen.
 */
trait SeedsMcqs
{
    protected function seedBank(array $bank): void
    {
        foreach ($bank as $subjectName => $topics) {
            $subject = Subject::where('name', $subjectName)->first();

            if (! $subject) {
                continue;
            }

            foreach ($topics as $topicName => $questions) {
                $topic = Topic::where('subject_id', $subject->id)
                    ->where('name', $topicName)
                    ->first();

                if (! $topic) {
                    continue;
                }

                $offset = (int) Mcq::where('topic_id', $topic->id)->max('sort_order');

                foreach ($questions as $index => $question) {
                    Mcq::updateOrCreate(
                        ['topic_id' => $topic->id, 'question' => $question['q']],
                        [
                            'topic_id' => $topic->id,
                            'question' => $question['q'],
                            'options' => $question['options'],
                            'correct_index' => $question['correct'],
                            'sort_order' => $offset + $index + 1,
                        ]
                    );
                }
            }
        }
    }
}
