<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Database\Seeder;

class SocialDataSeeder extends Seeder
{
    /**
     * Seed social content: questions, comments, reactions
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Run AdminSeeder and user seeders first');
            return;
        }

        // 60 questions
        $questions = Question::factory()
            ->count(60)
            ->recycle($users)
            ->create();

        // 150 comments on questions
        Comment::factory()
            ->count(150)
            ->recycle($users)
            ->recycle($questions)
            ->create();

        // Reactions on questions
        foreach ($questions as $question) {
            $reactingUsers = $users->random(rand(1, min(10, $users->count())));
            foreach ($reactingUsers as $user) {
                Reaction::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'reactable_id' => $question->id,
                        'reactable_type' => Question::class,
                    ],
                    ['type' => 'LIKE']
                );
            }
        }
    }
}
