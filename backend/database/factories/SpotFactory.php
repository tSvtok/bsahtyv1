<?php

namespace Database\Factories;

use App\Models\Spot;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpotFactory extends Factory
{
    protected $model = Spot::class;

    public function definition(): array
    {
        $types = ['gym', 'court', 'stadium', 'pool', 'park', 'track'];
        return [
            'name' => fake()->company() . ' ' . fake()->randomElement(['Arena', 'Field', 'Park', 'Center', 'Gym']),
            'coordinates' => [
                'lat' => fake()->latitude(36.7, 36.8),
                'lng' => fake()->longitude(3.0, 3.1),
            ],
            'status' => 'APPROVED',
        ];
    }
}
