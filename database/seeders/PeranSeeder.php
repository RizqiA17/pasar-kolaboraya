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
                'nama' => 'PEMANTIK NYALA KOMUNITAS',
                'deskripsi' => 'Gigih mengangkat isu, mengidentifikasi tantangan, serta memantik aksi kolektif',
            ],
            [
                'nama' => 'PENCIPTA RUANG INOVASI',
                'deskripsi' => 'Menciptakan ruang fisik maupun digital sebagai wadah berkumpul dan berproses memasak ide baru dan inovatif',
            ],
            [
                'nama' => 'PERAWAT KESEJAHTERAAN',
                'deskripsi' => 'Merawat ruang jumpa dan proses kerjasama yang sehat dalam aksi kolektif',
            ],
            [
                'nama' => 'PEMBANGUN JARINGAN',
                'deskripsi' => 'Memfasilitasi perjumpaan para kreator perubahan sosial dan membangun koneksi antar aktor ekosistem untuk membentuk jaringan yang lebih luas',
            ],
            [
                'nama' => 'PENGHUBUNG GERAKAN',
                'deskripsi' => 'Menghubungkan aksi-aksi kolektif untuk bersinergi memperluas jangkauan dan dampak',
            ],
            [
                'nama' => 'PENGHUBUNG SUMBER DAYA',
                'deskripsi' => 'Mempertemukan para kreator perubahan sosial yang membutuhkan sumber daya dengan investor sosial',
            ],
            [
                'nama' => 'DIRIJEN KOLABORASI',
                'deskripsi' => 'Mengorkestrasi keberagaman dalam ekosistem untuk menciptakan kolaborasi skala besar',
            ],
            [
                'nama' => 'PEMIMPIN ADAPTIF',
                'deskripsi' => 'Jiwa-jiwa yang tekun belajar, adaptif dengan perubahan, serta mendorong semangat belajar dan berinovasi di komunitasnya',
            ],
            [
                'nama' => 'PEMETA SEKUTU',
                'deskripsi' => 'Memetakan kawan seperjalanan: siapa sedang melakukan apa dalam ekosistem',
            ],
            [
                'nama' => 'ARSITEK TEKNOLOGI',
                'deskripsi' => 'Merancang infrastruktur teknologi untuk mengoptimalkan kerja kreator perubahan sosial dan aksi kolektif',
            ],
            [
                'nama' => 'PERANCANG INTERAKSI SOSIAL',
                'deskripsi' => 'Merancang cara-cara interaktif untuk menciptakan pengalaman bermakna dan holistik dari sebuah inovasi sosial',
            ],
            [
                'nama' => 'PELOPOR EKONOMI BARU',
                'deskripsi' => 'Mengeksplorasi cara-cara baru sistem ekonomi yang berpihak pada rakyat dan memandirikan masyarakat sipil',
            ],
            [
                'nama' => 'PEMIKIR MASA DEPAN',
                'deskripsi' => 'Melihat arah masa depan dan membaca situasi untuk menentukan strategi mewujudkan visi kolektif',
            ],
            [
                'nama' => 'PENJAGA NILAI',
                'deskripsi' => 'Memastikan keputusan dan pelaksanaan kebijakan menjunjung tinggi prinsip, nilai dan moral, memprioritaskan keadilan sosial',
            ],
            [
                'nama' => 'PEMANTAU TREN',
                'deskripsi' => 'Memantau tren, mengidentifikasi peluang untuk menciptakan momentum untuk melakukan aksi kolektif',
            ],
            [
                'nama' => 'PEMBAHARU NARASI',
                'deskripsi' => 'Menantang narasi dominan dengan menciptakan narasi baru yang membangun daya kritis; serta mempromosikan inklusi dan empati',
            ],
            [
                'nama' => 'PENYAJI DATA',
                'deskripsi' => 'Memilih dan menerjemahkan data yang kompleks menjadi sajian yang menarik, mudah diakses dan dipahami',
            ],
            [
                'nama' => 'PENGUKUR DAMPAK',
                'deskripsi' => 'Mencari cara mengukur dampak sosial agar hasilnya menjadi produk pengetahuan yang mudah dipahami dan menginspirasi inovasi baru',
            ],
            [
                'nama' => 'PENDORONG POTENSI',
                'deskripsi' => 'Membantu anggota ekosistem mengoptimalkan potensi dengan memanfaatkan kapasitas yang mereka miliki',
            ],
            [
                'nama' => 'PENGAMPU BELAJAR',
                'deskripsi' => 'Berbagi atau memfasilitasi pertukaran pengetahuan dan proses refleksi dalam ekosistem pembelajar',
            ],
            [
                'nama' => 'PENJELAJAH DANA KREATIF',
                'deskripsi' => 'Mengidentifikasi dan membukakan jalan-jalan ke aliran pendanaan baru dan beragam untuk inisiatif inovasi sosial dan aksi kolektif',
            ],
            [
                'nama' => 'SI SIAGA TANGGUH',
                'deskripsi' => 'Memperkuat kapasitas individu dan komunitas untuk melakukan mitigasi dan tangguh beradaptasi dengan tantangan dan perubahan besar',
            ],
            [
                'nama' => 'PENGUAT KERJA TIM',
                'deskripsi' => 'Memfasilitasi kelompok untuk bisa bekerja sama mewujudkan tujuan terbaiknya',
            ],
            [
                'nama' => 'PERANCANG KEBIJAKAN',
                'deskripsi' => 'Merancang terobosan yang lebih inklusif dan memberdayakan masyarakat sipil dalam pengembangan kebijakan',
            ],
            [
                'nama' => 'ADVOKAT KEBIJAKAN',
                'deskripsi' => 'Memperjuangkan transformasi kebijakan yang berpihak pada masyarakat sipil',
            ],
            [
                'nama' => 'PENJAHIT KISAH',
                'deskripsi' => 'Menjahit cerita-cerita akar rumput mengenai aksi kolektif dan dampaknya',
            ],
            [
                'nama' => 'PENYUSUN PESAN',
                'deskripsi' => 'Menyusun pesan utama dari inisiatif inovasi sosial untuk dibagikan sesuai target audiens',
            ],
            [
                'nama' => 'SUPORTER SETIA',
                'deskripsi' => 'Memberikan dukungan dengan hadir secara fisik maupun digital, serta turut merayakan kemenangan besar dan kecil',
            ],
            [
                'nama' => 'INVESTOR SOSIAL',
                'deskripsi' => 'Berinvestasi pada bisnis maupun inovasi ramah sosial dan lingkungan',
            ],
            [
                'nama' => 'PEMBAGI INFORMASI',
                'deskripsi' => 'Semangat menyebarluaskan pesan terkait dengan inovasi sosial melalui berbagai saluran dan jaringan',
            ],
        ];

        foreach ($peranData as $peran) {
            Peran::create($peran);
        }
    }
}
