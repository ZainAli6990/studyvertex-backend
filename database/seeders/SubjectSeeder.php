<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Seed the subjects shown inside each category on the "Find More"
     * -> category -> "Next" screen, taken from the reference screenshots.
     */
    public function run(): void
    {
        $this->seedCategory('Advanced Coding Languages', [
            ['name' => 'Bootstrap', 'mcqs_count' => 623],
            ['name' => 'C++ (OOP)', 'mcqs_count' => 487],
            ['name' => 'CSS (Cascading Style Sheets)', 'mcqs_count' => 538],
            ['name' => 'HTML', 'mcqs_count' => 740],
            ['name' => 'Java (OOP)', 'mcqs_count' => 399],
            ['name' => 'JavaScript', 'mcqs_count' => 472],
            ['name' => 'Kotlin Basic & Advance', 'mcqs_count' => 320],
            ['name' => 'Node.js', 'mcqs_count' => 472],
            ['name' => 'PHP (Hypertext Preprocessor)', 'mcqs_count' => 378],
            ['name' => 'Python', 'mcqs_count' => 544],
            ['name' => 'Swift', 'mcqs_count' => 568],
            ['name' => 'Wordpress', 'mcqs_count' => 597],
        ]);

        $this->seedCategory('Advanced English Learning', [
            ['name' => 'Speaking English Skills', 'mcqs_count' => 1793],
        ]);

        $this->seedCategory('General Subjects', [
            ['name' => 'Computer Basics', 'mcqs_count' => 784],
            ['name' => 'General Knowledge', 'mcqs_count' => 973],
        ]);

        $this->seedCategory('Khwaja Fareed University (KFUEIT)', [
            ['name' => 'Computer Networks', 'mcqs_count' => 612],
            ['name' => 'Data Structure & Algorithm', 'mcqs_count' => 532],
            ['name' => 'Design & Analysis of Algorithms', 'mcqs_count' => 1004],
            ['name' => 'Object Oriented Programming (OOP)', 'mcqs_count' => 212],
            ['name' => 'Web Programming', 'mcqs_count' => 81],
        ]);

        $this->seedCategory('Productivity & Design Tools', [
            ['name' => 'MS Excel Learning', 'mcqs_count' => 522],
            ['name' => 'MS Word Learning', 'mcqs_count' => 420],
            ['name' => 'Photoshop Learning', 'mcqs_count' => 753],
        ]);

        $this->seedCategory('Punjab Board of Intermediate', [
            ['name' => '1st Year Biology', 'mcqs_count' => 478],
            ['name' => '1st Year Chemistry', 'mcqs_count' => 325],
            ['name' => '1st Year Computer Science', 'mcqs_count' => 345],
            ['name' => '1st Year English', 'mcqs_count' => 716],
            ['name' => '1st Year Islamiat', 'mcqs_count' => 64],
            ['name' => '1st Year Mathematics', 'mcqs_count' => 15],
            ['name' => '1st Year Physics', 'mcqs_count' => 1141],
            ['name' => '1st Year Sociology (Eng)', 'mcqs_count' => 203],
            ['name' => '1st Year Sociology (Urdu)', 'mcqs_count' => 192],
            ['name' => '2nd Year Biology', 'mcqs_count' => 698],
            ['name' => '2nd Year Chemistry', 'mcqs_count' => 319],
            ['name' => '2nd Year Computer Science', 'mcqs_count' => 625],
            ['name' => '2nd Year Education (Eng)', 'mcqs_count' => 114],
            ['name' => '2nd Year Education (Urdu)', 'mcqs_count' => 84],
            ['name' => '2nd Year English', 'mcqs_count' => 1018],
            ['name' => '2nd Year Pak Study (Eng)', 'mcqs_count' => 131],
            ['name' => '2nd Year Pak Study (Urdu)', 'mcqs_count' => 117],
            ['name' => '2nd Year Physics', 'mcqs_count' => 263],
            ['name' => '2nd Year Sociology (Eng)', 'mcqs_count' => 235],
            ['name' => '2nd Year Sociology (Urdu)', 'mcqs_count' => 219],
        ]);
    }

    /**
     * Create/update every subject in $subjects under the category named
     * $categoryName, and keep that category's "N Subjects" badge in
     * sync with how many subjects it actually has.
     */
    private function seedCategory(string $categoryName, array $subjects): void
    {
        $category = Category::where('name', $categoryName)->first();

        if (! $category) {
            return;
        }

        foreach ($subjects as $index => $subject) {
            Subject::updateOrCreate(
                ['category_id' => $category->id, 'name' => $subject['name']],
                [
                    'category_id' => $category->id,
                    'name' => $subject['name'],
                    'icon' => $subject['icon'] ?? '📚',
                    'mcqs_count' => $subject['mcqs_count'],
                    'sort_order' => $index + 1,
                ]
            );
        }

        $category->update(['subjects_count' => count($subjects)]);
    }
}
