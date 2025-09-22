<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PasarKolaboraya;
use App\Models\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if users already exist
        if (User::count() > 0) {
            $this->command->info('Users already exist. Skipping user creation.');
            return;
        }

        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@nemolab.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'is_ecosystem_builder' => true,
            'ecosystem_builder_status' => 'approved',
            'ecosystem_builder_reason' => 'System administrator with full access to all features.',
            'ecosystem_builder_approved_at' => now(),
            'ecosystem_builder_approved_by' => 1,
            'email_verified_at' => now(),
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'admin',
            'is_ecosystem_builder' => true,
            'ecosystem_builder_status' => 'approved',
            'ecosystem_builder_reason' => 'Administrator with ecosystem building privileges.',
            'ecosystem_builder_approved_at' => now(),
            'ecosystem_builder_approved_by' => $superAdmin->id,
            'email_verified_at' => now(),
        ]);

        // Create test users with specific roles
        $testUsers = [
            [
                'name' => 'Silvia',
                'email' => 'silvia@gmail.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Shelly',
                'email' => 'shelly@gmail.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Sarah Mitchell',
                'email' => 'sarah.mitchell@test.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => true,
                'ecosystem_builder_status' => 'approved',
                'ecosystem_builder_reason' => 'Test ecosystem builder for development.',
                'ecosystem_builder_approved_at' => now(),
                'ecosystem_builder_approved_by' => $superAdmin->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@test.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => true,
                'ecosystem_builder_status' => 'pending',
                'ecosystem_builder_reason' => 'Pending approval for ecosystem building.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@test.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@test.com',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'is_ecosystem_builder' => false,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($testUsers as $userData) {
            User::create($userData);
        }

        // Create additional regular users
        User::factory(15)->create([
            'role' => 'user',
            'is_ecosystem_builder' => false,
            'email_verified_at' => now(),
        ]);

        // Set active Pasar Kolaboraya for some users (will be set after PasarKolaborayaSeeder runs)
        $this->command->info('User seeder completed successfully!');
    }
}
