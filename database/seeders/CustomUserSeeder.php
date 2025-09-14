<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if test user already exists
        if (User::where('email', 'test@gmail.com')->exists()) {
            $this->command->info('Test user already exists. Skipping test user creation.');
            return;
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('1234567890'),
            'role' => 'user',
        ]);
    }
}
