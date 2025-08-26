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
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234567890'),
        ]);

        User::factory()->create([
            'name' => 'Silvia',
            'email' => 'silvia@gmail.com',
            'password' => bcrypt('1234567890'),
        ]);
       
        User::factory()->create([
            'name' => 'Shelly',
            'email' => 'Shelly@gmail.com',
            'password' => bcrypt('1234567890'),
        ]);

        // Create regular users
        User::factory(10)->create();
    }
}
