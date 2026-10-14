<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
            SubjectSeeder::class,
            TopicSeeder::class,
            McqSeeder::class,
            McqTechSeeder::class,
            McqBoardSeeder::class,
            McqBankBatchTwoSeeder::class,
            McqBankBatchThreeSeeder::class,
            McqBankBatchFourSeeder::class,
            StudyTestSeeder::class,
        ]);

        // Keep each subject's stored MCQ count in step with the real number of questions.
        $this->command?->call('mcqs:sync-counts');
    }
}
