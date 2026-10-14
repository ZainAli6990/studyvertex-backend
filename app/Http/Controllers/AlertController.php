<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Services\AlertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * The "ALERTS" screen: the user's inbox plus the study-reminder switch.
 */
class AlertController extends Controller
{
    private const PER_PAGE = 20;

    /**
     * Inbox, newest first. `?filter=unread` shows only unread alerts and
     * `?page=N` loads older ones.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // Bring time-based alerts (study reminders, ...) up to date first.
        AlertService::refreshFor($user);

        $query = $user->alerts()->orderByDesc('id');

        if ($request->query('filter') === 'unread') {
            $query->whereNull('read_at');
        }

        $page = $query->paginate(self::PER_PAGE);

        return response()->json([
            'success' => true,
            'alerts' => collect($page->items())
                ->map(fn (Alert $alert) => $this->present($alert))
                ->values(),
            'unread_count' => $this->unreadCount($request),
            'has_more' => $page->hasMorePages(),
            'next_page' => $page->hasMorePages() ? $page->currentPage() + 1 : null,
        ], 200);
    }

    /**
     * Everything Home and the Alerts header need in one cheap call: the
     * red badge number and the study-reminder switch + schedule.
     */
    public function summary(Request $request): JsonResponse
    {
        // Home polls this every minute -- that is what makes a study
        // reminder show up on time without any scheduler running.
        AlertService::refreshFor($request->user());

        return response()->json($this->summaryPayload($request), 200);
    }

    /**
     * Home's Active / Inactive button -- switches study reminders on/off.
     */
    public function setStudyReminders(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        $user = $request->user();
        $user->study_alerts_active = (bool) $validated['active'];
        $user->save();

        // Switching reminders on gives the first question straight away.
        if ($user->study_alerts_active) {
            AlertService::refreshFor($user);
        }

        return response()->json($this->summaryPayload($request) + [
            'message' => $user->study_alerts_active
                ? 'Study reminders are on.'
                : 'Study reminders are off.',
        ], 200);
    }

    public function markRead(Request $request, Alert $alert): JsonResponse
    {
        $this->ensureOwner($request, $alert);

        if (! $alert->isRead()) {
            $alert->update(['read_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'alert' => $this->present($alert),
            'unread_count' => $this->unreadCount($request),
        ], 200);
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()
            ->alerts()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ], 200);
    }

    public function destroy(Request $request, Alert $alert): JsonResponse
    {
        $this->ensureOwner($request, $alert);

        $alert->delete();

        return response()->json([
            'success' => true,
            'unread_count' => $this->unreadCount($request),
        ], 200);
    }

    /**
     * "Clear all" -- empties the inbox.
     */
    public function clear(Request $request): JsonResponse
    {
        $request->user()->alerts()->delete();

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ], 200);
    }

    private function ensureOwner(Request $request, Alert $alert): void
    {
        // 404 (not 403) so nobody can probe which alert ids exist.
        abort_unless($alert->user_id === $request->user()->id, 404);
    }

    private function unreadCount(Request $request): int
    {
        return $request->user()->alerts()->whereNull('read_at')->count();
    }

    private function summaryPayload(Request $request): array
    {
        $user = $request->user();

        return [
            'success' => true,
            'unread_count' => $this->unreadCount($request),
            'study_alerts_active' => (bool) $user->study_alerts_active,
            'mcqs_per_hour' => (int) $user->mcqs_per_hour,
            'notify_start_at' => $user->notify_start_at,
            'notify_stop_at' => $user->notify_stop_at,
        ];
    }

    private function present(Alert $alert): array
    {
        return [
            'id' => $alert->id,
            'type' => $alert->type,
            'title' => $alert->title,
            'body' => $alert->body,
            'data' => (object) ($alert->data ?? []),
            'is_read' => $alert->isRead(),
            'created_at' => $alert->created_at?->toIso8601String(),
            'read_at' => $alert->read_at?->toIso8601String(),
        ];
    }
}
