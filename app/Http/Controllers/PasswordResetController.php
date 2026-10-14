<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * "SEND PASSWORD" screen (Forgot Password).
 *
 *  1. sendOtp()  -- username + registered email -> 6-digit code by email.
 *  2. reset()    -- email + code + new password -> password changed.
 *
 * The code is stored hashed in Laravel's built-in password_reset_tokens
 * table (one row per email), so no new migration is needed.
 */
class PasswordResetController extends Controller
{
    private const OTP_MINUTES = 10;
    private const MAX_WRONG_ATTEMPTS = 5;

    public function sendOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::where('username', $validated['username'])
            ->whereRaw('lower(email) = ?', [strtolower($validated['email'])])
            ->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'No account matches this username and email.',
            ], 404);
        }

        $otp = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($otp), 'created_at' => now()]
        );
        Cache::forget($this->attemptsKey($user->email));

        try {
            Mail::to($user->email)->send(new PasswordResetOtpMail($otp, $user->name));
        } catch (\Throwable $e) {
            Log::error('Password reset email failed: '.$e->getMessage());
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return response()->json([
                'success' => false,
                'message' => 'We could not send the email right now. Please try again in a few minutes.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'A 6-digit code has been sent to your email address.',
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:6'],
            'rePassword' => ['required', 'same:password'],
        ]);

        $user = User::whereRaw('lower(email) = ?', [strtolower($validated['email'])])->first();
        $row = $user
            ? DB::table('password_reset_tokens')->where('email', $user->email)->first()
            : null;

        if (! $user || ! $row) {
            return $this->fail('Please request a new code first.', 422);
        }

        if (! $row->created_at || Carbon::parse($row->created_at)->addMinutes(self::OTP_MINUTES)->isPast()) {
            $this->forget($user->email);

            return $this->fail('This code has expired. Please request a new one.', 422);
        }

        $key = $this->attemptsKey($user->email);
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= self::MAX_WRONG_ATTEMPTS) {
            $this->forget($user->email);

            return $this->fail('Too many wrong attempts. Please request a new code.', 429);
        }

        if (! Hash::check($validated['otp'], $row->token)) {
            Cache::put($key, $attempts + 1, now()->addMinutes(self::OTP_MINUTES));

            return $this->fail('Invalid code. Please check your email and try again.', 422);
        }

        $user->password = $validated['password']; // hashed by the model cast
        $user->save();

        // Anyone logged in with the old password is signed out everywhere.
        $user->tokens()->delete();
        $this->forget($user->email);

        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed. Please log in.',
        ]);
    }

    private function forget(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        Cache::forget($this->attemptsKey($email));
    }

    private function attemptsKey(string $email): string
    {
        return 'pwreset_attempts:'.sha1(strtolower($email));
    }

    private function fail(string $message, int $status): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
}
