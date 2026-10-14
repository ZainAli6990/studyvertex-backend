<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    public const TYPE_STUDY_REMINDER = 'study_reminder';

    public const TYPE_QUIZ_RESULT = 'quiz_result';

    public const TYPE_QUIZ_PENDING = 'quiz_pending';

    public const TYPE_STREAK = 'streak';

    public const TYPE_NEW_MCQS = 'new_mcqs';

    public const TYPE_WELCOME = 'welcome';

    public const TYPE_FRIEND_REQUEST = 'friend_request';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'data',
        'dedupe_key',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
