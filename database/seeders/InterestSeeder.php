<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    public function run()
    {
        // Check if interests already exist
        if (Interest::count() > 0) {
            $this->command->info('Interests already exist. Skipping interest creation.');
            return;
        }

        $interests = [
            // Sosial & Komunitas
            [
                'name' => 'Pemberdayaan Masyarakat',
                'category' => 'Sosial & Komunitas',
                'icon' => 'users-group',
                'description' => 'Fokus pada pengembangan dan pemberdayaan masyarakat lokal',
            ],
            [
                'name' => 'Pendidikan',
                'category' => 'Sosial & Komunitas',
                'icon' => 'academic-cap',
                'description' => 'Pengembangan pendidikan dan literasi masyarakat',
            ],
            [
                'name' => 'Kesehatan',
                'category' => 'Sosial & Komunitas',
                'icon' => 'heart',
                'description' => 'Peningkatan akses dan kualitas kesehatan masyarakat',
            ],

            // Lingkungan
            [
                'name' => 'Konservasi Alam',
                'category' => 'Lingkungan',
                'icon' => 'tree',
                'description' => 'Pelestarian lingkungan dan ekosistem alam',
            ],
            [
                'name' => 'Pengelolaan Sampah',
                'category' => 'Lingkungan',
                'icon' => 'recycle',
                'description' => 'Manajemen dan daur ulang sampah',
            ],
            [
                'name' => 'Energi Terbarukan',
                'category' => 'Lingkungan',
                'icon' => 'sun',
                'description' => 'Pengembangan dan implementasi energi berkelanjutan',
            ],

            // Ekonomi & Pemberdayaan
            [
                'name' => 'UMKM',
                'category' => 'Ekonomi & Pemberdayaan',
                'icon' => 'store',
                'description' => 'Pengembangan usaha mikro, kecil, dan menengah',
            ],
            [
                'name' => 'Koperasi',
                'category' => 'Ekonomi & Pemberdayaan',
                'icon' => 'currency',
                'description' => 'Pengembangan sistem koperasi dan ekonomi kolaboratif',
            ],
            [
                'name' => 'Pertanian Berkelanjutan',
                'category' => 'Ekonomi & Pemberdayaan',
                'icon' => 'leaf',
                'description' => 'Pengembangan sistem pertanian yang berkelanjutan',
            ],

            // Teknologi & Inovasi
            [
                'name' => 'Teknologi Tepat Guna',
                'category' => 'Teknologi & Inovasi',
                'icon' => 'chip',
                'description' => 'Pengembangan teknologi yang sesuai kebutuhan lokal',
            ],
            [
                'name' => 'Digital Literacy',
                'category' => 'Teknologi & Inovasi',
                'icon' => 'computer',
                'description' => 'Peningkatan kemampuan digital masyarakat',
            ],
            [
                'name' => 'Smart City',
                'category' => 'Teknologi & Inovasi',
                'icon' => 'building',
                'description' => 'Pengembangan kota pintar dan berkelanjutan',
            ],
        ];

        foreach ($interests as $interest) {
            Interest::create($interest);
        }
    }
}
