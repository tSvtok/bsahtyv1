<?php

namespace App\Models;

use App\Enums\SportCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'sport_category',
        'user_id',
        'spot_id',
        'event_id',
    ];

    protected $appends = ['reactions_count', 'dislikes_count', 'liked_by_me', 'disliked_by_me', 'comments_count', 'image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return asset('storage/' . $this->image);
    }

    protected function casts(): array
    {
        return [
            'sport_category' => SportCategory::class,
        ];
    }

    public function getReactionsCountAttribute(): int
    {
        return $this->reactions()->where('type', 'LIKE')->count();
    }

    public function getDislikesCountAttribute(): int
    {
        return $this->reactions()->where('type', 'DISLIKE')->count();
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }

    public function getLikedByMeAttribute(): bool
    {
        if (!auth('sanctum')->check()) return false;
        return $this->reactions()
            ->where('user_id', auth('sanctum')->id())
            ->where('type', 'LIKE')
            ->exists();
    }

    public function getDislikedByMeAttribute(): bool
    {
        if (!auth('sanctum')->check()) return false;
        return $this->reactions()
            ->where('user_id', auth('sanctum')->id())
            ->where('type', 'DISLIKE')
            ->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
}
