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
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'status' => EventStatus::class,
        ];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
