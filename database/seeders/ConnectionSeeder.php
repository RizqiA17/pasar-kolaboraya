<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Connection;
use App\Models\PasarKolaboraya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting ConnectionSeeder...');

        // Check if connections already exist
        if (Connection::count() > 0) {
            $this->command->info('Connections already exist. Skipping connection creation.');
            return;
        }

        // Get active PasarKolaboraya session
        $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        
        if (!$pasarKolaboraya) {
            $this->command->warn('No active PasarKolaboraya session found. Creating connections without session context.');
        }

        // Get all users (excluding soft deleted)
        $users = User::whereNull('deleted_at')->get();
        
        if ($users->count() < 2) {
            $this->command->warn('Not enough users to create connections. Need at least 2 users.');
            return;
        }

        $this->command->info("Found {$users->count()} users. Creating connections...");
        
        $connectionsCreated = 0;
        $totalUsers = $users->count();
        $processedUsers = 0;
        
        // Use transaction for better performance
        DB::transaction(function () use ($users, $pasarKolaboraya, &$connectionsCreated, &$processedUsers, $totalUsers) {
            foreach ($users as $user) {
                $processedUsers++;
                
                // Show progress every 10 users
                if ($processedUsers % 10 == 0 || $processedUsers == $totalUsers) {
                    $this->command->info("Processing user {$processedUsers}/{$totalUsers}");
                }

                // Create 2-8 connections for each user (more realistic range)
                $numberOfConnections = fake()->numberBetween(2, min(8, $totalUsers - 1));
                
                // Get other users excluding current user
                $otherUsers = $users->where('id', '!=', $user->id)->random($numberOfConnections);
                
                foreach ($otherUsers as $otherUser) {
                    // Check for existing connection more efficiently
                    $existingConnection = Connection::where(function($query) use ($user, $otherUser) {
                        $query->where('requester_id', $user->id)
                              ->where('receiver_id', $otherUser->id);
                    })->orWhere(function($query) use ($user, $otherUser) {
                        $query->where('requester_id', $otherUser->id)
                              ->where('receiver_id', $user->id);
                    })->exists();

                    if (!$existingConnection) {
                        // More realistic status distribution: 70% accepted, 20% pending, 10% rejected
                        $status = fake()->randomElement([
                            'accepted', 'accepted', 'accepted', 'accepted', 'accepted', 'accepted', 'accepted',
                            'pending', 'pending', 'rejected'
                        ]);
                        
                        // Create realistic timestamps
                        $createdAt = fake()->dateTimeBetween('-6 months', 'now');
                        $updatedAt = $status === 'accepted' 
                            ? fake()->dateTimeBetween($createdAt, 'now')
                            : $createdAt;

                        Connection::create([
                            'requester_id' => $user->id,
                            'receiver_id' => $otherUser->id,
                            'pasar_kolaboraya_id' => $pasarKolaboraya?->id,
                            'status' => $status,
                            'created_at' => $createdAt,
                            'updated_at' => $updatedAt,
                        ]);
                        $connectionsCreated++;
                    }
                }
            }
        });

        $this->command->info("ConnectionSeeder completed successfully!");
        $this->command->info("Created {$connectionsCreated} connections for {$totalUsers} users");
        
        // Show some statistics
        $acceptedCount = Connection::where('status', 'accepted')->count();
        $pendingCount = Connection::where('status', 'pending')->count();
        $rejectedCount = Connection::where('status', 'rejected')->count();
        
        $this->command->info("Connection statistics:");
        $this->command->info("- Accepted: {$acceptedCount}");
        $this->command->info("- Pending: {$pendingCount}");
        $this->command->info("- Rejected: {$rejectedCount}");
    }
}
