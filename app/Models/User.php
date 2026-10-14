<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

   
protected $fillable = [
    'name',
    'username',
    'gender',
    'email',
    'password',
    'phone',
    'avatar_path',
    'mcqs_per_hour',
    'notify_start_at',
    'notify_stop_at',
    'study_alerts_active',
];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'study_alerts_active' => 'boolean',
            'last_study_alert_at' => 'datetime',
        ];
    }

    /**
     * Subjects this user has added under "My Subjects".
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'user_subjects')
            ->withPivot('is_active', 'current_streak', 'max_streak')
            ->withTimestamps();
    }

    /**
     * Quizzes this user has created.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * The user's ALERTS inbox.
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    /**
     * Public URL of the uploaded profile picture, or null when the
     * user hasn't uploaded one yet (frontend falls back to the
     * StudyVertex default avatar in that case).
     *
     * The picture is served by ProfileController@avatar instead of the
     * public/storage symlink, so it keeps working even when
     * `php artisan storage:link` was never run (or the symlink was lost
     * when the project was zipped / copied to another machine).
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path
            ? route('avatars.show', ['filename' => basename($this->avatar_path)])
            : null;
    }
}
