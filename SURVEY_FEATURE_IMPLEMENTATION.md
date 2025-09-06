# Survey Feature Implementation - Pasar Kolaboraya

## Deskripsi Fitur

Fitur survey telah berhasil diimplementasikan sepenuhnya dalam proyek Pasar Kolaboraya. Fitur ini memungkinkan admin untuk membuat dan mengelola survey, sementara user dapat mengisi survey yang tersedia di dashboard.

## Fitur yang Diimplementasikan

### 1. Admin Survey Management
- **Membuat Survey**: Admin dapat membuat survey baru dengan nama dan deskripsi
- **Aktivasi Survey**: Hanya satu survey yang dapat aktif bersamaan
- **Manajemen Status**: Admin dapat mengaktifkan/menonaktifkan survey
- **Melihat Hasil**: Admin dapat melihat hasil survey dengan rata-rata dan radar chart
- **Alasan Anonim**: Admin dapat melihat alasan dari setiap pertanyaan secara anonim

### 2. User Survey Participation
- **Survey Card di Dashboard**: Menampilkan survey aktif di dashboard user
- **Multi-step Form**: Proses pengisian survey dengan 3 kategori
- **Validasi**: Validasi input untuk setiap kategori
- **Pencegahan Duplikasi**: User tidak bisa mengisi survey yang sama dua kali

### 3. Struktur Survey
Survey terdiri dari 3 kategori dengan pertanyaan sebagai berikut:

#### Kategori Koneksi:
1. Jumlah koneksi (angka bebas)
2. Rata-rata kualitas koneksi (1-5)
3. Keluasan jejaring (jumlah sektor unik)

#### Kategori Kolaborasi:
1. Kualitas kolaborasi (1-5)
2. Keragaman kolaborator (jumlah jenis/segmen)
3. Jumlah proyek kolaborasi
4. Tingkat kolaborasi (1-5)
5. Sumber daya yang disumbangkan (dana, keahlian, infrastruktur, akses pasar, relasi, teknologi)

#### Kategori Aksi:
1. Jumlah aksi besar
2. Jumlah aksi sedang
3. Jumlah aksi kecil

**Setiap pertanyaan memiliki field alasan di bawahnya.**

### 4. Hasil Survey untuk Admin
- **Rata-rata**: Semua data dihitung rata-rata dari semua pengirim
- **Alasan Anonim**: Ditampilkan tanpa identitas pengirim
- **Radar Chart**: Visualisasi data menggunakan Chart.js
- **Tab Navigation**: Ringkasan, Radar Chart, dan Alasan Anonim

## Struktur Database

### Tabel `surveys`:
- `id` - Primary key
- `name` - Nama survey
- `description` - Deskripsi survey
- `is_active` - Status aktif (boolean)
- `created_by` - Foreign key ke users
- `started_at` - Waktu mulai aktif
- `ended_at` - Waktu berakhir
- `created_at`, `updated_at` - Timestamps

### Tabel `survey_responses`:
- `id` - Primary key
- `survey_id` - Foreign key ke surveys
- `user_id` - Foreign key ke users
- **Kategori Koneksi**: `jumlah_koneksi`, `rata_kualitas_koneksi`, `keluasan_jejaring`
- **Kategori Kolaborasi**: `kualitas_kolaborasi`, `keragaman_kolaborator`, `jumlah_proyek_kolaborasi`, `tingkat_kolaborasi`, `sumber_daya_disumbangkan`
- **Kategori Aksi**: `jumlah_aksi_besar`, `jumlah_aksi_sedang`, `jumlah_aksi_kecil`
- **Alasan**: Field `*_alasan` untuk setiap pertanyaan
- `created_at`, `updated_at` - Timestamps
- **Unique constraint**: (`survey_id`, `user_id`) - mencegah duplikasi respon

## File-file yang Dibuat/Dimodifikasi

### Models:
- `app/Models/Survey.php` - Model survey dengan relationships dan methods rata-rata
- `app/Models/SurveyResponse.php` - Model respon survey
- `app/Models/User.php` - Ditambahkan relationships dengan survey

### Migrations:
- `database/migrations/2025_09_06_031402_create_surveys_table.php`
- `database/migrations/2025_09_06_031416_create_survey_responses_table.php`

### Livewire Components:
- `app/Livewire/Admin/Surveys/Index.php` - Manajemen daftar survey
- `app/Livewire/Admin/Surveys/Create.php` - Form membuat survey
- `app/Livewire/Admin/Surveys/Results.php` - Hasil survey dengan chart
- `app/Livewire/Survey/Participate.php` - Form pengisian survey user
- `app/Livewire/Dashboard/SurveyCard.php` - Kartu survey di dashboard

### Views:
- `resources/views/livewire/admin/surveys/index.blade.php`
- `resources/views/livewire/admin/surveys/create.blade.php`
- `resources/views/livewire/admin/surveys/results.blade.php`
- `resources/views/livewire/survey/participate.blade.php`
- `resources/views/livewire/dashboard/survey-card.blade.php`

### Routes:
- Admin: `/admin/surveys` - Manajemen survey
- Admin: `/admin/surveys/{survey}/results` - Hasil survey
- User: `/survey/participate` - Pengisian survey

### Seeders:
- `database/seeders/SurveySeeder.php` - Data sample survey

## Dependencies Tambahan
- **Chart.js** - Untuk radar chart visualisasi

## Akses Admin
- **Email**: admin@pasar-kolaboraya.com
- **Password**: admin123
- **URL Admin**: `/admin`
- **URL Survey**: `/admin/surveys`

## Cara Menggunakan

### Untuk Admin:
1. Login sebagai super admin
2. Pergi ke menu "Survey" di sidebar admin
3. Klik "Buat Survey Baru"
4. Isi nama dan deskripsi survey
5. Aktifkan survey untuk membuatnya tersedia bagi user
6. Lihat hasil di kolom "Hasil" setelah ada yang mengisi

### Untuk User:
1. Login sebagai user biasa
2. Di dashboard, akan muncul kartu "Survey Aktif" (jika ada survey aktif)
3. Klik "Ikuti Survey"
4. Isi survey step by step:
   - Step 1: Kategori Koneksi
   - Step 2: Kategori Kolaborasi
   - Step 3: Kategori Aksi
5. Setiap pertanyaan memiliki field alasan opsional
6. Submit survey setelah step terakhir

## Fitur Khusus

### Radar Chart
- Menampilkan visualisasi data survey dalam bentuk radar chart
- Data dinormalisasi untuk skala 0-100
- Menggunakan Chart.js untuk rendering
- Responsive dan interaktif

### Multi-step Form
- Form dibagi menjadi 3 step untuk UX yang lebih baik
- Validasi per step
- Progress indicator
- Navigasi prev/next

### Anonymous Feedback
- Alasan ditampilkan secara anonim untuk admin
- Hanya menampilkan "Responden X" tanpa identitas

### Single Active Survey
- Hanya satu survey yang dapat aktif bersamaan
- Otomatis menonaktifkan survey lain ketika mengaktifkan survey baru
- Mencegah konflik dan memfokuskan partisipasi

## Testing
Survey feature telah diuji dengan data sample dan berfungsi dengan baik. Semua flow dari pembuatan hingga pengisian dan melihat hasil telah berhasil diimplementasikan.

## Status Implementasi
✅ **COMPLETED** - Semua fitur survey telah berhasil diimplementasikan sesuai requirements.
