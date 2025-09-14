<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if connections already exist
        if (Connection::count() > 0) {
            $this->command->info('Connections already exist. Skipping connection creation.');
            return;
        }

        $users = User::all();
        
        foreach ($users as $user) {
            // Create 3-5 connections for each user
            $numberOfConnections = fake()->numberBetween(3, 5);
            $otherUsers = $users->where('id', '!=', $user->id)->random($numberOfConnections);
            
            foreach ($otherUsers as $otherUser) {
                Connection::create([
                    'requester_id' => $user->id,
                    'receiver_id' => $otherUser->id,
                    'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
                ]);
            }
        }
    }
}
