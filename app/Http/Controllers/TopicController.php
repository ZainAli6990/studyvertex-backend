<?php

namespace App\Http\Controllers;

use App\Models\Subject;

class TopicController extends Controller
{
    /**
     * List the topics inside a subject, for the screen opened by
     * tapping the "{n} MCQs" button on a "My Subjects" card.
     */
    public function index(Subject $subject)
    {
        $topics = $subject->topics()
            ->withCount('mcqs')
            ->get()
            ->map(function ($topic) {
                return [
                    'id' => $topic->id,
                    'name' => $topic->name,
                    'icon' => $topic->icon,
                    'mcqs_count' => $topic->mcqs_count,
                ];
            });

        return response()->json([
            'success' => true,
            'subject' => [
                'id' => $subject->id,
                'name' => $subject->name,
            ],
            'topics' => $topics,
        ], 200);
    }
}
