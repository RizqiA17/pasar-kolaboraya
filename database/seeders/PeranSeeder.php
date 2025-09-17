<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peran;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peranData = [
            [
                'nama' => 'Pemimpin Komunitas',
                'deskripsi' => 'Memimpin dan mengkoordinasikan kegiatan komunitas, membuat keputusan strategis, dan memastikan visi komunitas tercapai.',
            ],
            [
                'nama' => 'Anggota Aktif',
                'deskripsi' => 'Berpartisipasi aktif dalam kegiatan komunitas, memberikan kontribusi nyata, dan mendukung program-program yang ada.',
            ],
            [
                'nama' => 'Relawan',
                'deskripsi' => 'Memberikan waktu dan tenaga secara sukarela untuk mendukung berbagai kegiatan dan program komunitas.',
            ],
            [
                'nama' => 'Mentor',
                'deskripsi' => 'Membimbing dan memberikan pengalaman serta pengetahuan kepada anggota komunitas yang lebih junior.',
            ],
            [
                'nama' => 'Koordinator Event',
                'deskripsi' => 'Mengorganisir dan mengelola berbagai acara dan kegiatan komunitas dari perencanaan hingga eksekusi.',
            ],
            [
                'nama' => 'Kontributor Konten',
                'deskripsi' => 'Membuat dan berbagi konten berkualitas untuk mendukung visi dan misi komunitas.',
            ],
            [
                'nama' => 'Pengamat',
                'deskripsi' => 'Mengikuti perkembangan komunitas dan memberikan masukan konstruktif untuk perbaikan.',
            ],
        ];

        foreach ($peranData as $peran) {
            Peran::create($peran);
        }
    }
}
