<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
 
class Subject extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'icon',
        'web_url',
        'mcqs_count',
        'sort_order',
    ];
 
    protected function casts(): array
    {
        return [
            'mcqs_count' => 'integer',
            'sort_order' => 'integer',
        ];
    }
 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
 
    /**
     * Users who have added this subject to "My Subjects".
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subjects')
            ->withPivot('is_active', 'current_streak', 'max_streak')
            ->withTimestamps();
    }
 
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('sort_order')->orderBy('name');
    }
 
    /**
     * Every MCQ that belongs to this subject, through its topics.
     * The "{n} MCQs" badges count this relation, so the number shown on
     * a card always matches the number of questions a user can really
     * practice.
     */
    public function mcqs(): HasManyThrough
    {
        return $this->hasManyThrough(Mcq::class, Topic::class);
    }
}


