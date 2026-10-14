<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Mcq;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class StudyTestSeeder extends Seeder
{
    /**
     * Seed the Study Test category, subject, topics and MCQs.
     *
     * Structure:
     *
     * Study Test (Category)
     *      ↓
     * Study Test (Subject)
     *      ↓
     * ┌──────────────────────┬──────────────────────┬─────────┐
     * │ General Knowledge    │ Computer Basics      │ English │
     * │ 10 MCQs              │ 10 MCQs              │ 10 MCQs │
     * └──────────────────────┴──────────────────────┴─────────┘
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Find the Study Test category
        |--------------------------------------------------------------------------
        */

        $category = Category::where('name', 'Study Test')->first();

        if (! $category) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Find the Study Test subject
        |--------------------------------------------------------------------------
        */

        $subject = Subject::where('category_id', $category->id)
            ->where('name', 'Study Test')
            ->first();

        if (! $subject) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Question bank
        |--------------------------------------------------------------------------
        */

        $bank = [

            /*
            |--------------------------------------------------------------------------
            | GENERAL KNOWLEDGE
            |--------------------------------------------------------------------------
            */

            'General Knowledge' => [

                [
                    'q' => 'What is the capital of Pakistan?',
                    'options' => [
                        'Lahore',
                        'Karachi',
                        'Islamabad',
                        'Peshawar',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'What is the largest continent by area?',
                    'options' => [
                        'Africa',
                        'Asia',
                        'Europe',
                        'North America',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Which planet is known as the Red Planet?',
                    'options' => [
                        'Venus',
                        'Jupiter',
                        'Mars',
                        'Saturn',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'How many continents are there on Earth?',
                    'options' => [
                        '5',
                        '6',
                        '7',
                        '8',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which is the largest ocean on Earth?',
                    'options' => [
                        'Atlantic Ocean',
                        'Indian Ocean',
                        'Arctic Ocean',
                        'Pacific Ocean',
                    ],
                    'correct' => 3,
                ],

                [
                    'q' => 'Who wrote the national anthem of Pakistan?',
                    'options' => [
                        'Allama Iqbal',
                        'Hafeez Jalandhari',
                        'Faiz Ahmed Faiz',
                        'Ahmed Faraz',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Which gas do humans need to breathe to survive?',
                    'options' => [
                        'Carbon dioxide',
                        'Nitrogen',
                        'Oxygen',
                        'Hydrogen',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'How many days are there in a leap year?',
                    'options' => [
                        '364',
                        '365',
                        '366',
                        '367',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which is the smallest prime number?',
                    'options' => [
                        '0',
                        '1',
                        '2',
                        '3',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which organ pumps blood throughout the human body?',
                    'options' => [
                        'Brain',
                        'Lungs',
                        'Heart',
                        'Kidney',
                    ],
                    'correct' => 2,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | COMPUTER BASICS
            |--------------------------------------------------------------------------
            */

            'Computer Basics' => [

                [
                    'q' => 'What does CPU stand for?',
                    'options' => [
                        'Central Processing Unit',
                        'Computer Personal Unit',
                        'Central Program Utility',
                        'Computer Processing User',
                    ],
                    'correct' => 0,
                ],

                [
                    'q' => 'Which device is commonly used to type text into a computer?',
                    'options' => [
                        'Monitor',
                        'Keyboard',
                        'Speaker',
                        'Printer',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Which of these is an output device?',
                    'options' => [
                        'Keyboard',
                        'Mouse',
                        'Monitor',
                        'Scanner',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'What does RAM stand for?',
                    'options' => [
                        'Read Access Memory',
                        'Random Access Memory',
                        'Rapid Application Memory',
                        'Remote Access Module',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Which device is used to permanently store files?',
                    'options' => [
                        'RAM',
                        'CPU',
                        'SSD',
                        'Cache',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which of the following is an operating system?',
                    'options' => [
                        'Windows',
                        'Google',
                        'Intel',
                        'HTML',
                    ],
                    'correct' => 0,
                ],

                [
                    'q' => 'What is the main purpose of a web browser?',
                    'options' => [
                        'To create electricity',
                        'To access and view websites',
                        'To format hard drives',
                        'To print documents only',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Which keyboard shortcut is commonly used to copy selected text?',
                    'options' => [
                        'Ctrl + X',
                        'Ctrl + V',
                        'Ctrl + C',
                        'Ctrl + Z',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'What does USB commonly stand for?',
                    'options' => [
                        'Universal Serial Bus',
                        'United System Board',
                        'Universal System Backup',
                        'User Serial Block',
                    ],
                    'correct' => 0,
                ],

                [
                    'q' => 'Which number system is primarily used by computers internally?',
                    'options' => [
                        'Decimal',
                        'Binary',
                        'Roman',
                        'Hexadecimal only',
                    ],
                    'correct' => 1,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | ENGLISH
            |--------------------------------------------------------------------------
            */

            'English' => [

                [
                    'q' => 'Choose the correct plural of "child".',
                    'options' => [
                        'Childs',
                        'Childes',
                        'Children',
                        'Childrens',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Choose the correct article: "He is ___ honest man."',
                    'options' => [
                        'a',
                        'an',
                        'the',
                        'no article',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'What is the opposite of "ancient"?',
                    'options' => [
                        'Old',
                        'Modern',
                        'Historic',
                        'Past',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'Choose the correct verb: "She ___ to school every day."',
                    'options' => [
                        'go',
                        'going',
                        'goes',
                        'gone',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which word is a synonym of "happy"?',
                    'options' => [
                        'Sad',
                        'Angry',
                        'Joyful',
                        'Tired',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Identify the noun in this sentence: "Ali plays cricket."',
                    'options' => [
                        'plays',
                        'cricket',
                        'Ali',
                        'plays cricket',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Choose the correct past tense of "go".',
                    'options' => [
                        'Goed',
                        'Gone',
                        'Went',
                        'Going',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Which sentence is grammatically correct?',
                    'options' => [
                        'He do his work.',
                        'He does his work.',
                        'He doing his work.',
                        'He done his work.',
                    ],
                    'correct' => 1,
                ],

                [
                    'q' => 'What is the comparative form of "good"?',
                    'options' => [
                        'Gooder',
                        'Best',
                        'Better',
                        'More good',
                    ],
                    'correct' => 2,
                ],

                [
                    'q' => 'Choose the correct preposition: "The book is ___ the table."',
                    'options' => [
                        'in',
                        'on',
                        'at',
                        'by',
                    ],
                    'correct' => 1,
                ],
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | 4. Create/update topics and MCQs
        |--------------------------------------------------------------------------
        */

        foreach ($bank as $topicName => $questions) {

            $topic = Topic::where('subject_id', $subject->id)
                ->where('name', $topicName)
                ->first();

            if (! $topic) {
                continue;
            }

            foreach ($questions as $index => $item) {

                Mcq::updateOrCreate(
                    [
                        'topic_id' => $topic->id,
                        'question' => $item['q'],
                    ],
                    [
                        'topic_id' => $topic->id,
                        'question' => $item['q'],
                        'options' => $item['options'],
                        'correct_index' => $item['correct'],
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Update MCQ count
        |--------------------------------------------------------------------------
        */

        $subject->forceFill([
            'mcqs_count' => Mcq::whereIn(
                'topic_id',
                $subject->topics()->pluck('id')
            )->count(),
        ])->save();

        /*
        |--------------------------------------------------------------------------
        | 6. Update category subject count
        |--------------------------------------------------------------------------
        */

        $category->forceFill([
            'subjects_count' => $category->subjects()->count(),
        ])->save();
    }
}

