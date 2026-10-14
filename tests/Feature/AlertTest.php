<?php

namespace Tests\Feature;

use App\Models\Alert;
use App\Models\Category;
use App\Models\Mcq;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Services\AlertService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AlertTest extends TestCase
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
    private function makeUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'username' => fake()->unique()->userName(),
        ], $attributes));
    }

    private function makeAlert(User $user, array $attributes = []): Alert
    {
        return Alert::create(array_merge([
            'user_id' => $user->id,
            'type' => Alert::TYPE_WELCOME,
            'title' => 'Hello',
            'body' => 'Body',
        ], $attributes));
    }

    /** A user who switched reminders on and follows Physics. */
    private function makeStudier(array $attributes = []): User
    {
        $user = $this->makeUser(array_merge([
            'study_alerts_active' => true,
            'mcqs_per_hour' => 3,
            'notify_start_at' => '09:00',
            'notify_stop_at' => '21:00',
        ], $attributes));

        DB::table('user_subjects')->insert([
            'user_id' => $user->id,
            'subject_id' => $this->subject->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }

    private function runStudyJob(): void
    {
        $this->artisan('alerts:generate', ['--only' => 'study'])->assertSuccessful();
    }

    private function studyReminderCount(User $user): int
    {
        return Alert::where('user_id', $user->id)
            ->where('type', Alert::TYPE_STUDY_REMINDER)
            ->count();
    }

    // ---------------------------------------------------------------
    // Inbox API
    // ---------------------------------------------------------------

    public function test_alert_routes_require_authentication(): void
    {
        $this->getJson('/api/alerts')->assertUnauthorized();
        $this->getJson('/api/alerts/summary')->assertUnauthorized();
        $this->postJson('/api/alerts/read-all')->assertUnauthorized();
    }

    public function test_index_lists_only_my_alerts_newest_first_with_unread_count(): void
    {
        $other = $this->makeUser();
        $this->makeAlert($other, ['title' => 'Not mine']);

        $this->makeAlert($this->user, ['title' => 'First']);
        $this->makeAlert($this->user, ['title' => 'Second']);
        $this->makeAlert($this->user, ['title' => 'Read one', 'read_at' => now()]);

        Sanctum::actingAs($this->user);

        $this->getJson('/api/alerts')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('unread_count', 2)
            ->assertJsonPath('has_more', false)
            ->assertJsonCount(3, 'alerts')
            ->assertJsonPath('alerts.0.title', 'Read one')
            ->assertJsonPath('alerts.0.is_read', true)
            ->assertJsonPath('alerts.1.title', 'Second')
            ->assertJsonPath('alerts.1.is_read', false)
            ->assertJsonPath('alerts.2.title', 'First');
    }

    public function test_unread_filter_and_pagination(): void
    {
        foreach (range(1, 25) as $n) {
            $this->makeAlert($this->user, ['title' => "Alert {$n}"]);
        }
        $this->makeAlert($this->user, ['title' => 'Already read', 'read_at' => now()]);

        Sanctum::actingAs($this->user);

        // 26 alerts, 20 per page.
        $this->getJson('/api/alerts')
            ->assertOk()
            ->assertJsonCount(20, 'alerts')
            ->assertJsonPath('has_more', true)
            ->assertJsonPath('next_page', 2);

        $this->getJson('/api/alerts?page=2')
            ->assertOk()
            ->assertJsonCount(6, 'alerts')
            ->assertJsonPath('has_more', false);

        // Only the 25 unread ones.
        $this->getJson('/api/alerts?filter=unread&page=2')
            ->assertOk()
            ->assertJsonCount(5, 'alerts');
    }

    public function test_mark_read_only_touches_my_alert(): void
    {
        $mine = $this->makeAlert($this->user);
        $theirs = $this->makeAlert($this->makeUser());

        Sanctum::actingAs($this->user);

        $this->postJson("/api/alerts/{$mine->id}/read")
            ->assertOk()
            ->assertJsonPath('alert.is_read', true)
            ->assertJsonPath('unread_count', 0);

        $this->assertNotNull($mine->fresh()->read_at);

        // Someone else's alert looks like it doesn't exist.
        $this->postJson("/api/alerts/{$theirs->id}/read")->assertNotFound();
        $this->assertNull($theirs->fresh()->read_at);
    }

    public function test_mark_all_read_delete_and_clear(): void
    {
        $other = $this->makeAlert($this->makeUser());

        $a = $this->makeAlert($this->user);
        $this->makeAlert($this->user);
        $this->makeAlert($this->user);

        Sanctum::actingAs($this->user);

        $this->postJson('/api/alerts/read-all')
            ->assertOk()
            ->assertJsonPath('unread_count', 0);

        $this->assertSame(0, Alert::where('user_id', $this->user->id)->whereNull('read_at')->count());

        $this->deleteJson("/api/alerts/{$a->id}")->assertOk();
        $this->assertDatabaseMissing('alerts', ['id' => $a->id]);

        $this->deleteJson("/api/alerts/{$other->id}")->assertNotFound();

        $this->deleteJson('/api/alerts')->assertOk();
        $this->assertSame(0, Alert::where('user_id', $this->user->id)->count());
        // ...and never touches other people's inboxes.
        $this->assertDatabaseHas('alerts', ['id' => $other->id]);
    }

    public function test_study_reminders_switch_and_summary(): void
    {
        $this->user->update(['mcqs_per_hour' => 4, 'notify_start_at' => '08:00', 'notify_stop_at' => '20:00']);

        Sanctum::actingAs($this->user);

        $this->getJson('/api/alerts/summary')
            ->assertOk()
            ->assertJsonPath('study_alerts_active', false)
            ->assertJsonPath('mcqs_per_hour', 4)
            ->assertJsonPath('notify_start_at', '08:00')
            ->assertJsonPath('notify_stop_at', '20:00');

        $this->putJson('/api/alerts/study-reminders', ['active' => true])
            ->assertOk()
            ->assertJsonPath('study_alerts_active', true);

        $this->assertTrue($this->user->fresh()->study_alerts_active);

        $this->putJson('/api/alerts/study-reminders', ['active' => false])
            ->assertOk()
            ->assertJsonPath('study_alerts_active', false);

        $this->putJson('/api/alerts/study-reminders', [])->assertUnprocessable();
    }

    // ---------------------------------------------------------------
    // Things that create alerts
    // ---------------------------------------------------------------

    public function test_finishing_a_quiz_creates_one_result_alert(): void
    {
        Sanctum::actingAs($this->user);

        $quiz = $this->postJson('/api/quizzes', [
            'subject_id' => $this->subject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => 2,
            'minutes' => 10,
        ])->assertCreated()->json('quiz');

        $ids = $this->getJson("/api/quizzes/{$quiz['id']}/start")->json('questions.*.id');

        $answers = [
            'answers' => [
                ['quiz_question_id' => $ids[0], 'selected_index' => 1],
                ['quiz_question_id' => $ids[1], 'selected_index' => 1],
            ],
        ];

        $this->postJson("/api/quizzes/{$quiz['id']}/submit", $answers)->assertOk();
        // A duplicate / late submit must not create a second alert.
        $this->postJson("/api/quizzes/{$quiz['id']}/submit", $answers)->assertOk();

        $alerts = Alert::where('user_id', $this->user->id)
            ->where('type', Alert::TYPE_QUIZ_RESULT)
            ->get();

        $this->assertCount(1, $alerts);
        $this->assertSame('Quiz result: 2/2 (100%)', $alerts->first()->title);
        $this->assertSame($quiz['id'], $alerts->first()->data['quiz_id']);
    }

    public function test_five_correct_answers_in_a_row_create_a_streak_alert_once_a_day(): void
    {
        Sanctum::actingAs($this->user);

        $mcq = Mcq::first();

        $submit = fn (int $index) => $this->postJson("/api/mcqs/{$mcq->id}/submit", [
            'selected_index' => $index,
        ])->assertOk();

        // Four correct: nothing yet.
        foreach (range(1, 4) as $ignored) {
            $submit(1);
        }
        $this->assertSame(0, Alert::where('type', Alert::TYPE_STREAK)->count());

        // The fifth one earns the alert.
        $submit(1);

        $alert = Alert::where('user_id', $this->user->id)->where('type', Alert::TYPE_STREAK)->first();
        $this->assertNotNull($alert);
        $this->assertSame('5 correct in a row!', $alert->title);
        $this->assertSame($this->subject->id, $alert->data['subject_id']);

        // Break the streak and reach 5 again the same day: still one alert.
        $submit(0);
        foreach (range(1, 5) as $ignored) {
            $submit(1);
        }

        $this->assertSame(1, Alert::where('user_id', $this->user->id)->where('type', Alert::TYPE_STREAK)->count());
    }

    public function test_show_returns_one_specific_question(): void
    {
        Sanctum::actingAs($this->user);

        $mcq = Mcq::first();

        $this->getJson("/api/mcqs/{$mcq->id}")
            ->assertOk()
            ->assertJsonPath('mcq.id', $mcq->id)
            ->assertJsonPath('topic.id', $this->topic->id)
            ->assertJsonPath('subject.id', $this->subject->id);
    }

    // ---------------------------------------------------------------
    // On demand: no scheduler needed
    // ---------------------------------------------------------------

    public function test_opening_the_app_creates_due_study_reminders_without_the_scheduler(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier(); // 3 per hour => one every 20 minutes

        Sanctum::actingAs($user);

        // The Home screen's badge check is what triggers it.
        $this->travelTo(now()->setTime(12, 0, 0));
        $this->getJson('/api/alerts/summary')
            ->assertOk()
            ->assertJsonPath('unread_count', 1);
        $this->assertSame(1, $this->studyReminderCount($user));

        // Checking again straight away (or 5 minutes later) sends nothing.
        $this->getJson('/api/alerts/summary')->assertJsonPath('unread_count', 1);
        $this->travelTo(now()->addMinutes(5));
        $this->getJson('/api/alerts')->assertOk()->assertJsonCount(1, 'alerts');

        // 21 minutes after the first one the next is due -- and the Alerts
        // screen (which polls) receives it.
        $this->travelTo(now()->addMinutes(16));
        $this->getJson('/api/alerts')
            ->assertOk()
            ->assertJsonCount(2, 'alerts')
            ->assertJsonPath('alerts.0.type', 'study_reminder');
    }

    public function test_switching_reminders_on_sends_the_first_question_immediately(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier(['study_alerts_active' => false]);

        Sanctum::actingAs($user);

        $this->travelTo(now()->setTime(12, 0, 0));

        // Off: opening the app sends nothing.
        $this->getJson('/api/alerts/summary')->assertJsonPath('unread_count', 0);

        $this->putJson('/api/alerts/study-reminders', ['active' => true])
            ->assertOk()
            ->assertJsonPath('study_alerts_active', true)
            ->assertJsonPath('unread_count', 1);
    }

    public function test_two_requests_at_the_same_moment_send_only_one_reminder(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier();

        // Two requests that both loaded the user before either sent anything.
        $first = User::find($user->id);
        $second = User::find($user->id);

        $this->travelTo(now()->setTime(12, 0, 0));

        $this->assertNotNull(AlertService::studyReminderIfDue($first));
        $this->assertNull(AlertService::studyReminderIfDue($second));

        $this->assertSame(1, $this->studyReminderCount($user));
    }

    public function test_abandoned_quiz_is_nudged_when_the_app_asks_for_alerts(): void
    {
        Sanctum::actingAs($this->user);

        $quiz = $this->postJson('/api/quizzes', [
            'subject_id' => $this->subject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => 2,
            'minutes' => 10,
        ])->assertCreated()->json('quiz');

        $this->getJson('/api/alerts/summary')->assertJsonPath('unread_count', 0);

        $this->travelTo(now()->addHours(2));

        $this->getJson('/api/alerts/summary')->assertJsonPath('unread_count', 1);
        // ...only once.
        $this->getJson('/api/alerts/summary')->assertJsonPath('unread_count', 1);

        $alert = Alert::where('type', Alert::TYPE_QUIZ_PENDING)->first();
        $this->assertSame($quiz['id'], $alert->data['quiz_id']);
    }

    // ---------------------------------------------------------------
    // Optional scheduler: alerts:generate (same rules as on demand)
    // ---------------------------------------------------------------

    public function test_study_reminder_respects_window_and_interval(): void
    {
        // Read the start/stop times as UTC so the test doesn't depend on
        // the machine's config.
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier(); // 3 per hour => one every 20 minutes

        $this->travelTo(now()->setTime(12, 0, 0));
        $this->runStudyJob();
        $this->assertSame(1, $this->studyReminderCount($user));

        $first = Alert::where('user_id', $user->id)->first();
        $this->assertSame('Time to practise: Physics', $first->title);
        $this->assertSame($this->topic->id, $first->data['topic_id']);
        $this->assertNotNull($first->data['mcq_id']);

        // 5 minutes later it isn't due yet.
        $this->travelTo(now()->addMinutes(5));
        $this->runStudyJob();
        $this->assertSame(1, $this->studyReminderCount($user));

        // 21 minutes after the first one, it is.
        $this->travelTo(now()->addMinutes(16));
        $this->runStudyJob();
        $this->assertSame(2, $this->studyReminderCount($user));
    }

    public function test_study_reminder_is_not_sent_outside_the_window(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier();

        $this->travelTo(now()->setTime(3, 0, 0));
        $this->runStudyJob();

        $this->assertSame(0, $this->studyReminderCount($user));
    }

    public function test_study_reminder_needs_the_switch_on_and_an_active_subject(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $off = $this->makeStudier(['study_alerts_active' => false]);

        $noSubjects = $this->makeUser([
            'study_alerts_active' => true,
            'mcqs_per_hour' => 3,
            'notify_start_at' => '09:00',
            'notify_stop_at' => '21:00',
        ]);

        $this->travelTo(now()->setTime(12, 0, 0));
        $this->runStudyJob();

        $this->assertSame(0, $this->studyReminderCount($off));
        $this->assertSame(0, $this->studyReminderCount($noSubjects));
    }

    public function test_only_the_newest_study_reminders_are_kept(): void
    {
        config(['alerts.timezone' => 'UTC']);

        $user = $this->makeStudier(['mcqs_per_hour' => 60]); // one a minute

        foreach (range(1, 45) as $minute) {
            $this->travelTo(now()->setTime(10, 0, 0)->addMinutes($minute));
            $this->runStudyJob();
        }

        $this->assertSame(40, $this->studyReminderCount($user));
    }

    public function test_unfinished_quiz_gets_one_nudge_after_its_timer_is_long_over(): void
    {
        Sanctum::actingAs($this->user);

        $quiz = $this->postJson('/api/quizzes', [
            'subject_id' => $this->subject->id,
            'topic_id' => $this->topic->id,
            'mcqs_count' => 2,
            'minutes' => 10,
        ])->assertCreated()->json('quiz');

        // Just created: nothing to nag about.
        $this->artisan('alerts:generate', ['--only' => 'quizzes'])->assertSuccessful();
        $this->assertSame(0, Alert::where('type', Alert::TYPE_QUIZ_PENDING)->count());

        // Two hours later it was clearly abandoned.
        $this->travelTo(now()->addHours(2));
        $this->artisan('alerts:generate', ['--only' => 'quizzes'])->assertSuccessful();
        $this->artisan('alerts:generate', ['--only' => 'quizzes'])->assertSuccessful();

        $alerts = Alert::where('type', Alert::TYPE_QUIZ_PENDING)->get();
        $this->assertCount(1, $alerts);
        $this->assertSame($quiz['id'], $alerts->first()->data['quiz_id']);
    }

    public function test_within_window_handles_all_day_and_overnight_windows(): void
    {
        $this->assertTrue(AlertService::withinWindow('12:00', '09:00', '21:00'));
        $this->assertFalse(AlertService::withinWindow('08:59', '09:00', '21:00'));
        $this->assertFalse(AlertService::withinWindow('21:01', '09:00', '21:00'));

        // No start / stop = all day.
        $this->assertTrue(AlertService::withinWindow('03:30', null, null));

        // 22:00 - 06:00 runs past midnight.
        $this->assertTrue(AlertService::withinWindow('23:30', '22:00', '06:00'));
        $this->assertTrue(AlertService::withinWindow('05:00', '22:00', '06:00'));
        $this->assertFalse(AlertService::withinWindow('12:00', '22:00', '06:00'));
    }
}
