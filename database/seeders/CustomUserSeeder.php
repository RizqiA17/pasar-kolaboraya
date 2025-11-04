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
	$email = 'admin@pasar-kolaboraya.com';
        // Check if test user already exists
        if (User::where('email', $email)->exists()) {
            $this->command->info('User already exists. Skipping user creation.');
            return;
        }

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => bcrypt('1234567890'),
            'role' => 'super_admin',
        ]);
    }
}
