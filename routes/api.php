<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MySubjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\McqController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PasswordResetController;

Route::post('/register/send-otp', [AuthController::class, 'sendRegistrationOtp']);
Route::post('/register/verify-otp', [AuthController::class, 'verifyRegistrationOtp']);
Route::post('/register/resend-otp', [AuthController::class, 'resendRegistrationOtp'])
    ->middleware('throttle:5,1');
Route::post('/login', [AuthController::class, 'login']);

// "SEND PASSWORD" screen: emailed 6-digit code, then set a new password.
Route::post('/forgot-password/send-otp', [PasswordResetController::class, 'sendOtp'])
    ->middleware('throttle:5,1');
Route::post('/forgot-password/reset', [PasswordResetController::class, 'reset'])
    ->middleware('throttle:10,1');

// Profile pictures. Public on purpose: <img> tags can't send the bearer
// token. File names are random 40-character strings and only plain file
// names are accepted (no slashes), so nothing outside avatars/ is reachable.
Route::get('/avatars/{filename}', [ProfileController::class, 'avatar'])
    ->where('filename', '[A-Za-z0-9_-][A-Za-z0-9._-]*')
    ->name('avatars.show');

Route::middleware('auth:sanctum')->group(function () {
    // Profile screen: view/update personal info, delete account,
    // update push notification (MCQs per hour + start/stop time) prefs.
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
    Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications']);

    // ALERTS: inbox + Home's Active/Inactive study-reminder switch.
    Route::get('/alerts', [AlertController::class, 'index']);
    Route::get('/alerts/summary', [AlertController::class, 'summary']);
    Route::put('/alerts/study-reminders', [AlertController::class, 'setStudyReminders']);
    Route::post('/alerts/read-all', [AlertController::class, 'markAllRead']);
    Route::delete('/alerts', [AlertController::class, 'clear']);
    Route::post('/alerts/{alert}/read', [AlertController::class, 'markRead']);
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy']);

    // "Find More" subjects tab.
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}/subjects', [SubjectController::class, 'index']);

    // Every subject (used by the Subject dropdown on "NEW QUIZ").
    Route::get('/subjects', [SubjectController::class, 'all']);

    // "My Subjects" tab.
    Route::get('/my-subjects', [MySubjectController::class, 'index']);
    Route::post('/my-subjects', [MySubjectController::class, 'store']);
    Route::patch('/my-subjects/{subject}', [MySubjectController::class, 'update']);
    Route::delete('/my-subjects/{subject}', [MySubjectController::class, 'destroy']);

    // Topics + MCQ practice flow.
    Route::get('/subjects/{subject}/topics', [TopicController::class, 'index']);
    Route::get('/topics/{topic}/question', [McqController::class, 'next']);

    // "STUDY NOW" -- random question across every subject/topic.
    Route::get('/study-now/question', [McqController::class, 'studyNow']);

    // Full solved-question list for a topic ("TOPIC QUESTIONS" screen).
    Route::get('/topics/{topic}/questions', [McqController::class, 'index']);
    Route::get('/mcqs/{mcq}', [McqController::class, 'show']);
    Route::post('/mcqs/{mcq}/reveal', [McqController::class, 'reveal']);
    Route::post('/mcqs/{mcq}/submit', [McqController::class, 'submit']);
    Route::post('/mcqs/skip', [McqController::class, 'skip']);

    // FRIENDS: Friends / Find More / Requests tabs.
    Route::get('/friends', [FriendController::class, 'index']);
    Route::get('/friends/find-more', [FriendController::class, 'findMore']);
    Route::get('/friends/requests', [FriendController::class, 'requests']);
    Route::get('/friends/report', [FriendController::class, 'report']);
    Route::get('/friends/report/subjects', [FriendController::class, 'reportSubjects']);
    Route::post('/friends', [FriendController::class, 'store']);
    Route::post('/friends/{friendship}/accept', [FriendController::class, 'accept']);
    Route::delete('/friends/{friendship}', [FriendController::class, 'destroy']);

    // Quizzes: list, create, take, grade, review, repeat.
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::get('/quizzes/{quiz}/start', [QuizController::class, 'start']);
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
    Route::get('/quizzes/{quiz}/review', [QuizController::class, 'review']);
    Route::post('/quizzes/{quiz}/repeat', [QuizController::class, 'repeat']);
});
