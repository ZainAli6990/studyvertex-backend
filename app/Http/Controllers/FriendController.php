<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Friendship;
use App\Models\Quiz;
use App\Models\User;
use App\Services\AlertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * The "FRIENDS" screen -- three tabs, same shape as the screenshots:
 *
 *  - Friends:  people you're connected with, ranked by their total
 *              quiz score (the same "score" QUIZ RESULTS shows), so
 *              friends can see who's ahead -- a bit of friendly
 *              competition to keep everyone studying.
 *  - Find More: search everyone else on StudyVertex and send a request.
 *  - Requests:  requests other people sent you, Accept or Remove.
 */
class FriendController extends Controller
{
    /**
     * Friends tab.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // friend_id => friendship_id, so "Remove" knows which row to delete.
        $friendshipByFriendId = Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)->orWhere('addressee_id', $user->id);
            })
            ->get()
            ->mapWithKeys(fn (Friendship $f) => [
                ($f->requester_id === $user->id ? $f->addressee_id : $f->requester_id) => $f->id,
            ]);

        $friendIds = $friendshipByFriendId->keys();

        // Only male users ever appear in the friend list.
        $friends = User::whereIn('id', $friendIds)->where('gender', 'Male')->get()->keyBy('id');
        $scores = $this->scoresFor($friendIds);

        $list = $friendIds
            ->map(fn ($id) => $friends->get($id))
            ->filter()
            ->map(function (User $friend) use ($scores, $friendshipByFriendId) {
                $row = $this->present($friend, $scores[$friend->id] ?? 0);
                $row['friendship_id'] = $friendshipByFriendId[$friend->id];

                return $row;
            })
            ->sortByDesc('score')
            ->values()
            ->map(function (array $item, int $index) {
                $item['rank'] = $index + 1;

                return $item;
            });

        return response()->json([
            'success' => true,
            'friends' => $list,
        ], 200);
    }

    /**
     * "Find More" tab -- search box + a browsable list of everyone
     * who isn't already a friend or a pending request either way.
     */
    public function findMore(Request $request): JsonResponse
    {
        $user = $request->user();
        $search = trim((string) $request->query('query', ''));

        $excludeIds = $this->acceptedFriendIds($user->id)
            ->merge($this->pendingUserIds($user->id))
            ->push($user->id);

        // Find More lists male users only, whoever is logged in.
        $query = User::whereNotIn('id', $excludeIds)->where('gender', 'Male');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $people = $query->orderBy('name')->limit(50)->get();

        return response()->json([
            'success' => true,
            'people' => $people->map(fn (User $person) => $this->present($person))->values(),
        ], 200);
    }

