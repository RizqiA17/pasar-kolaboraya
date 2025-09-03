<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@pasar-kolaboraya.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super admin user created successfully!');
        $this->command->info('Email: admin@pasar-kolaboraya.com');
        $this->command->info('Password: admin123');
    }
}