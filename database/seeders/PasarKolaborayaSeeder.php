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
        $admin = User::where('role', 'admin')->first();
        
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
                'settings' => [
                    'allow_ecosystem_creation' => true,
                    'allow_collective_actions' => true,
                    'auto_approve_joins' => false,
                    'max_ecosystems_per_user' => 3,
                ],
            ],
            [
                'name' => 'Ekosistem Kreatif Bandung',
                'description' => 'Komunitas kreatif Bandung yang berfokus pada seni, desain, dan industri kreatif.',
                'status' => 'active',
                'settings' => [
                    'allow_ecosystem_creation' => true,
                    'allow_collective_actions' => true,
                    'auto_approve_joins' => true,
                    'max_ecosystems_per_user' => 2,
                ],
            ],
            [
                'name' => 'Kolaborasi UMKM Surabaya',
                'description' => 'Platform kolaborasi untuk UMKM di Surabaya dan sekitarnya. Bertujuan untuk meningkatkan daya saing dan pertumbuhan bisnis.',
                'status' => 'active',
                'settings' => [
                    'allow_ecosystem_creation' => true,
                    'allow_collective_actions' => true,
                    'auto_approve_joins' => false,
                    'max_ecosystems_per_user' => 5,
                ],
            ],
            [
                'name' => 'Inovasi Teknologi Yogyakarta',
                'description' => 'Komunitas teknologi dan inovasi di Yogyakarta. Fokus pada pengembangan solusi teknologi untuk masyarakat.',
                'status' => 'inactive',
                'settings' => [
                    'allow_ecosystem_creation' => false,
                    'allow_collective_actions' => false,
                    'auto_approve_joins' => false,
                    'max_ecosystems_per_user' => 1,
                ],
            ],
        ];

        $activePasarKolaboraya = null;

        foreach ($pasarKolaborayas as $data) {
            $pasarKolaboraya = PasarKolaboraya::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'created_by' => $superAdmin->id,
                'status' => $data['status'],
                'settings' => $data['settings'],
                'started_at' => now(),
            ]);

            // Add super admin as admin
            $pasarKolaboraya->addUser($superAdmin, 'admin', 'Creator of Pasar Kolaboraya');

            // Add admin as admin if exists
            if ($admin) {
                $pasarKolaboraya->addUser($admin, 'admin', 'System administrator', $superAdmin);
            }

            // Set first active Pasar Kolaboraya
            if ($data['status'] === 'active' && !$activePasarKolaboraya) {
                $activePasarKolaboraya = $pasarKolaboraya;
            }

            $this->command->info("Created Pasar Kolaboraya: {$pasarKolaboraya->name}");
        }

        // Add users to active Pasar Kolaboraya and set as their active session
        if ($activePasarKolaboraya) {
            $regularUsers = User::where('role', 'user')->limit(8)->get();
            foreach ($regularUsers as $user) {
                $pasarKolaboraya->addUser($user, 'member', 'Invited by admin', $superAdmin);
                
                // Set as active Pasar Kolaboraya for some users
                if (fake()->boolean(60)) { // 60% chance
                    $user->update(['active_pasar_kolaboraya_id' => $activePasarKolaboraya->id]);
                }
            }

            // Set super admin's active Pasar Kolaboraya
            $superAdmin->update(['active_pasar_kolaboraya_id' => $activePasarKolaboraya->id]);
            
            if ($admin) {
                $admin->update(['active_pasar_kolaboraya_id' => $activePasarKolaboraya->id]);
            }
        }

        $this->command->info('Pasar Kolaboraya seeding completed!');
    }
}
