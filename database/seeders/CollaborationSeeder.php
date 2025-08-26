<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        // Create 8 collaborations
        foreach(range(1, 8) as $index) {
            $collaboration = Collaboration::create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'status' => fake()->randomElement(['active', 'completed', 'on-hold']),
                'creator_id' => $users->random()->id,
            ]);

            // Attach 2-5 random members to each collaboration
            $members = $users->random(fake()->numberBetween(2, 5));
            $collaboration->members()->attach($members->pluck('id'));
        }
    }
}
