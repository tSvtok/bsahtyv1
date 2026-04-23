<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use App\Models\Spot;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraph(3),
            'sport_category' => fake()->randomElement(['FOOTBALL', 'TENNIS', 'BASKETBALL', 'RUNNING', 'YOGA']),
            'user_id' => User::factory(),
            'spot_id' => null,
            'event_id' => null,
        ];
    }
}
