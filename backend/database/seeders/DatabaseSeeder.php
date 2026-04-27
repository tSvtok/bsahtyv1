<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Main DatabaseSeeder - calls all domain seeders for complete data population
 * 
 * Usage:
 * - Full seed: php artisan migrate:fresh --seed
 * - Lightweight: php artisan migrate:fresh --seed=LightweightSeeder
 * - Testing: php artisan migrate:fresh --seed=TestingSeeder
 * - Custom: php artisan migrate:fresh --seed=AdminSeeder --seed=SpotsSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed in order of dependencies
        $this->call([
            AdminSeeder::class,           // Create admin and test users
            SpotsSeeder::class,           // Create sports venues
            PeopleSeeder::class,          // Create 30 additional users
            EventSeeder::class,           // Create events (depends on users & spots)
            SocialDataSeeder::class,      // Create questions, comments, reactions
            RelationshipSeeder::class,    // Create friendships, conversations, messages
        ]);
    }
}
