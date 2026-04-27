<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Seed 30 additional users for realistic social network
     */
    public function run(): void
    {
        $users = User::factory(30)->create();
        
        // Add avatars to all created users
        foreach ($users as $user) {
            $user->update([
                'avatar' => 'https://i.pravatar.cc/150?u=' . $user->id,
            ]);
        }
    }
}
