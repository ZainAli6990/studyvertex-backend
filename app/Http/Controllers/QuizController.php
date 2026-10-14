<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Topic;
use App\Services\AlertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    /**
     * "QUIZES" screen -- every quiz the current user has created,
     * newest first.
     */
    public function index(Request $request): JsonResponse
    {
        $quizzes = $request->user()
            ->quizzes()
            ->with(['subject:id,name', 'topic:id,name'])
            ->latest()
            ->orderByDesc('id')
            ->get()
            ->map(fn (Quiz $quiz) => $this->summary($quiz));

        return response()->json([
            'success' => true,
            'quizzes' => $quizzes,
        ], 200);
    }

    /**
     * "NEW QUIZ" screen -- build a quiz from random MCQs of one topic.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'topic_id' => [
                'required',
                'integer',
                Rule::exists('topics', 'id')->where('subject_id', $request->input('subject_id')),
            ],
            'mcqs_count' => ['required', 'integer', 'min:1', 'max:500'],
            'minutes' => ['required', 'integer', 'min:1', 'max:600'],
        ], [
            'topic_id.exists' => 'The selected topic does not belong to this subject.',
        ]);

        $topic = Topic::findOrFail($validated['topic_id']);
        $available = $topic->mcqs()->count();

        if ($available === 0) {
            return response()->json([
                'success' => false,
                'message' => 'This topic has no MCQs yet.',
            ], 422);
        }

        if ($validated['mcqs_count'] > $available) {
            return response()->json([
                'success' => false,
                'message' => "This topic only has {$available} MCQs. Please enter {$available} or fewer.",
            ], 422);
        }

        $mcqs = $topic->mcqs()
            ->inRandomOrder()
            ->limit($validated['mcqs_count'])
            ->get();

        $quiz = DB::transaction(function () use ($request, $topic, $validated, $mcqs) {
            $quiz = Quiz::create([
                'user_id' => $request->user()->id,
                'subject_id' => $topic->subject_id,
                'topic_id' => $topic->id,
                'mcqs_count' => $mcqs->count(),
                'minutes' => $validated['minutes'],
                'status' => Quiz::STATUS_PENDING,
                'score' => 0,
            ]);

            $quiz->questions()->createMany(
                $mcqs->values()->map(fn ($mcq, int $position) => [
                    'mcq_id' => $mcq->id,
                    'position' => $position,
                    'question' => $mcq->question,
                    'options' => $mcq->options,
                    'correct_index' => $mcq->correct_index,
                ])->all()
            );

            return $quiz;
        });

        $quiz->load(['subject:id,name', 'topic:id,name']);

        return response()->json([
            'success' => true,
            'quiz' => $this->summary($quiz),
        ], 201);
    }

    /**
     * "QUIZ QUESTION" screen -- the quiz's fixed question set.
     * The correct answers are deliberately NOT included here.
     */
    public function start(Request $request, Quiz $quiz): JsonResponse
    {
        $this->ensureOwner($request, $quiz);

        if ($quiz->isCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'This quiz has already been submitted.',
            ], 409);
        }

        $quiz->load(['subject:id,name', 'topic:id,name', 'questions']);

        return response()->json([
            'success' => true,
            'quiz' => $this->summary($quiz),
            'questions' => $quiz->questions->map(fn (QuizQuestion $question) => [
                'id' => $question->id,
                'position' => $question->position,
                'question' => $question->question,
                'options' => $question->options,
            ])->values(),
        ], 200);
    }

    /**
     * Grade the answers. Sent as
     * { answers: [{ quiz_question_id, selected_index | null }, ...] }.
     * A quiz can only be graded once -- submitting again just returns the
     * stored result (so the timer auto-submit and a manual tap can't
     * overwrite each other).
     */
    public function submit(Request $request, Quiz $quiz): JsonResponse
    {
        $this->ensureOwner($request, $quiz);

        $validated = $request->validate([
            'answers' => ['present', 'array'],
            'answers.*.quiz_question_id' => ['required', 'integer'],
            'answers.*.selected_index' => ['nullable', 'integer', 'min:0', 'max:3'],
        ]);

        $picked = collect($validated['answers'])->mapWithKeys(
            fn (array $answer) => [(int) $answer['quiz_question_id'] => $answer['selected_index'] ?? null]
        );

        DB::transaction(function () use ($quiz, $picked) {
            // Re-read under a lock so two simultaneous submits can't both grade.
            $locked = Quiz::whereKey($quiz->id)->lockForUpdate()->first();

            if ($locked->isCompleted()) {
                return;
            }

            $score = 0;

            foreach ($locked->questions as $question) {
                $selected = $picked->get($question->id);
                $selected = $selected === null ? null : (int) $selected;

                // Ignore an index that isn't one of this question's options.
                if ($selected !== null && ! array_key_exists($selected, $question->options)) {
                    $selected = null;
                }

                $isCorrect = $selected !== null
                    && (int) $selected === (int) $question->correct_index;

                $question->update([
                    'selected_index' => $selected,
                    'is_correct' => $selected === null ? null : $isCorrect,
                ]);

                if ($isCorrect) {
                    $score++;
                }
            }

            $locked->update([
                'status' => Quiz::STATUS_COMPLETED,
                'score' => $score,
                'submitted_at' => now(),
            ]);
        });

        $quiz->refresh()->load(['subject:id,name', 'topic:id,name']);

        // Tell the user how they did. One alert per quiz: a duplicate or
        // late submit reuses the first one.
        AlertService::quizResult($quiz);

        return response()->json([
            'success' => true,
            'quiz' => $this->summary($quiz),
        ], 200);
    }

    /**
     * "QUIZ MCQS" screen -- score plus every question with the user's
     * answer next to the correct one.
     */
    public function review(Request $request, Quiz $quiz): JsonResponse
    {
        $this->ensureOwner($request, $quiz);

        if (! $quiz->isCompleted()) {
            return response()->json([
                'success' => false,
                'message' => 'Submit this quiz to see its results.',
            ], 409);
        }

        $quiz->load(['subject:id,name', 'topic:id,name', 'questions']);

        return response()->json([
            'success' => true,
            'quiz' => $this->summary($quiz),
            'questions' => $quiz->questions->map(fn (QuizQuestion $question) => [
                'id' => $question->id,
                'position' => $question->position,
                'question' => $question->question,
                'options' => $question->options,
                'selected_index' => $question->selected_index,
                'is_correct' => $question->is_correct === true,
                'selected_text' => $question->selected_index === null
                    ? null
                    : ($question->options[$question->selected_index] ?? null),
                'correct_index' => $question->correct_index,
                'correct_text' => $question->options[$question->correct_index] ?? null,
            ])->values(),
        ], 200);
    }

    /**
     * "Repeat" -- start a fresh attempt of a finished quiz with the very
     * same questions and time limit.
     */
    public function repeat(Request $request, Quiz $quiz): JsonResponse
    {
        $this->ensureOwner($request, $quiz);

        $quiz->load('questions');

        if ($quiz->questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'This quiz has no questions to repeat.',
            ], 422);
        }

        $copy = DB::transaction(function () use ($request, $quiz) {
            $copy = Quiz::create([
                'user_id' => $request->user()->id,
                'subject_id' => $quiz->subject_id,
                'topic_id' => $quiz->topic_id,
                'mcqs_count' => $quiz->questions->count(),
                'minutes' => $quiz->minutes,
                'status' => Quiz::STATUS_PENDING,
                'score' => 0,
            ]);

            $copy->questions()->createMany(
                $quiz->questions->map(fn (QuizQuestion $question) => [
                    'mcq_id' => $question->mcq_id,
                    'position' => $question->position,
                    'question' => $question->question,
                    'options' => $question->options,
                    'correct_index' => $question->correct_index,
                ])->all()
            );

            return $copy;
        });

        $copy->load(['subject:id,name', 'topic:id,name']);

        return response()->json([
            'success' => true,
            'quiz' => $this->summary($copy),
        ], 201);
    }

    /**
     * A quiz belongs to the user who created it -- anyone else gets a
     * 404, same as if it didn't exist.
     */
    private function ensureOwner(Request $request, Quiz $quiz): void
    {
        abort_if((int) $quiz->user_id !== (int) $request->user()->id, 404, 'Quiz not found.');
    }

    /**
     * The quiz card shape used by the list and echoed by the other
     * endpoints. Expects subject and topic to be loaded.
     */
    private function summary(Quiz $quiz): array
    {
        return [
            'id' => $quiz->id,
            'status' => $quiz->status,
            'subject' => [
                'id' => $quiz->subject?->id,
                'name' => $quiz->subject?->name,
            ],
            'topic' => $quiz->topic
                ? ['id' => $quiz->topic->id, 'name' => $quiz->topic->name]
                : null,
            'mcqs_count' => $quiz->mcqs_count,
            'minutes' => $quiz->minutes,
            'score' => $quiz->score,
            'created_at' => $quiz->created_at?->format('D d M Y h:i A'),
            'submitted_at' => $quiz->submitted_at?->toIso8601String(),
        ];
    }
}
