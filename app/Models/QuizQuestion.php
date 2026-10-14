<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id',
        'mcq_id',
        'position',
        'question',
        'options',
        'correct_index',
        'selected_index',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'position' => 'integer',
            'correct_index' => 'integer',
            'selected_index' => 'integer',
            'is_correct' => 'boolean',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function mcq(): BelongsTo
    {
        return $this->belongsTo(Mcq::class);
    }
}
