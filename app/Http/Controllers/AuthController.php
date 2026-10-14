<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationOtpMail;
use App\Models\RegistrationOtp;
use App\Models\User;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Send OTP for new account registration.
     */
    public function sendRegistrationOtp(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'in:Male,Female'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'rePassword' => ['required', 'same:password'],
        ]);

        // Check username already exists in users table.
        if (User::where('username', $validated['username'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This username is already taken.',
            ], 422);
        }

        // Check email already exists in users table.
        if (User::where('email', $validated['email'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered.',
            ], 422);
        }

        // Remove any old pending registration using this username/email.
        RegistrationOtp::where('username', $validated['username'])
            ->orWhere('email', $validated['email'])
            ->delete();

        // Generate a 6-digit OTP.
        $otp = (string) random_int(100000, 999999);

        // Store the signup data temporarily.
        RegistrationOtp::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'password' => Crypt::encryptString($validated['password']),
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP to user's email.
        try {
            Mail::to($validated['email'])->send(
                new RegistrationOtpMail(
                    $otp,
                    $validated['name']
                )
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Registration OTP email failed: ' . $e->getMessage());

            RegistrationOtp::where('email', $validated['email'])->delete();

            return response()->json([
                'success' => false,
                'message' => 'We could not send the verification email right now. Please try again in a few minutes.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email address.',
        ], 200);
    }

    /**
     * Send a fresh OTP for a pending registration (OTP screen's "Resend").
     */
    public function resendRegistrationOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $registration = RegistrationOtp::where('email', $validated['email'])->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration request not found. Please create your account again.',
            ], 404);
        }

        $otp = (string) random_int(100000, 999999);

        $registration->update([
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($registration->email)->send(
                new RegistrationOtpMail($otp, $registration->name)
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Registration OTP resend failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'We could not send the email right now. Please try again in a few minutes.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'A new code has been sent to your email address.',
        ], 200);
    }

    /**
     * Verify registration OTP and create the account.
     */
    public function verifyRegistrationOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $registration = RegistrationOtp::where(
            'email',
            $validated['email']
        )->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration request not found.',
            ], 404);
        }

        if ($registration->expires_at->isPast()) {
            $registration->delete();

            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new OTP.',
            ], 422);
        }

        if (!Hash::check($validated['otp'], $registration->otp_hash)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 422);
        }

        // Double-check username/email before creating account.
        if (User::where('username', $registration->username)->exists()) {
            $registration->delete();

            return response()->json([
                'success' => false,
                'message' => 'This username is already taken.',
            ], 422);
        }

        if (User::where('email', $registration->email)->exists()) {
            $registration->delete();

            return response()->json([
                'success' => false,
                'message' => 'This email is already registered.',
            ], 422);
        }

        // Decrypt password only at the moment of account creation.
        $password = Crypt::decryptString($registration->password);

        $user = User::create([
            'name' => $registration->name,
            'username' => $registration->username,
            'gender' => $registration->gender,
            'email' => $registration->email,
            'password' => $password,
        ]);

        // Remove temporary registration record.
        $registration->delete();

        // First thing in the new user's ALERTS inbox.
        AlertService::welcome($user);

        return response()->json([
            'success' => true,
            'message' => 'Email verified and account created successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'email' => $user->email,
            ],
        ], 201);
    }

    /**
     * Login an existing StudyVertex user.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where(
            'username',
            $validated['username']
        )->first();

        if (
            !$user ||
            !Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        // Create Sanctum token for the logged-in user.
        $token = $user
            ->createToken('studyvertex-web')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar_url' => $user->avatar_url,
            ],
        ], 200);
    }
}