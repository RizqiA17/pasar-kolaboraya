<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Workshop & Pelatihan',
                'icon' => 'academic-cap',
                'description' => 'Event pembelajaran dan pengembangan kapasitas',
            ],
            [
                'name' => 'Seminar & Konferensi',
                'icon' => 'presentation-chart',
                'description' => 'Event berbagi pengetahuan dan networking',
            ],
            [
                'name' => 'Aksi Sosial',
                'icon' => 'heart',
                'description' => 'Event kegiatan sosial dan kemanusiaan',
            ],
            [
                'name' => 'Hackathon & Innovation',
                'icon' => 'light-bulb',
                'description' => 'Event pengembangan solusi dan inovasi',
            ],
            [
                'name' => 'Festival & Pameran',
                'icon' => 'ticket',
                'description' => 'Event showcase dan perayaan',
            ],
            [
                'name' => 'Diskusi & Forum',
                'icon' => 'chat-alt',
                'description' => 'Event dialog dan pertukaran ide',
            ],
            [
                'name' => 'Kolaborasi & Co-creation',
                'icon' => 'users',
                'description' => 'Event kolaborasi dan penciptaan bersama',
            ],
            [
                'name' => 'Kampanye & Awareness',
                'icon' => 'speakerphone',
                'description' => 'Event penyadaran dan kampanye publik',
            ],
        ];

        DB::table('event_categories')->insert($categories);
    }
}
