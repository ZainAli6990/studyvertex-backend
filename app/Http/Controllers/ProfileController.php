<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Return the authenticated user's profile + notification settings.
     * Used to pre-fill the Profile screen when it opens.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar_url' => $user->avatar_url,
                'mcqs_per_hour' => $user->mcqs_per_hour,
                'notify_start_at' => $user->notify_start_at,
                'notify_stop_at' => $user->notify_stop_at,
            ],
        ]);
    }

    /**
     * Update personal information: name, phone, email, username
     * and (optionally) password.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'rePassword' => ['nullable', 'same:password'],
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->email = $validated['email'];
        $user->username = $validated['username'];

        // Only touch the password when the user actually typed a new one.
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile has been updated.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar_url' => $user->avatar_url,
            ],
        ]);
    }

    /**
     * Upload (or replace) the authenticated user's profile picture.
     * Used by both the "Gallery" and "Camera" options on the
     * Profile screen's photo picker.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user = $request->user();

        // Remove the old photo (if any) before storing the new one.
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar_path = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile picture has been updated.',
            'avatar_url' => $user->avatar_url,
        ]);
    }

    /**
     * Stream a stored profile picture. Used as the `avatar_url` of every
     * user, so it works without the public/storage symlink.
     */
    public function avatar(string $filename)
    {
        $path = 'avatars/' . $filename;

        abort_unless(Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path, null, [
            // New uploads always get a new random name, so it is safe to
            // let browsers cache a picture for a long time.
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * Permanently delete the authenticated user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Remove the uploaded photo (if any) and revoke every
        // Sanctum token before removing the account.
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been deleted.',
        ]);
    }

    /**
     * Update push-notification preferences (MCQs per hour + the
     * daily start/stop window notifications are allowed to fire in).
     */
    public function updateNotifications(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'mcqs_per_hour' => ['required', 'integer', 'min:1', 'max:60'],
            'notify_start_at' => ['nullable', 'date_format:H:i'],
            'notify_stop_at' => ['nullable', 'date_format:H:i'],
        ]);

        $user->mcqs_per_hour = $validated['mcqs_per_hour'];
        $user->notify_start_at = $validated['notify_start_at'] ?? null;
        $user->notify_stop_at = $validated['notify_stop_at'] ?? null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Push notification settings have been updated.',
            'user' => [
                'mcqs_per_hour' => $user->mcqs_per_hour,
                'notify_start_at' => $user->notify_start_at,
                'notify_stop_at' => $user->notify_stop_at,
            ],
        ]);
    }
}
