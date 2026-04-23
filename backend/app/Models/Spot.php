<?php

namespace App\Models;

use App\Enums\LocationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coordinates',
        'status',
    ];

    protected $appends = ['lat', 'lng'];

    protected function casts(): array
    {
        return [
            'status' => LocationStatus::class,
            'coordinates' => 'array', // Store as JSON array
        ];
    }

    // Accessors for latitude and longitude
    public function getLatAttribute()
    {
        return $this->coordinates['lat'] ?? null;
    }

    public function getLngAttribute()
    {
        return $this->coordinates['lng'] ?? null;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
