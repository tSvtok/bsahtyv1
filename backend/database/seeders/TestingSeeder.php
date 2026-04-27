<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Spot;
use Illuminate\Database\Seeder;

/**
 * Testing seeder - minimal data optimized for test speed
 * 
 * Usage: By default in phpunit.xml, or manually via php artisan db:seed --class=TestingSeeder
 */
class TestingSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user for testing
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin Test User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => \App\Enums\Role::ADMIN,
            ]
        );

        // Create regular test user
        User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Test User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => \App\Enums\Role::USER,
                'city' => 'Algiers',
                'sports' => ['Football'],
            ]
        );

        // Create minimal test spots
        Spot::firstOrCreate(
            ['name' => 'Test Stadium'],
            [
                'coordinates' => ['lat' => 36.7592, 'lng' => 2.9961],
                'status' => 'APPROVED',
            ]
        );

        // Factory-based additional users for tests that need multiple users
        // Don't create by default - let tests create them as needed via factories
    }
}
