<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the categories shown on the "Find More" subjects tab.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Advanced Coding Languages',
                'icon' => '📚',
                'subjects_count' => 12,
                'sort_order' => 1,
            ],
            [
    'name' => 'Study Test',
    'icon' => '📚',
    'subjects_count' => 1,
    'sort_order' => 2,
],
            [
                'name' => 'Advanced English Learning',
                'icon' => '📚',
                'subjects_count' => 1,
                'sort_order' => 3,
            ],
            [
                'name' => 'General Subjects',
                'icon' => '📚',
                'subjects_count' => 2,
                'sort_order' => 4,
            ],
            [
                'name' => 'Khwaja Fareed University (KFUEIT)',
                'icon' => '📚',
                'subjects_count' => 5,
                'sort_order' => 5,
            ],
            [
                'name' => 'Productivity & Design Tools',
                'icon' => '📚',
                'subjects_count' => 3,
                'sort_order' => 6,
            ],
            [
                'name' => 'Punjab Board of Intermediate',
                'icon' => '📚',
                'subjects_count' => 20,
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
