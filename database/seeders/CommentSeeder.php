<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if comments already exist
        if (Comment::count() > 0) {
            $this->command->info('Comments already exist. Skipping comment creation.');
            return;
        }

        $todos = Todo::with('collaboration.members')->get();
        
        foreach ($todos as $todo) {
            // Create 0-5 comments for each todo
            $numberOfComments = fake()->numberBetween(0, 5);
            
            foreach(range(1, $numberOfComments) as $index) {
                Comment::create([
                    'collaboration_id' => $todo->collaboration_id,
                    'todo_id' => $todo->id,
                    'user_id' => $todo->collaboration->members->random()->id,
                    'message' => fake()->paragraph(),
                ]);
            }
        }
    }
}
