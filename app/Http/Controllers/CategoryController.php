<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List every category shown on the "Find More" subjects tab.
     *
     * The badge count shown on each card is the number of subjects in
     * that category the current user has NOT added to "My Subjects"
     * yet, so it counts down automatically as they add subjects.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $categories = Category::orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'icon', 'subjects_count']);

        $addedCounts = Subject::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $categories->each(function (Category $category) use ($addedCounts) {
            $added = $addedCounts[$category->id] ?? 0;
            $category->subjects_count = max($category->subjects_count - $added, 0);
        });

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ], 200);
    }
}
