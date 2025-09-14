<?php

namespace Database\Seeders;

use App\Models\Container;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if containers already exist
        if (Container::count() > 0) {
            $this->command->info('Containers already exist. Skipping container creation.');
            return;
        }

        // Get super admin
        $superAdmin = User::where('role', 'super_admin')->first();
        
        if (!$superAdmin) {
            $this->command->error('Super admin not found. Please run UserSeeder first.');
            return;
        }

        // Create sample containers
        $containers = [
            [
                'name' => 'Container Utama',
                'description' => 'Container utama untuk pengembangan aplikasi dan kolaborasi tim',
                'status' => 'active',
            ],
            [
                'name' => 'Container Testing',
                'description' => 'Container untuk testing dan development fitur baru',
                'status' => 'active',
            ],
            [
                'name' => 'Container Archive',
                'description' => 'Container untuk menyimpan data arsip dan proyek selesai',
                'status' => 'inactive',
            ],
            [
                'name' => 'Container Kolaborasi',
                'description' => 'Container khusus untuk proyek kolaborasi antar tim',
                'status' => 'active',
            ],
            [
                'name' => 'Container Research',
                'description' => 'Container untuk penelitian dan pengembangan ide baru',
                'status' => 'active',
            ],
        ];

        $activeContainer = null;

        foreach ($containers as $data) {
            $container = Container::create($data);
            
            // Set first active container
            if ($data['status'] === 'active' && !$activeContainer) {
                $activeContainer = $container;
            }

            $this->command->info("Created Container: {$container->name}");
        }

        // Set active container for some users
        if ($activeContainer) {
            $users = User::where('role', 'user')->limit(5)->get();
            foreach ($users as $user) {
                if (fake()->boolean(70)) { // 70% chance
                    $user->update(['active_container_id' => $activeContainer->id]);
                }
            }

            // Set super admin's active container
            $superAdmin->update(['active_container_id' => $activeContainer->id]);
        }

        $this->command->info('Container seeding completed!');
    }
}
