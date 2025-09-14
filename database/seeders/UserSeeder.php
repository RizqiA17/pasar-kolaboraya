<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('1234567890'),
            'role' => 'super_admin',
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234567890'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Silvia',
            'email' => 'silvia@gmail.com',
            'password' => bcrypt('1234567890'),
            'role' => 'user',
        ]);
       
        User::factory()->create([
            'name' => 'Shelly',
            'email' => 'Shelly@gmail.com',
            'password' => bcrypt('1234567890'),
            'role' => 'user',
        ]);

        // Create regular users
        User::factory(10)->create([
            'role' => 'user',
        ]);
    }
}
