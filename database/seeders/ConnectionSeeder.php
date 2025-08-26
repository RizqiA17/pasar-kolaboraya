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
        $users = User::all();
        
        foreach ($users as $user) {
            // Create 3-5 connections for each user
            $numberOfConnections = fake()->numberBetween(3, 5);
            $otherUsers = $users->where('id', '!=', $user->id)->random($numberOfConnections);
            
            foreach ($otherUsers as $otherUser) {
                Connection::create([
                    'user_id' => $user->id,
                    'connected_user_id' => $otherUser->id,
                    'status' => 'accepted',
                    'connected_at' => now(),
                ]);
            }
        }
    }
}
