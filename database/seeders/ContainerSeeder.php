<?php

namespace Database\Seeders;

use App\Models\Container;
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

        // Create sample containers
        $containers = [
            [
                'name' => 'Container Utama',
                'description' => 'Container utama untuk pengembangan aplikasi',
                'status' => 'active',
            ],
            [
                'name' => 'Container Testing',
                'description' => 'Container untuk testing dan development',
                'status' => 'active',
            ],
            [
                'name' => 'Container Archive',
                'description' => 'Container untuk menyimpan data arsip',
                'status' => 'inactive',
            ],
        ];

        foreach ($containers as $data) {
            Container::create($data);
        }

        $this->command->info('Container seeding completed!');
    }
}
