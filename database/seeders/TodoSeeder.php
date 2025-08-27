<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collaborations = Collaboration::all();
        
        foreach ($collaborations as $collaboration) {
            // Create 3-8 todos for each collaboration
            foreach(range(1, fake()->numberBetween(3, 8)) as $index) {
                Todo::create([
                    'collaboration_id' => $collaboration->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->optional()->paragraph(),
                    'status' => fake()->randomElement(['pending', 'completed']),
                    'created_by' => $collaboration->members->random()->id,
                ]);
            }
        }
    }
}
