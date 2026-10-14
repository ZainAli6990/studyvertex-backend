<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * List the subjects inside a category that the current user has
     * NOT already added to "My Subjects" (once added, a subject moves
     * out of this "Find More" list and into the My Subjects tab).
     */
    public function index(Request $request, Category $category)
    {
        $userId = $request->user()->id;

        $subjects = $category->subjects()
            ->withCount(['mcqs as available_mcqs_count'])
            ->whereDoesntHave('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get(['id', 'category_id', 'name', 'icon', 'mcqs_count'])
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'category_id' => $subject->category_id,
                    'name' => $subject->name,
                    'icon' => $subject->icon,
                    // The badge shows how many questions are really
                    // practiceable, so the count on the card and the
                    // count on the Topic Questions screen always agree.
                    'mcqs_count' => (int) $subject->available_mcqs_count,
                    'catalog_mcqs_count' => (int) $subject->getAttributes()['mcqs_count'],
                ];
            });

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'subjects' => $subjects,
        ], 200);
    }

    /**
     * Every subject in the catalog (not filtered by "My Subjects"), for
     * the Subject dropdown on the "NEW QUIZ" screen.
     */
    public function all()
    {
        $subjects = Subject::query()
            ->withCount(['mcqs as available_mcqs_count'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'category_id', 'name', 'icon'])
            ->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'category_id' => $subject->category_id,
                    'name' => $subject->name,
                    'icon' => $subject->icon,
                    'mcqs_count' => (int) $subject->available_mcqs_count,
                ];
            });

        return response()->json([
            'success' => true,
            'subjects' => $subjects,
        ], 200);
    }
}
