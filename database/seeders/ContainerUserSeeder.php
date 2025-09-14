<?php

namespace Database\Seeders;

use App\Models\Container;
use App\Models\ContainerUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContainerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if container users already exist
        if (ContainerUser::count() > 0) {
            $this->command->info('Container users already exist. Skipping container user creation.');
            return;
        }

        $containers = Container::all();
        $users = User::all();

        if ($containers->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No containers or users found. Please run ContainerSeeder and UserSeeder first.');
            return;
        }

        // Get super admin and admin users
        $superAdmin = User::where('role', 'super_admin')->first();
        $admin = User::where('role', 'admin')->first();
        $regularUsers = User::where('role', 'user')->get();

        // Add users to containers
        foreach ($containers as $container) {
            // Add super admin as admin to all containers
            if ($superAdmin) {
                ContainerUser::create([
                    'container_id' => $container->id,
                    'user_id' => $superAdmin->id,
                    'role' => 'admin',
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
            }

            // Add admin as admin to active containers
            if ($admin && $container->status === 'active') {
                ContainerUser::create([
                    'container_id' => $container->id,
                    'user_id' => $admin->id,
                    'role' => 'admin',
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
            }

            // Add regular users to containers
            $usersToAdd = $regularUsers->random(min(5, $regularUsers->count()));
            
            foreach ($usersToAdd as $user) {
                $role = fake()->randomElement(['member', 'member', 'member', 'admin']); // 75% member, 25% admin
                $status = $container->status === 'active' ? 'active' : 'inactive';
                
                ContainerUser::create([
                    'container_id' => $container->id,
                    'user_id' => $user->id,
                    'role' => $role,
                    'status' => $status,
                    'joined_at' => $status === 'active' ? now() : null,
                ]);
            }
        }

        $this->command->info('ContainerUser seeding completed!');
    }
}