    /**
     * "Requests" tab -- requests sent to you, newest first.
     */
    public function requests(Request $request): JsonResponse
    {
        $requests = Friendship::with('requester')
            ->where('addressee_id', $request->user()->id)
            ->where('status', Friendship::STATUS_PENDING)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'requests' => $requests
                ->filter(fn (Friendship $f) => $f->requester && $f->requester->gender === 'Male')
                ->map(fn (Friendship $f) => [
                    'friendship_id' => $f->id,
                    ...$this->present($f->requester),
                ])
                ->values(),
        ], 200);
    }

    /**
     * "Add" on Find More -- send a friend request.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $user = $request->user();
        $friendId = (int) $validated['user_id'];

        if ($friendId === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot add yourself.',
            ], 422);
        }

        // Friends are male-only: the sender and the person being added
        // must both be male users.
        $target = User::find($friendId);

        if ($user->gender !== 'Male' || ! $target || $target->gender !== 'Male') {
            return response()->json([
                'success' => false,
                'message' => 'Friends are available between male users only.',
            ], 422);
        }

        $existing = Friendship::where(function ($q) use ($user, $friendId) {
            $q->where('requester_id', $user->id)->where('addressee_id', $friendId);
        })->orWhere(function ($q) use ($user, $friendId) {
            $q->where('requester_id', $friendId)->where('addressee_id', $user->id);
        })->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => $existing->isAccepted()
                    ? 'You are already friends.'
                    : 'A request is already pending.',
            ], 422);
        }

        $friendship = Friendship::create([
            'requester_id' => $user->id,
            'addressee_id' => $friendId,
            'status' => Friendship::STATUS_PENDING,
        ]);

        AlertService::notify(
            $friendId,
            Alert::TYPE_FRIEND_REQUEST,
            'New friend request',
            "{$user->name} sent you a friend request.",
            ['user_id' => $user->id, 'friendship_id' => $friendship->id],
        );

        return response()->json([
            'success' => true,
            'message' => 'Friend request sent.',
            'friendship_id' => $friendship->id,
        ], 201);
    }

    /**
     * Accept a request you received.
     */
    public function accept(Request $request, Friendship $friendship): JsonResponse
    {
        abort_unless($friendship->addressee_id === $request->user()->id, 404);
        abort_unless($friendship->requester && $friendship->requester->gender === 'Male', 404);

        $friendship->update(['status' => Friendship::STATUS_ACCEPTED]);

        return response()->json([
            'success' => true,
            'friend' => $this->present($friendship->requester()->first()),
        ], 200);
    }

    /**
     * "Remove" -- unfriend an accepted friend, decline a request you
     * received, or cancel one you sent. Same button, same action.
     */
    public function destroy(Request $request, Friendship $friendship): JsonResponse
    {
        $userId = $request->user()->id;

        abort_unless(
            $friendship->requester_id === $userId || $friendship->addressee_id === $userId,
            404
        );

        $friendship->delete();

        return response()->json(['success' => true], 200);
    }

    private function acceptedFriendIds(int $userId): Collection
    {
        $ids = Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) use ($userId) {
                $q->where('requester_id', $userId)->orWhere('addressee_id', $userId);
            })
            ->get()
            ->map(fn (Friendship $f) => $f->requester_id === $userId ? $f->addressee_id : $f->requester_id);

        // Plain collection of ints, not an Eloquent collection -- ->merge(),
        // ->unique(), ->diff() etc. on an Eloquent collection expect Models
        // (they call $item->getKey()), which crashes when the items are ids.
        return collect($ids->all());
    }

    private function pendingUserIds(int $userId): Collection
    {
        $ids = Friendship::where('status', Friendship::STATUS_PENDING)
            ->where(function ($q) use ($userId) {
                $q->where('requester_id', $userId)->orWhere('addressee_id', $userId);
            })
            ->get()
            ->map(fn (Friendship $f) => $f->requester_id === $userId ? $f->addressee_id : $f->requester_id);

        return collect($ids->all());
    }

    /**
     * REPORT screen -- you and your friends, side by side: total quiz
     * score, best-ever streak, and lifetime Correct/Incorrect/Show/Skip
     * counts from Study Now. One wide row per person; the app scrolls it
     * sideways on a phone rather than splitting it into separate pages.
     */
    public function report(Request $request): JsonResponse
    {
        $user = $request->user();

        // FIX: acceptedFriendIds() returns a plain collection of ints, so
        // ->unique() no longer tries to call getKey() on an int.
       $ids = collect([$user->id]);

        $people = User::whereIn('id', $ids)->get()->keyBy('id');
        $scores = $this->scoresFor($ids);
        $bestStreaks = $this->bestStreaksFor($ids);
        $lastScored = $this->lastScoredFor($ids);

        $rows = $ids
            ->map(fn ($id) => $people->get($id))
            ->filter()
            ->map(function (User $person) use ($user, $scores, $bestStreaks, $lastScored) {
                $correct = (int) ($person->mcqs_correct ?? 0);
                $incorrect = (int) ($person->mcqs_incorrect ?? 0);

                return [
                    'id' => $person->id,
                    'name' => $person->username ?: $person->name,
                    'avatar_url' => $person->avatar_url,
                    'is_you' => $person->id === $user->id,
                    'score' => $scores[$person->id] ?? 0,
                    'max_streak' => $bestStreaks[$person->id] ?? 0,
                    'total_mcqs' => $correct + $incorrect + (int) ($person->mcqs_shown ?? 0) + (int) ($person->mcqs_skipped ?? 0),
                    'correct' => $correct,
                    'incorrect' => $incorrect,
                    'show' => (int) ($person->mcqs_shown ?? 0),
                    'skip' => (int) ($person->mcqs_skipped ?? 0),
                    'scored_last' => isset($lastScored[$person->id])
                        ? \Carbon\Carbon::parse($lastScored[$person->id])->toIso8601String()
                        : null,
                ];
            })
            ->sortByDesc('score')
            ->values();

        return response()->json([
            'success' => true,
            'rows' => $rows,
        ], 200);
    }

    /**
     * REPORT > tap your name -- the same numbers split up per subject.
     * One row for every subject in My Subjects that you've actually
     * worked on (answered, skipped, revealed, or finished a quiz in).
     * Always the logged-in person, so each user sees their own results.
     */
    public function reportSubjects(Request $request): JsonResponse
    {
        $user = $request->user();

        $mySubjects = DB::table('user_subjects')
            ->join('subjects', 'subjects.id', '=', 'user_subjects.subject_id')
            ->where('user_subjects.user_id', $user->id)
            ->select(
                'subjects.id',
                'subjects.name',
                'user_subjects.max_streak',
                'user_subjects.mcqs_correct',
                'user_subjects.mcqs_incorrect',
                'user_subjects.mcqs_shown',
                'user_subjects.mcqs_skipped',
                'user_subjects.last_scored_at'
            )
            ->get();

        $quizStats = Quiz::where('user_id', $user->id)
            ->where('status', Quiz::STATUS_COMPLETED)
            ->select(
                'subject_id',
                DB::raw('SUM(score) as total_score'),
                DB::raw('MAX(updated_at) as last_scored')
            )
            ->groupBy('subject_id')
            ->get()
            ->keyBy('subject_id');

        $rows = $mySubjects
            ->map(function ($subject) use ($quizStats) {
                $stats = $quizStats->get($subject->id);

                // Latest of: last MCQ answered/shown/skipped in this subject,
                // or the last finished quiz.
                $lastScored = collect([$subject->last_scored_at, $stats->last_scored ?? null])
                    ->filter()
                    ->map(fn ($value) => \Carbon\Carbon::parse($value))
                    ->max();

                $correct = (int) $subject->mcqs_correct;
                $incorrect = (int) $subject->mcqs_incorrect;
                $shown = (int) $subject->mcqs_shown;
                $skipped = (int) $subject->mcqs_skipped;

                return [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'score' => (int) ($stats->total_score ?? 0),
                    'max_streak' => (int) $subject->max_streak,
                    'total_mcqs' => $correct + $incorrect + $shown + $skipped,
                    'correct' => $correct,
                    'incorrect' => $incorrect,
                    'show' => $shown,
                    'skip' => $skipped,
                    'scored_last' => $lastScored ? $lastScored->toIso8601String() : null,
                ];
            })
            ->filter(fn (array $row) => $row['total_mcqs'] > 0
                || $row['score'] > 0
                || $row['scored_last'] !== null)
            ->sortByDesc('score')
            ->values();

        return response()->json([
            'success' => true,
            'name' => $user->username ?: $user->name,
            'rows' => $rows,
        ], 200);
    }

    /**
     * Total score across finished quizzes -- the leaderboard number
     * shown on each friend's card.
     */
    private function scoresFor(Collection $userIds): array
    {
        if ($userIds->isEmpty()) {
            return [];
        }

        return Quiz::whereIn('user_id', $userIds)
            ->where('status', Quiz::STATUS_COMPLETED)
            ->select('user_id', DB::raw('SUM(score) as total'))
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->map(fn ($value) => (int) $value)
            ->toArray();
    }

    private function present(User $user, int $score = 0): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'avatar_url' => $user->avatar_url,
            'score' => $score,
        ];
    }

    /** When each user last finished (scored) a quiz. */
    private function lastScoredFor(Collection $userIds): array
    {
        if ($userIds->isEmpty()) {
            return [];
        }

        $fromQuizzes = Quiz::whereIn('user_id', $userIds)
            ->where('status', Quiz::STATUS_COMPLETED)
            ->select('user_id', DB::raw('MAX(updated_at) as last_scored'))
            ->groupBy('user_id')
            ->pluck('last_scored', 'user_id')
            ->toArray();

        // Last MCQ answered / shown / skipped in any subject.
        $fromMcqs = DB::table('user_subjects')
            ->whereIn('user_id', $userIds)
            ->whereNotNull('last_scored_at')
            ->select('user_id', DB::raw('MAX(last_scored_at) as last_scored'))
            ->groupBy('user_id')
            ->pluck('last_scored', 'user_id')
            ->toArray();

        // Latest of the two, per user.
        $latest = [];
        foreach ($userIds as $id) {
            $dates = array_filter([$fromQuizzes[$id] ?? null, $fromMcqs[$id] ?? null]);
            if ($dates) {
                $latest[$id] = collect($dates)
                    ->map(fn ($value) => \Carbon\Carbon::parse($value))
                    ->max();
            }
        }

        return $latest;
    }

    /** Best max_streak reached in any one subject, per user. */
    private function bestStreaksFor(Collection $userIds): array
    {
        if ($userIds->isEmpty()) {
            return [];
        }

        return DB::table('user_subjects')
            ->whereIn('user_id', $userIds)
            ->select('user_id', DB::raw('MAX(max_streak) as best'))
            ->groupBy('user_id')
            ->pluck('best', 'user_id')
            ->map(fn ($value) => (int) $value)
            ->toArray();
    }
}
