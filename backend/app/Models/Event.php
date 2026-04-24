<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sport',
        'location',
        'date',
        'max_participants',
        'image',
        'status',
        'organizer_id',
        'spot_id',
        'latitude',
        'longitude',
    ];

    protected $appends = ['participants_count', 'is_joined', 'image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return asset('storage/' . $this->image);
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'status' => EventStatus::class,
        ];
    }

    public function getParticipantsCountAttribute(): int
    {
        return $this->participants()->count();
    }

    public function getIsJoinedAttribute(): bool
    {
        if (!auth('sanctum')->check()) return false;
        return $this->participants()->where('user_id', auth('sanctum')->id())->exists();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function organizer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function spot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
