<?php

namespace Database\Seeders;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionLike;
use App\Models\Ecosystem;
use App\Models\EcosystemLike;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users with different types
        $partisipan = User::create([
            'name' => 'Test Partisipan',
            'email' => 'partisipan@test.com',
            'password' => bcrypt('password'),
            'user_type' => 'partisipan',
            'approval_status' => 'approved',
            'email_verified_at' => now(),
        ]);

        $tamu = User::create([
            'name' => 'Test Tamu',
            'email' => 'tamu@test.com',
            'password' => bcrypt('password'),
            'user_type' => 'tamu',
            'approval_status' => 'approved',
            'email_verified_at' => now(),
        ]);

        $komunitas = User::create([
            'name' => 'Test Komunitas',
            'email' => 'komunitas@test.com',
            'password' => bcrypt('password'),
            'user_type' => 'komunitas',
            'approval_status' => 'approved',
            'email_verified_at' => now(),
        ]);

        // Test like functionality
        echo "Testing like functionality...\n";
        
        // Test user methods
        echo "Partisipan can like: " . ($partisipan->canLike() ? 'Yes' : 'No') . "\n";
        echo "Tamu can like: " . ($tamu->canLike() ? 'Yes' : 'No') . "\n";
        echo "Komunitas can like: " . ($komunitas->canLike() ? 'Yes' : 'No') . "\n";
        
        echo "Partisipan is guest or invitation: " . ($partisipan->isGuestOrInvitation() ? 'Yes' : 'No') . "\n";
        echo "Tamu is guest or invitation: " . ($tamu->isGuestOrInvitation() ? 'Yes' : 'No') . "\n";
        echo "Komunitas is guest or invitation: " . ($komunitas->isGuestOrInvitation() ? 'Yes' : 'No') . "\n";
        
        echo "Like functionality test completed successfully!\n";
    }
}
