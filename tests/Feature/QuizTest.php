<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Mcq;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Subject $subject;

    private Topic $topic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->makeUser();

        $category = Category::create(['name' => 'Science']);
        $this->subject = Subject::create(['category_id' => $category->id, 'name' => 'Physics']);
        $this->topic = Topic::create(['subject_id' => $this->subject->id, 'name' => 'Motion']);

        // 4 MCQs, the correct option is always index 1.
        foreach (range(1, 4) as $n) {
            Mcq::create([
                'topic_id' => $this->topic->id,
                'question' => "Question {$n}?",
                'options' => ['wrong A', 'right', 'wrong B', 'wrong C'],
                'correct_index' => 1,
                'sort_order' => $n,
            ]);
        }
    }

    /**
     * The default UserFactory has no `username`, which the users table
     * requires (and keeps unique), so set one here.
     */
    private function makeUser(): User
    {
        return User::factory()->create([
            'username' => fake()->unique()->userName(),
        ]);
    }

    private function createQuiz(int $mcqs = 4, int $minutes = 10): array
    {
        Sanctum::actingAs($this->user);

        return $this->postJson('/api/quizzes', [
            'subject_id' => $this->subject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => $mcqs,
            'minutes' => $minutes,
        ])->assertCreated()->json('quiz');
    }

    public function test_quiz_routes_require_authentication(): void
    {
        $this->getJson('/api/quizzes')->assertUnauthorized();
        $this->getJson('/api/subjects')->assertUnauthorized();
    }

    public function test_subjects_endpoint_lists_every_subject(): void
    {
        Sanctum::actingAs($this->user);

        $this->getJson('/api/subjects')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('subjects.0.name', 'Physics')
            ->assertJsonPath('subjects.0.mcqs_count', 4);
    }

    public function test_user_can_create_a_quiz_and_it_appears_in_the_list(): void
    {
        $quiz = $this->createQuiz(3, 15);

        $this->assertSame('pending', $quiz['status']);
        $this->assertSame(3, $quiz['mcqs_count']);
        $this->assertSame(15, $quiz['minutes']);
        $this->assertSame(0, $quiz['score']);
        $this->assertSame('Physics', $quiz['subject']['name']);
        $this->assertSame('Motion', $quiz['topic']['name']);
        $this->assertDatabaseCount('quiz_questions', 3);

        $this->getJson('/api/quizzes')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'quizzes')
            ->assertJsonPath('quizzes.0.id', $quiz['id']);
    }

    public function test_cannot_ask_for_more_mcqs_than_the_topic_has(): void
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/quizzes', [
            'subject_id' => $this->subject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => 10,
            'minutes' => 5,
        ])
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'This topic only has 4 MCQs. Please enter 4 or fewer.');

        $this->assertDatabaseCount('quizzes', 0);
    }

    public function test_topic_must_belong_to_the_selected_subject(): void
    {
        Sanctum::actingAs($this->user);

        $otherSubject = Subject::create([
            'category_id' => $this->subject->category_id,
            'name' => 'Chemistry',
        ]);

        $this->postJson('/api/quizzes', [
            'subject_id' => $otherSubject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => 2,
            'minutes' => 5,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('topic_id');
    }

    public function test_list_only_contains_the_current_users_quizzes(): void
    {
        $this->createQuiz();

        Sanctum::actingAs($this->makeUser());

        $this->getJson('/api/quizzes')
            ->assertOk()
            ->assertJsonCount(0, 'quizzes');
    }

    public function test_start_returns_questions_without_the_correct_answers(): void
    {
        $quiz = $this->createQuiz(4);

        $response = $this->getJson("/api/quizzes/{$quiz['id']}/start")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('quiz.minutes', 10)
            ->assertJsonPath('quiz.subject.name', 'Physics')
            ->assertJsonCount(4, 'questions');

        $first = $response->json('questions.0');
        $this->assertSame(['id', 'position', 'question', 'options'], array_keys($first));
        $this->assertStringNotContainsString('correct', $response->getContent());
    }

    public function test_another_user_cannot_touch_a_quiz(): void
    {
        $quiz = $this->createQuiz();

        Sanctum::actingAs($this->makeUser());

        $this->getJson("/api/quizzes/{$quiz['id']}/start")->assertNotFound();
        $this->postJson("/api/quizzes/{$quiz['id']}/submit", ['answers' => []])->assertNotFound();
        $this->getJson("/api/quizzes/{$quiz['id']}/review")->assertNotFound();
        $this->postJson("/api/quizzes/{$quiz['id']}/repeat")->assertNotFound();
    }

    public function test_review_is_blocked_until_the_quiz_is_submitted(): void
    {
        $quiz = $this->createQuiz();

        $this->getJson("/api/quizzes/{$quiz['id']}/review")
            ->assertStatus(409)
            ->assertJsonPath('success', false);
    }

    public function test_submit_grades_the_quiz_and_review_shows_the_result(): void
    {
        $quiz = $this->createQuiz(4);
        $ids = $this->getJson("/api/quizzes/{$quiz['id']}/start")->json('questions.*.id');

        // Q1 correct, Q2 correct, Q3 wrong, Q4 skipped.
        $this->postJson("/api/quizzes/{$quiz['id']}/submit", [
            'answers' => [
                ['quiz_question_id' => $ids[0], 'selected_index' => 1],
                ['quiz_question_id' => $ids[1], 'selected_index' => 1],
                ['quiz_question_id' => $ids[2], 'selected_index' => 0],
                ['quiz_question_id' => $ids[3], 'selected_index' => null],
            ],
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('quiz.status', 'completed')
            ->assertJsonPath('quiz.score', 2);

        $review = $this->getJson("/api/quizzes/{$quiz['id']}/review")
            ->assertOk()
            ->assertJsonPath('quiz.score', 2)
            ->assertJsonPath('quiz.mcqs_count', 4)
            ->assertJsonCount(4, 'questions');

        // correct
        $review->assertJsonPath('questions.0.position', 0)
            ->assertJsonPath('questions.0.is_correct', true)
            ->assertJsonPath('questions.0.selected_text', 'right')
            ->assertJsonPath('questions.0.correct_text', 'right');
        // wrong
        $review->assertJsonPath('questions.2.is_correct', false)
            ->assertJsonPath('questions.2.selected_index', 0)
            ->assertJsonPath('questions.2.selected_text', 'wrong A');
        // skipped
        $review->assertJsonPath('questions.3.selected_index', null)
            ->assertJsonPath('questions.3.selected_text', null)
            ->assertJsonPath('questions.3.correct_text', 'right');

        // The list card now reports the score, and start is closed.
        $this->getJson('/api/quizzes')
            ->assertJsonPath('quizzes.0.status', 'completed')
            ->assertJsonPath('quizzes.0.score', 2);

        $this->getJson("/api/quizzes/{$quiz['id']}/start")->assertStatus(409);
    }

    public function test_submitting_twice_does_not_change_the_result(): void
    {
        $quiz = $this->createQuiz(2);
        $ids = $this->getJson("/api/quizzes/{$quiz['id']}/start")->json('questions.*.id');

        $this->postJson("/api/quizzes/{$quiz['id']}/submit", [
            'answers' => [
                ['quiz_question_id' => $ids[0], 'selected_index' => 1],
                ['quiz_question_id' => $ids[1], 'selected_index' => 1],
            ],
        ])->assertJsonPath('quiz.score', 2);

        // A second (late/duplicate) submit with all-wrong answers is ignored.
        $this->postJson("/api/quizzes/{$quiz['id']}/submit", [
            'answers' => [
                ['quiz_question_id' => $ids[0], 'selected_index' => 0],
                ['quiz_question_id' => $ids[1], 'selected_index' => 0],
            ],
        ])->assertOk()->assertJsonPath('quiz.score', 2);

        $this->assertSame(2, Quiz::find($quiz['id'])->score);
    }

    public function test_submit_with_no_answers_gives_zero(): void
    {
        $quiz = $this->createQuiz(2);

        $this->postJson("/api/quizzes/{$quiz['id']}/submit", ['answers' => []])
            ->assertOk()
            ->assertJsonPath('quiz.status', 'completed')
            ->assertJsonPath('quiz.score', 0);
    }

    public function test_repeat_creates_a_fresh_quiz_with_the_same_questions(): void
    {
        $quiz = $this->createQuiz(3, 7);
        $ids = $this->getJson("/api/quizzes/{$quiz['id']}/start")->json('questions.*.id');

        $this->postJson("/api/quizzes/{$quiz['id']}/submit", [
            'answers' => array_map(
                fn ($id) => ['quiz_question_id' => $id, 'selected_index' => 1],
                $ids
            ),
        ])->assertJsonPath('quiz.score', 3);

        $copy = $this->postJson("/api/quizzes/{$quiz['id']}/repeat")
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('quiz.status', 'pending')
            ->assertJsonPath('quiz.score', 0)
            ->assertJsonPath('quiz.mcqs_count', 3)
            ->assertJsonPath('quiz.minutes', 7)
            ->json('quiz');

        $this->assertNotSame($quiz['id'], $copy['id']);

        $originalText = Quiz::find($quiz['id'])->questions->pluck('question')->all();
        $copyText = Quiz::find($copy['id'])->questions->pluck('question')->all();
        $this->assertSame($originalText, $copyText);

        // The copy is takeable, and its answers start blank.
        $this->getJson("/api/quizzes/{$copy['id']}/start")->assertOk()->assertJsonCount(3, 'questions');
        $this->assertNull(Quiz::find($copy['id'])->questions->first()->selected_index);
    }

    public function test_quiz_results_survive_the_mcqs_being_deleted(): void
    {
        $quiz = $this->createQuiz(4);
        $ids = $this->getJson("/api/quizzes/{$quiz['id']}/start")->json('questions.*.id');

        $this->postJson("/api/quizzes/{$quiz['id']}/submit", [
            'answers' => [['quiz_question_id' => $ids[0], 'selected_index' => 1]],
        ])->assertOk();

        // What `php artisan mcqs:import --truncate-topic` does.
        Mcq::where('topic_id', $this->topic->id)->delete();

        $this->getJson("/api/quizzes/{$quiz['id']}/review")
            ->assertOk()
            ->assertJsonCount(4, 'questions')
            ->assertJsonPath('questions.0.correct_text', 'right');
    }
}
