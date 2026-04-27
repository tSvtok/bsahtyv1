<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Spot;
use App\Models\Event;
use Illuminate\Database\Seeder;

/**
 * Lightweight seeder for development iteration
 * Creates minimal data for quick testing
 * 
 * Usage: php artisan migrate:fresh --seed=LightweightSeeder
 */
class LightweightSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => \App\Enums\Role::ADMIN,
                'city' => 'Algiers',
                'avatar' => 'https://i.pravatar.cc/150?u=admin',
            ]
        );

        // 2. Create Test User
        $testUser = User::firstOrCreate(
            ['email' => 'athlete@example.com'],
            [
                'name' => 'Athlete User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'bio' => 'Passionate about football and tennis.',
                'city' => 'Algiers',
                'sports' => ['Football', 'Tennis'],
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop',
            ]
        );

        // 3. Create 3 more sample users
        $users = User::factory(3)->create();
        foreach ($users as $user) {
            $user->update([
                'avatar' => 'https://i.pravatar.cc/150?u=' . $user->id,
            ]);
        }
        $allUsers = $users->concat([$testUser, $admin]);

        // 4. Create 5 sample spots
        $sampleSpots = [
            ['name' => 'Stade du 5 Juillet', 'lat' => 36.7592, 'lng' => 2.9961],
            ['name' => 'Club de Tennis Ben Aknoun', 'lat' => 36.7589, 'lng' => 3.0245],
            ['name' => 'Gym Hydra Center', 'lat' => 36.7431, 'lng' => 3.0345],
            ['name' => 'Piscine Olympique El Biar', 'lat' => 36.7725, 'lng' => 3.0312],
            ['name' => 'Jardin d\'Essai du Hamma', 'lat' => 36.7483, 'lng' => 3.0647],
        ];

        foreach ($sampleSpots as $spot) {
            Spot::firstOrCreate(
                ['name' => $spot['name']],
                [
                    'coordinates' => ['lat' => $spot['lat'], 'lng' => $spot['lng']],
                    'status' => 'APPROVED',
                ]
            );
        }

        // 5. Create 3 sample events
        Event::factory(3)->recycle($allUsers)->recycle(Spot::all())->create();

        // 6. Create 5 sample questions
        \App\Models\Question::factory(5)->recycle($allUsers)->create();
    }
}
