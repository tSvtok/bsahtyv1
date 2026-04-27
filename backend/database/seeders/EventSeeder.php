<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Spot;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Seed events with relationships to users and spots
     */
    public function run(): void
    {
        $users = User::all();
        $spots = Spot::all();

        if ($users->isEmpty() || $spots->isEmpty()) {
            $this->command->info('Run AdminSeeder and SpotsSeeder first');
            return;
        }

        Event::factory()
            ->count(30)
            ->recycle($users)
            ->recycle($spots)
            ->create();
    }
}
