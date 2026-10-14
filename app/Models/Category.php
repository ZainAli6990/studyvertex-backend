<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'subjects_count',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'subjects_count' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class)->orderBy('sort_order')->orderBy('name');
    }
}
