<?php

namespace Database\Seeders;

use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasarKolaborayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Pasar Kolaboraya already exist
        if (PasarKolaboraya::count() > 0) {
            $this->command->info('Pasar Kolaboraya already exist. Skipping Pasar Kolaboraya creation.');
            return;
        }

        // Get super admin
        $superAdmin = User::where('role', 'super_admin')->first();
        
        if (!$superAdmin) {
            $this->command->error('Super admin not found. Please run UserSeeder first.');
            return;
        }

        // Create sample Pasar Kolaboraya
        $pasarKolaborayas = [
            [
                'name' => 'Kolaborasi Startup Jakarta 2025',
                'description' => 'Ruang kolaborasi untuk startup dan entrepreneur di Jakarta. Fokus pada inovasi teknologi dan pengembangan bisnis.',
                'status' => 'active',
            ],
            [
                'name' => 'Ekosistem Kreatif Bandung',
                'description' => 'Komunitas kreatif Bandung yang berfokus pada seni, desain, dan industri kreatif.',
                'status' => 'active',
            ],
            [
                'name' => 'Kolaborasi UMKM Surabaya',
                'description' => 'Platform kolaborasi untuk UMKM di Surabaya dan sekitarnya. Bertujuan untuk meningkatkan daya saing dan pertumbuhan bisnis.',
                'status' => 'active',
            ],
            [
                'name' => 'Inovasi Teknologi Yogyakarta',
                'description' => 'Komunitas teknologi dan inovasi di Yogyakarta. Fokus pada pengembangan solusi teknologi untuk masyarakat.',
                'status' => 'inactive',
            ],
        ];

        foreach ($pasarKolaborayas as $data) {
            $pasarKolaboraya = PasarKolaboraya::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'created_by' => $superAdmin->id,
                'status' => $data['status'],
                'started_at' => now(),
            ]);

            // Add super admin as admin
            $pasarKolaboraya->addUser($superAdmin, 'admin', 'Creator of Pasar Kolaboraya');

            // Add some regular users to the first Pasar Kolaboraya
            if ($pasarKolaboraya->name === 'Kolaborasi Startup Jakarta 2025') {
                $regularUsers = User::where('role', 'user')->limit(5)->get();
                foreach ($regularUsers as $user) {
                    $pasarKolaboraya->addUser($user, 'member', 'Invited by admin', $superAdmin);
                }
            }

            $this->command->info("Created Pasar Kolaboraya: {$pasarKolaboraya->name}");
        }

        $this->command->info('Pasar Kolaboraya seeding completed!');
    }
}
