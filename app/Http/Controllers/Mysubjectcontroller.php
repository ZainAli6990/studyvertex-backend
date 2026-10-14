<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MySubjectController extends Controller
{
    /**
     * Shape one subject for the "My Subjects" cards. "mcqs_count" is
     * the number of questions actually stored for the subject, so the
     * "{n} MCQs" button opens exactly that many questions.
     */
    private function present(Subject $subject, bool $isActive): array
    {
        return [
            'id' => $subject->id,
            'category_id' => $subject->category_id,
            'category_name' => $subject->category?->name,
            'name' => $subject->name,
            'icon' => $subject->icon,
            'web_url' => $subject->web_url,
            'mcqs_count' => (int) ($subject->available_mcqs_count ?? $subject->mcqs()->count()),
            'catalog_mcqs_count' => (int) $subject->getAttributes()['mcqs_count'],
            'topics_count' => (int) ($subject->topics_count ?? $subject->topics()->count()),
            'is_active' => $isActive,
        ];
    }

    /**
     * List the subjects the current user has added to "My Subjects".
     */
    public function index(Request $request)
    {
        $subjects = $request->user()
            ->subjects()
            ->with('category:id,name')
            ->withCount(['mcqs as available_mcqs_count', 'topics'])
            ->orderBy('subjects.name')
            ->get();

        $subjects = $subjects->map(function (Subject $subject) {
            return $this->present($subject, (bool) $subject->pivot->is_active);
        });

        return response()->json([
            'success' => true,
            'subjects' => $subjects,
        ], 200);
    }

    /**
     * Add a subject to "My Subjects" (the "Yes" on the confirmation
     * dialog shown after tapping "Add"). Every subject in "Find More"
     * carries its own topics and questions, so practice is available
     * straight after adding.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'integer', Rule::exists('subjects', 'id')],
        ]);

        $user = $request->user();

        $user->subjects()->syncWithoutDetaching([
            $validated['subject_id'] => ['is_active' => true],
        ]);

        $subject = Subject::with('category:id,name')
            ->withCount(['mcqs as available_mcqs_count', 'topics'])
            ->findOrFail($validated['subject_id']);

        return response()->json([
            'success' => true,
            'subject' => $this->present($subject, true),
        ], 201);
    }

    /**
     * Flip the purple toggle on a "My Subjects" card.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $request->user()->subjects()->updateExistingPivot($subject->id, [
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'success' => true,
            'subject_id' => $subject->id,
            'is_active' => $validated['is_active'],
        ], 200);
    }

    /**
     * "Remove" button on a "My Subjects" card -- the subject becomes
     * available again on its category's "Find More" list.
     */
    public function destroy(Request $request, Subject $subject)
    {
        $request->user()->subjects()->detach($subject->id);

        return response()->json([
            'success' => true,
        ], 200);
    }
}
