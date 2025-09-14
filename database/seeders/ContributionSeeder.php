<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    public function run()
    {
        $contributions = [
            // Sumber Daya yang Disumbangkan (Resources Contributed)
            [
                'name' => 'Dana',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'currency-dollar',
                'description' => 'Kontribusi berupa dana atau pendanaan untuk mendukung kegiatan kolaborasi',
            ],
            [
                'name' => 'Infrastruktur',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'building-office',
                'description' => 'Kontribusi berupa infrastruktur fisik atau fasilitas untuk mendukung kegiatan',
            ],
            [
                'name' => 'Relasi',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'user-group',
                'description' => 'Kontribusi berupa jaringan relasi dan koneksi untuk memperluas dampak kolaborasi',
            ],
            [
                'name' => 'Keahlian',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'academic-cap',
                'description' => 'Kontribusi berupa keahlian, pengetahuan, dan keterampilan khusus',
            ],
            [
                'name' => 'Akses Pasar',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'chart-bar',
                'description' => 'Kontribusi berupa akses ke pasar, pelanggan, atau target audiens',
            ],
            [
                'name' => 'Teknologi',
                'category' => 'Sumber Daya yang Disumbangkan',
                'icon' => 'computer-desktop',
                'description' => 'Kontribusi berupa teknologi, platform, atau tools untuk mendukung kolaborasi',
            ],
        ];

        foreach ($contributions as $contribution) {
            Contribution::create($contribution);
        }
    }
}
