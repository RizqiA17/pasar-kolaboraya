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
        $pasarKolaboraya = \App\Models\PasarKolaboraya::where('status', 'active')->first();
        $connectionsCreated = 0;
        
        foreach ($users as $user) {
            // Create 2-6 connections for each user
            $numberOfConnections = fake()->numberBetween(2, 6);
            $otherUsers = $users->where('id', '!=', $user->id)->random($numberOfConnections);
            
            foreach ($otherUsers as $otherUser) {
                // Avoid duplicate connections
                $existingConnection = Connection::where(function($query) use ($user, $otherUser) {
                    $query->where('requester_id', $user->id)
                          ->where('receiver_id', $otherUser->id);
                })->orWhere(function($query) use ($user, $otherUser) {
                    $query->where('requester_id', $otherUser->id)
                          ->where('receiver_id', $user->id);
                })->exists();

                if (!$existingConnection) {
                    // More realistic status distribution: 60% accepted, 25% pending, 15% rejected
                    $status = fake()->randomElement(['accepted', 'accepted', 'accepted', 'accepted', 'accepted', 'accepted', 'pending', 'pending', 'pending', 'rejected', 'rejected']);
                    
                    Connection::create([
                        'requester_id' => $user->id,
                        'receiver_id' => $otherUser->id,
                        'pasar_kolaboraya_id' => $pasarKolaboraya?->id,
                        'status' => $status,
                    ]);
                    $connectionsCreated++;
                }
            }
        }

        $this->command->info("Connection seeder completed! Created {$connectionsCreated} connections.");
    }
}
