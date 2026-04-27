<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Friendship;
use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Seed relationships: friendships, conversations, messages
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->info('Need at least 2 users. Run AdminSeeder first');
            return;
        }

        // Get test user (assuming second user or search for it)
        $testUser = $users->firstWhere('email', 'athlete@example.com') ?? $users->first();
        $otherUsers = $users->where('id', '!=', $testUser->id);

        // Create friendships
        foreach ($otherUsers->take(15) as $user) {
            Friendship::updateOrCreate(
                ['user_id' => $testUser->id, 'friend_id' => $user->id],
                ['status' => \App\Enums\FriendshipStatus::ACCEPTED]
            );
        }

        // Create conversations and messages
        foreach ($otherUsers->take(8) as $user) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$testUser->id, $user->id]);

            // Messages from test user
            Message::factory()
                ->count(5)
                ->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $testUser->id,
                ]);

            // Messages from other user
            Message::factory()
                ->count(5)
                ->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id,
                ]);
        }
    }
}
