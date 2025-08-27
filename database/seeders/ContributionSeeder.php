<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    public function run()
    {
        $contributions = [
            // Program & Inisiatif
            [
                'name' => 'Program Pendidikan',
                'category' => 'Program & Inisiatif',
                'icon' => 'academic-cap',
                'description' => 'Menginisiasi atau berkontribusi dalam program pendidikan',
            ],
            [
                'name' => 'Kampanye Lingkungan',
                'category' => 'Program & Inisiatif',
                'icon' => 'globe',
                'description' => 'Menginisiasi atau berkontribusi dalam kampanye lingkungan',
            ],
            [
                'name' => 'Program Pemberdayaan',
                'category' => 'Program & Inisiatif',
                'icon' => 'users',
                'description' => 'Menginisiasi atau berkontribusi dalam program pemberdayaan',
            ],

            // Pengembangan Komunitas
            [
                'name' => 'Pembentukan Komunitas',
                'category' => 'Pengembangan Komunitas',
                'icon' => 'user-group',
                'description' => 'Membentuk atau mengembangkan komunitas',
            ],
            [
                'name' => 'Pelatihan & Workshop',
                'category' => 'Pengembangan Komunitas',
                'icon' => 'presentation',
                'description' => 'Memberikan pelatihan atau workshop',
            ],
            [
                'name' => 'Mentoring',
                'category' => 'Pengembangan Komunitas',
                'icon' => 'chat',
                'description' => 'Menjadi mentor atau pembimbing',
            ],

            // Kolaborasi & Kemitraan
            [
                'name' => 'Kolaborasi Lintas Sektor',
                'category' => 'Kolaborasi & Kemitraan',
                'icon' => 'puzzle',
                'description' => 'Membangun kolaborasi antar sektor',
            ],
            [
                'name' => 'Kemitraan Strategis',
                'category' => 'Kolaborasi & Kemitraan',
                'icon' => 'handshake',
                'description' => 'Membangun kemitraan strategis',
            ],
            [
                'name' => 'Jejaring Sosial',
                'category' => 'Kolaborasi & Kemitraan',
                'icon' => 'network',
                'description' => 'Membangun jejaring sosial',
            ],

            // Inovasi & Solusi
            [
                'name' => 'Inovasi Teknologi',
                'category' => 'Inovasi & Solusi',
                'icon' => 'light-bulb',
                'description' => 'Mengembangkan inovasi teknologi',
            ],
            [
                'name' => 'Solusi Sosial',
                'category' => 'Inovasi & Solusi',
                'icon' => 'star',
                'description' => 'Mengembangkan solusi untuk masalah sosial',
            ],
            [
                'name' => 'Riset & Publikasi',
                'category' => 'Inovasi & Solusi',
                'icon' => 'document-text',
                'description' => 'Melakukan riset dan publikasi',
            ],
        ];

        foreach ($contributions as $contribution) {
            Contribution::create($contribution);
        }
    }
}
