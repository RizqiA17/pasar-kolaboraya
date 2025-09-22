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
        // Clear existing data to avoid duplicates
        Peran::query()->delete();
        
        $peranData = [
            [
                'nama' => 'Pemantik Nyala Komunitas',
                'deskripsi' => 'Gigih mengangkat isu, mengidentifikasi tantangan, serta memantik aksi kolektif',
            ],
            [
                'nama' => 'Pencipta Ruang Inovasi',
                'deskripsi' => 'Menciptakan ruang fisik maupun digital sebagai wadah berkumpul dan berproses memasak ide baru dan inovatif',
            ],
            [
                'nama' => 'Perawat Kesejahteraan',
                'deskripsi' => 'Merawat ruang jumpa dan proses kerjasama yang sehat dalam aksi kolektif',
            ],
            [
                'nama' => 'Pembangun Jaringan',
                'deskripsi' => 'Memfasilitasi perjumpaan para kreator perubahan sosial dan membangun koneksi antar aktor ekosistem untuk membentuk jaringan yang lebih luas',
            ],
            [
                'nama' => 'Penghubung Gerakan',
                'deskripsi' => 'Menghubungkan aksi-aksi kolektif untuk bersinergi memperluas jangkauan dan dampak',
            ],
            [
                'nama' => 'Penghubung Sumber Daya',
                'deskripsi' => 'Mempertemukan para kreator perubahan sosial yang membutuhkan sumber daya dengan investor sosial',
            ],
            [
                'nama' => 'Dirijen Kolaborasi',
                'deskripsi' => 'Mengorkestrasi keberagaman dalam ekosistem untuk menciptakan kolaborasi skala besar',
            ],
            [
                'nama' => 'Pemimpin Adaptif',
                'deskripsi' => 'Jiwa-jiwa yang tekun belajar, adaptif dengan perubahan, serta mendorong semangat belajar dan berinovasi di komunitasnya',
            ],
            [
                'nama' => 'Pemetaan Sekutu',
                'deskripsi' => 'Memetakan kawan seperjalanan: siapa sedang melakukan apa dalam ekosistem',
            ],
            [
                'nama' => 'Arsitek Teknologi',
                'deskripsi' => 'Merancang infrastruktur teknologi untuk mengoptimalkan kerja kreator perubahan sosial dan aksi kolektif',
            ],
            [
                'nama' => 'Perancang Interaksi Sosial',
                'deskripsi' => 'Merancang cara-cara interaktif untuk menciptakan pengalaman bermakna dan holistik dari sebuah inovasi sosial',
            ],
            [
                'nama' => 'Pelopor Ekonomi Baru',
                'deskripsi' => 'Mengeksplorasi cara-cara baru sistem ekonomi yang berpihak pada rakyat dan memandirikan masyarakat sipil',
            ],
            [
                'nama' => 'Pemikir Masa Depan',
                'deskripsi' => 'Melihat arah masa depan dan membaca situasi untuk menentukan strategi mewujudkan visi kolektif',
            ],
            [
                'nama' => 'Penjaga Nilai',
                'deskripsi' => 'Memastikan keputusan dan pelaksanaan kebijakan menjunjung tinggi prinsip, nilai dan moral, memprioritaskan keadilan sosial',
            ],
            [
                'nama' => 'Pemantau Tren',
                'deskripsi' => 'Memantau tren, mengidentifikasi peluang untuk menciptakan momentum untuk melakukan aksi kolektif',
            ],
            [
                'nama' => 'Pembaharu Narasi',
                'deskripsi' => 'Menantang narasi dominan dengan menciptakan narasi baru yang membangun daya kritis; serta mempromosikan inklusi dan empati',
            ],
            [
                'nama' => 'Penyaji Data',
                'deskripsi' => 'Memilih dan menerjemahkan data yang kompleks menjadi sajian yang menarik, mudah diakses dan dipahami',
            ],
            [
                'nama' => 'Pengukur Dampak',
                'deskripsi' => 'Mencari cara mengukur dampak sosial agar hasilnya menjadi produk pengetahuan yang mudah dipahami dan menginspirasi inovasi baru',
            ],
            [
                'nama' => 'Pendorong Potensi',
                'deskripsi' => 'Membantu anggota ekosistem mengoptimalkan potensi dengan memanfaatkan kapasitas yang mereka miliki',
            ],
            [
                'nama' => 'Pengampu Belajar',
                'deskripsi' => 'Berbagi atau memfasilitasi pertukaran pengetahuan dan proses refleksi dalam ekosistem pembelajar',
            ],
            [
                'nama' => 'Penjelajah Dana Kreatif',
                'deskripsi' => 'Mengidentifikasi dan membukakan jalan-jalan ke aliran pendanaan baru dan beragam untuk inisiatif inovasi sosial dan aksi kolektif',
            ],
            [
                'nama' => 'Si Siaga Tangguh',
                'deskripsi' => 'Memperkuat kapasitas individu dan komunitas untuk melakukan mitigasi dan tangguh beradaptasi dengan tantangan dan perubahan besar',
            ],
            [
                'nama' => 'Penguat Kerja Tim',
                'deskripsi' => 'Memfasilitasi kelompok untuk bisa bekerja sama mewujudkan tujuan terbaiknya',
            ],
            [
                'nama' => 'Perancang Kebijakan',
                'deskripsi' => 'Merancang terobosan yang lebih inklusif dan memberdayakan masyarakat sipil dalam pengembangan kebijakan',
            ],
            [
                'nama' => 'Advokat Kebijakan',
                'deskripsi' => 'Memperjuangkan transformasi kebijakan yang berpihak pada masyarakat sipil',
            ],
            [
                'nama' => 'Penjahit Kisah',
                'deskripsi' => 'Menjahit cerita-cerita akar rumput mengenai aksi kolektif dan dampaknya',
            ],
            [
                'nama' => 'Penyusun Pesan',
                'deskripsi' => 'Menyusun pesan utama dari inisiatif inovasi sosial untuk dibagikan sesuai target audiens',
            ],
            [
                'nama' => 'Suporter Setia',
                'deskripsi' => 'Memberikan dukungan dengan hadir secara fisik maupun digital, serta turut merayakan kemenangan besar dan kecil',
            ],
            [
                'nama' => 'Investor Sosial',
                'deskripsi' => 'Berinvestasi pada bisnis maupun inovasi ramah sosial dan lingkungan',
            ],
            [
                'nama' => 'Pembagi Informasi',
                'deskripsi' => 'Semangat menyebarluaskan pesan terkait dengan inovasi sosial melalui berbagai saluran dan jaringan',
            ],
        ];

        foreach ($peranData as $peran) {
            Peran::create($peran);
        }
    }
}
