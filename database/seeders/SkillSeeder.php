<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run()
    {
        // Check if skills already exist
        if (Skill::count() > 0) {
            $this->command->info('Skills already exist. Skipping skill creation.');
            return;
        }

        $skills = [
            // Manajemen & Organisasi
            [
                'name' => 'Project Management',
                'category' => 'Manajemen & Organisasi',
                'icon' => 'clipboard',
                'description' => 'Kemampuan mengelola dan mengkoordinasi proyek',
            ],
            [
                'name' => 'Community Building',
                'category' => 'Manajemen & Organisasi',
                'icon' => 'users',
                'description' => 'Kemampuan membangun dan mengelola komunitas',
            ],
            [
                'name' => 'Event Management',
                'category' => 'Manajemen & Organisasi',
                'icon' => 'calendar',
                'description' => 'Kemampuan merencanakan dan mengelola event',
            ],

            // Komunikasi & Media
            [
                'name' => 'Public Speaking',
                'category' => 'Komunikasi & Media',
                'icon' => 'microphone',
                'description' => 'Kemampuan berbicara di depan publik',
            ],
            [
                'name' => 'Content Creation',
                'category' => 'Komunikasi & Media',
                'icon' => 'pencil',
                'description' => 'Kemampuan membuat konten digital',
            ],
            [
                'name' => 'Social Media Management',
                'category' => 'Komunikasi & Media',
                'icon' => 'share',
                'description' => 'Kemampuan mengelola media sosial',
            ],

            // Teknis & Implementasi
            [
                'name' => 'Data Analysis',
                'category' => 'Teknis & Implementasi',
                'icon' => 'chart-bar',
                'description' => 'Kemampuan menganalisis dan menginterpretasi data',
            ],
            [
                'name' => 'Web Development',
                'category' => 'Teknis & Implementasi',
                'icon' => 'code',
                'description' => 'Kemampuan mengembangkan aplikasi web',
            ],
            [
                'name' => 'Design Thinking',
                'category' => 'Teknis & Implementasi',
                'icon' => 'light-bulb',
                'description' => 'Kemampuan menerapkan metode design thinking',
            ],

            // Riset & Pengembangan
            [
                'name' => 'Research',
                'category' => 'Riset & Pengembangan',
                'icon' => 'search',
                'description' => 'Kemampuan melakukan penelitian dan riset',
            ],
            [
                'name' => 'Program Development',
                'category' => 'Riset & Pengembangan',
                'icon' => 'document',
                'description' => 'Kemampuan mengembangkan program',
            ],
            [
                'name' => 'Impact Assessment',
                'category' => 'Riset & Pengembangan',
                'icon' => 'chart-pie',
                'description' => 'Kemampuan mengukur dan menilai dampak',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
