<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed admin and test users
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => \App\Enums\Role::ADMIN,
                'city' => 'Algiers',
                'avatar' => 'https://i.pravatar.cc/150?u=admin',
            ]
        );

        // Test user for integration testing
        User::firstOrCreate(
            ['email' => 'athlete@example.com'],
            [
                'name' => 'Athlete User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => \App\Enums\Role::USER,
                'bio' => 'Passionate about football and tennis. Looking for partners in Algiers!',
                'city' => 'Algiers',
                'sports' => ['Football', 'Tennis'],
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop',
            ]
        );
    }
}
