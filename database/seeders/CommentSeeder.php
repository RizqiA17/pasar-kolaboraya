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
        $todos = Todo::with('collaboration.members')->get();
        
        foreach ($todos as $todo) {
            // Create 0-5 comments for each todo
            $numberOfComments = fake()->numberBetween(0, 5);
            
            foreach(range(1, $numberOfComments) as $index) {
                Comment::create([
                    'todo_id' => $todo->id,
                    'user_id' => $todo->collaboration->members->random()->id,
                    'comment' => fake()->paragraph(),
                ]);
            }
        }
    }
}
