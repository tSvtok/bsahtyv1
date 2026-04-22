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

    protected function casts(): array
    {
        return [
            'status' => LocationStatus::class,
        ];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
