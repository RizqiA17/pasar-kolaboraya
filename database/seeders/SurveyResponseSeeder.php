<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get surveys
        $activeSurvey = Survey::where('is_active', true)->first();
        $historicalSurvey = Survey::where('name', 'Survey Baseline Komunitas 2024')->first();
        
        if (!$activeSurvey || !$historicalSurvey) {
            $this->command->error('Surveys not found. Please run SurveySeeder first.');
            return;
        }

        // Get regular users (exclude super admin)
        $users = User::where('role', '!=', 'super_admin')->get();
        
        if ($users->count() < 3) {
            $this->command->error('Not enough users found. Please run UserSeeder first.');
            return;
        }

        // Clear existing responses
        SurveyResponse::query()->delete();

        // Sample responses for historical survey (completed survey)
        $this->createHistoricalResponses($historicalSurvey, $users->take(8));
        
        // Sample responses for active survey (ongoing)
        $this->createActiveResponses($activeSurvey, $users->take(5));

        $this->command->info('Survey response seeder completed successfully!');
    }

    private function createHistoricalResponses(Survey $survey, $users)
    {
        $responses = [
            [
                // Response 1 - Active collaborator
                'jumlah_koneksi' => 15,
                'jumlah_koneksi_alasan' => 'Aktif dalam komunitas lokal dan memiliki jaringan bisnis yang cukup luas',
                'rata_kualitas_koneksi' => 4,
                'rata_kualitas_koneksi_alasan' => 'Mayoritas koneksi memberikan nilai tambah dan saling mendukung',
                'keluasan_jejaring' => 3,
                'keluasan_jejaring_alasan' => 'Terbatas pada sektor pertanian dan UMKM lokal',
                'kualitas_kolaborasi' => 4,
                'kualitas_kolaborasi_alasan' => 'Kolaborasi menghasilkan manfaat nyata untuk semua pihak',
                'keragaman_kolaborator' => 5,
                'keragaman_kolaborator_alasan' => 'Berkolaborasi dengan petani, pedagang, NGO, dan pemerintah daerah',
                'jumlah_proyek_kolaborasi' => 3,
                'jumlah_proyek_kolaborasi_alasan' => 'Terlibat dalam koperasi tani, pasar tani, dan program CSR',
                'tingkat_kolaborasi' => 4,
                'tingkat_kolaborasi_alasan' => 'Kontribusi aktif dalam perencanaan dan pelaksanaan',
                'sumber_daya_disumbangkan' => ['keahlian', 'relasi', 'infrastruktur'],
                'sumber_daya_disumbangkan_alasan' => 'Menyediakan lahan, expertise pertanian, dan koneksi ke pembeli',
                'jumlah_aksi_besar' => 1,
                'jumlah_aksi_besar_alasan' => 'Memimpin pembentukan koperasi tani regional',
                'jumlah_aksi_sedang' => 2,
                'jumlah_aksi_sedang_alasan' => 'Mengorganisir pasar tani bulanan dan program pelatihan',
                'jumlah_aksi_kecil' => 8,
                'jumlah_aksi_kecil_alasan' => 'Rutin menghadiri pertemuan, berbagi informasi, dan membantu koordinasi'
            ],
            [
                // Response 2 - Moderate participant
                'jumlah_koneksi' => 8,
                'jumlah_koneksi_alasan' => 'Masih baru dalam komunitas, fokus membangun relasi',
                'rata_kualitas_koneksi' => 3,
                'rata_kualitas_koneksi_alasan' => 'Beberapa koneksi baik, namun masih dalam tahap pengenalan',
                'keluasan_jejaring' => 2,
                'keluasan_jejaring_alasan' => 'Terbatas pada sesama pedagang kecil di pasar lokal',
                'kualitas_kolaborasi' => 3,
                'kualitas_kolaborasi_alasan' => 'Kolaborasi berjalan lancar tapi belum optimal',
                'keragaman_kolaborator' => 3,
                'keragaman_kolaborator_alasan' => 'Mainly bekerja dengan sesama pedagang dan beberapa supplier',
                'jumlah_proyek_kolaborasi' => 1,
                'jumlah_proyek_kolaborasi_alasan' => 'Bergabung dalam grup WhatsApp koordinasi pedagang',
                'tingkat_kolaborasi' => 3,
                'tingkat_kolaborasi_alasan' => 'Partisipasi aktif namun masih belajar',
                'sumber_daya_disumbangkan' => ['dana'],
                'sumber_daya_disumbangkan_alasan' => 'Kontribusi iuran untuk kegiatan bersama',
                'jumlah_aksi_besar' => 0,
                'jumlah_aksi_besar_alasan' => 'Belum terlibat dalam inisiatif besar',
                'jumlah_aksi_sedang' => 1,
                'jumlah_aksi_sedang_alasan' => 'Membantu mengorganisir bazar komunitas',
                'jumlah_aksi_kecil' => 5,
                'jumlah_aksi_kecil_alasan' => 'Berbagi informasi harga, membantu promosi antar pedagang'
            ],
            [
                // Response 3 - High-impact connector
                'jumlah_koneksi' => 25,
                'jumlah_koneksi_alasan' => 'Sebagai koordinator NGO, memiliki jaringan luas lintas sektor',
                'rata_kualitas_koneksi' => 5,
                'rata_kualitas_koneksi_alasan' => 'Koneksi terbangun dari trust dan track record panjang',
                'keluasan_jejaring' => 5,
                'keluasan_jejaring_alasan' => 'Mencakup pemerintah, swasta, NGO, akademisi, dan komunitas',
                'kualitas_kolaborasi' => 5,
                'kualitas_kolaborasi_alasan' => 'Kolaborasi menghasilkan dampak sistemik dan berkelanjutan',
                'keragaman_kolaborator' => 5,
                'keragaman_kolaborator_alasan' => 'Partner dari berbagai latar belakang dan sektor',
                'jumlah_proyek_kolaborasi' => 6,
                'jumlah_proyek_kolaborasi_alasan' => 'Mengelola multiple program pemberdayaan masyarakat',
                'tingkat_kolaborasi' => 5,
                'tingkat_kolaborasi_alasan' => 'Leading role dalam design dan implementasi program',
                'sumber_daya_disumbangkan' => ['dana', 'keahlian', 'relasi', 'akses_pasar'],
                'sumber_daya_disumbangkan_alasan' => 'Mobilisasi funding, expertise, network, dan market access',
                'jumlah_aksi_besar' => 3,
                'jumlah_aksi_besar_alasan' => 'Inisiasi program regional, pembentukan asosiasi, advocacy policy',
                'jumlah_aksi_sedang' => 5,
                'jumlah_aksi_sedang_alasan' => 'Workshop capacity building, pilot project, research',
                'jumlah_aksi_kecil' => 12,
                'jumlah_aksi_kecil_alasan' => 'Mentoring, networking events, konsultasi rutin'
            ]
        ];

        foreach ($responses as $index => $responseData) {
            if ($index < $users->count()) {
                SurveyResponse::create(array_merge([
                    'survey_id' => $survey->id,
                    'user_id' => $users[$index]->id,
                ], $responseData));
            }
        }

        // Create additional simpler responses for other users
        $remainingUsers = $users->skip(3);
        foreach ($remainingUsers as $user) {
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'user_id' => $user->id,
                'jumlah_koneksi' => rand(5, 20),
                'jumlah_koneksi_alasan' => 'Koneksi dari aktivitas sehari-hari dan komunitas lokal',
                'rata_kualitas_koneksi' => rand(2, 4),
                'rata_kualitas_koneksi_alasan' => 'Bervariasi, ada yang supportif ada yang biasa saja',
                'keluasan_jejaring' => rand(1, 4),
                'keluasan_jejaring_alasan' => 'Masih terbatas pada lingkup tertentu',
                'kualitas_kolaborasi' => rand(2, 4),
                'kualitas_kolaborasi_alasan' => 'Kolaborasi cukup baik dengan hasil yang memuaskan',
                'keragaman_kolaborator' => rand(2, 4),
                'keragaman_kolaborator_alasan' => 'Bekerja dengan beberapa jenis mitra',
                'jumlah_proyek_kolaborasi' => rand(1, 3),
                'jumlah_proyek_kolaborasi_alasan' => 'Terlibat dalam beberapa kegiatan komunitas',
                'tingkat_kolaborasi' => rand(2, 4),
                'tingkat_kolaborasi_alasan' => 'Partisipasi aktif sesuai kemampuan',
                'sumber_daya_disumbangkan' => $this->getRandomResources(),
                'sumber_daya_disumbangkan_alasan' => 'Kontribusi sesuai keahlian dan kemampuan',
                'jumlah_aksi_besar' => rand(0, 1),
                'jumlah_aksi_besar_alasan' => rand(0, 1) ? 'Terlibat dalam satu inisiatif besar' : 'Belum terlibat dalam aksi besar',
                'jumlah_aksi_sedang' => rand(1, 3),
                'jumlah_aksi_sedang_alasan' => 'Berpartisipasi dalam kegiatan komunitas tingkat menengah',
                'jumlah_aksi_kecil' => rand(3, 10),
                'jumlah_aksi_kecil_alasan' => 'Aktivitas rutin dalam komunitas'
            ]);
        }
    }

    private function createActiveResponses(Survey $survey, $users)
    {
        // Create some responses for the active survey (ongoing)
        $responses = [
            [
                // Response 1 - Improved collaborator
                'jumlah_koneksi' => 18,
                'jumlah_koneksi_alasan' => 'Bertambah setelah menggunakan platform Pasar Kolaboraya',
                'rata_kualitas_koneksi' => 4,
                'rata_kualitas_koneksi_alasan' => 'Platform membantu menemukan mitra yang lebih tepat',
                'keluasan_jejaring' => 4,
                'keluasan_jejaring_alasan' => 'Mulai ekspansi ke sektor lain melalui ekosistem platform',
                'kualitas_kolaborasi' => 4,
                'kualitas_kolaborasi_alasan' => 'Sistem tracking membantu koordinasi lebih baik',
                'keragaman_kolaborator' => 4,
                'keragaman_kolaborator_alasan' => 'Platform memfasilitasi kolaborasi lintas sektor',
                'jumlah_proyek_kolaborasi' => 4,
                'jumlah_proyek_kolaborasi_alasan' => 'Bertambah 1 proyek melalui platform',
                'tingkat_kolaborasi' => 4,
                'tingkat_kolaborasi_alasan' => 'Lebih terstruktur dengan adanya sistem digital',
                'sumber_daya_disumbangkan' => ['keahlian', 'relasi', 'teknologi'],
                'sumber_daya_disumbangkan_alasan' => 'Memanfaatkan fitur platform untuk berbagi resources',
                'jumlah_aksi_besar' => 1,
                'jumlah_aksi_besar_alasan' => 'Melanjutkan inisiatif koperasi dengan digitalisasi',
                'jumlah_aksi_sedang' => 3,
                'jumlah_aksi_sedang_alasan' => 'Menggunakan platform untuk koordinasi kegiatan',
                'jumlah_aksi_kecil' => 10,
                'jumlah_aksi_kecil_alasan' => 'Aktivitas harian lebih efisien dengan platform'
            ],
            [
                // Response 2 - Platform adopter
                'jumlah_koneksi' => 12,
                'jumlah_koneksi_alasan' => 'Peningkatan signifikan melalui fitur koneksi platform',
                'rata_kualitas_koneksi' => 4,
                'rata_kualitas_koneksi_alasan' => 'Platform membantu filter koneksi berkualitas',
                'keluasan_jejaring' => 3,
                'keluasan_jejaring_alasan' => 'Mulai terhubung dengan ekosistem yang lebih luas',
                'kualitas_kolaborasi' => 4,
                'kualitas_kolaborasi_alasan' => 'Tools kolaborasi platform sangat membantu',
                'keragaman_kolaborator' => 4,
                'keragaman_kolaborator_alasan' => 'Sistem matching platform sangat efektif',
                'jumlah_proyek_kolaborasi' => 2,
                'jumlah_proyek_kolaborasi_alasan' => 'Ikut 1 collective action melalui platform',
                'tingkat_kolaborasi' => 4,
                'tingkat_kolaborasi_alasan' => 'Platform memberikan struktur yang jelas',
                'sumber_daya_disumbangkan' => ['dana', 'keahlian'],
                'sumber_daya_disumbangkan_alasan' => 'Kontribusi melalui sistem yang transparan',
                'jumlah_aksi_besar' => 0,
                'jumlah_aksi_besar_alasan' => 'Masih dalam tahap belajar menggunakan platform',
                'jumlah_aksi_sedang' => 2,
                'jumlah_aksi_sedang_alasan' => 'Berpartisipasi dalam collective action tingkat menengah',
                'jumlah_aksi_kecil' => 7,
                'jumlah_aksi_kecil_alasan' => 'Rutin menggunakan fitur-fitur platform'
            ]
        ];

        foreach ($responses as $index => $responseData) {
            if ($index < $users->count()) {
                SurveyResponse::create(array_merge([
                    'survey_id' => $survey->id,
                    'user_id' => $users[$index]->id,
                ], $responseData));
            }
        }

        // Create additional responses for remaining users
        $remainingUsers = $users->skip(2);
        foreach ($remainingUsers as $user) {
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'user_id' => $user->id,
                'jumlah_koneksi' => rand(8, 15),
                'jumlah_koneksi_alasan' => 'Mengalami peningkatan sejak bergabung dengan platform',
                'rata_kualitas_koneksi' => rand(3, 5),
                'rata_kualitas_koneksi_alasan' => 'Platform membantu menemukan koneksi yang relevan',
                'keluasan_jejaring' => rand(2, 4),
                'keluasan_jejaring_alasan' => 'Mulai eksplorasi ekosistem baru melalui platform',
                'kualitas_kolaborasi' => rand(3, 5),
                'kualitas_kolaborasi_alasan' => 'Tools dan sistem platform sangat membantu',
                'keragaman_kolaborator' => rand(3, 4),
                'keragaman_kolaborator_alasan' => 'Platform memfasilitasi kolaborasi yang beragam',
                'jumlah_proyek_kolaborasi' => rand(1, 3),
                'jumlah_proyek_kolaborasi_alasan' => 'Terlibat dalam beberapa inisiatif platform',
                'tingkat_kolaborasi' => rand(3, 4),
                'tingkat_kolaborasi_alasan' => 'Sistem platform memberikan struktur yang baik',
                'sumber_daya_disumbangkan' => $this->getRandomResources(),
                'sumber_daya_disumbangkan_alasan' => 'Berkontribusi melalui sistem platform',
                'jumlah_aksi_besar' => rand(0, 1),
                'jumlah_aksi_besar_alasan' => rand(0, 1) ? 'Mulai terlibat dalam collective action besar' : 'Masih dalam tahap eksplorasi',
                'jumlah_aksi_sedang' => rand(1, 3),
                'jumlah_aksi_sedang_alasan' => 'Berpartisipasi dalam berbagai kegiatan platform',
                'jumlah_aksi_kecil' => rand(5, 12),
                'jumlah_aksi_kecil_alasan' => 'Aktivitas rutin menggunakan platform'
            ]);
        }
    }

    private function getRandomResources()
    {
        $resources = ['dana', 'keahlian', 'infrastruktur', 'akses_pasar', 'relasi', 'teknologi'];
        $count = rand(1, 3);
        return array_slice($resources, 0, $count);
    }
}
