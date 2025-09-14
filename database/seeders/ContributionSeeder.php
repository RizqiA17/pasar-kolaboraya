<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contributions = [
            [
                'name' => 'Relawan/Tenaga',
                'icon' => 'fas fa-hands-helping',
                'category' => 'volunteer',
                'description' => 'Kontribusi berupa tenaga dan waktu untuk membantu kegiatan',
            ],
            [
                'name' => 'Dana/Pendanaan',
                'icon' => 'fas fa-money-bill-wave',
                'category' => 'funding',
                'description' => 'Kontribusi berupa dana untuk mendukung kegiatan',
            ],
            [
                'name' => 'Keahlian/Expertise',
                'icon' => 'fas fa-user-graduate',
                'category' => 'expertise',
                'description' => 'Kontribusi berupa keahlian dan pengetahuan khusus',
            ],
            [
                'name' => 'Sumber Daya/Fasilitas',
                'icon' => 'fas fa-tools',
                'category' => 'resources',
                'description' => 'Kontribusi berupa fasilitas, peralatan, atau sumber daya lainnya',
            ],
            [
                'name' => 'Promosi/Marketing',
                'icon' => 'fas fa-bullhorn',
                'category' => 'promotion',
                'description' => 'Kontribusi berupa promosi dan pemasaran kegiatan',
            ],
            [
                'name' => 'Lainnya',
                'icon' => 'fas fa-ellipsis-h',
                'category' => 'other',
                'description' => 'Kontribusi lainnya yang tidak termasuk dalam kategori di atas',
            ],
        ];

        foreach ($contributions as $contribution) {
            Contribution::updateOrCreate(
                ['name' => $contribution['name']],
                $contribution
            );
        }
    }
}