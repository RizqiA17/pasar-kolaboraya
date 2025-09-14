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

        // Add users to containers
        foreach ($containers as $container) {
            // Add first 3 users to each container
            $usersToAdd = $users->take(3);
            
            foreach ($usersToAdd as $user) {
                ContainerUser::create([
                    'container_id' => $container->id,
                    'user_id' => $user->id,
                    'role' => $user->id === $users->first()->id ? 'admin' : 'member',
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('ContainerUser seeding completed!');
    }
}
