# Implementasi Pengukuran Kualitas Ekosistem Berdasarkan Keragaman Peran

## Overview
Fitur ini menambahkan pengukuran kualitas ekosistem berdasarkan keragaman peran yang berada di dalam ekosistem. Pengukuran ini menggunakan Shannon Diversity Index untuk menghitung seberapa beragam peran-peran yang ada di antara anggota ekosistem.

## Fitur yang Ditambahkan

### 1. Metrik Keragaman Peran (Role Diversity Score)
- **Lokasi**: `app/Models/Ecosystem.php` - method `calculateRoleDiversityScore()`
- **Algoritma**: Shannon Diversity Index
- **Skala**: 0-100%
- **Bonus**: Hingga 20% bonus untuk jumlah peran unik yang lebih banyak

### 2. Detail Keragaman Peran
- **Lokasi**: `app/Models/Ecosystem.php` - method `getRoleDiversityDetails()`
- **Data yang disediakan**:
  - Total anggota
  - Jumlah peran unik
  - Anggota tanpa peran
  - Distribusi peran dengan persentase

### 3. Visualisasi Dashboard
- **Lokasi**: `resources/views/livewire/ecosystem/dashboard.blade.php`
- **Komponen**:
  - Card keragaman peran di overview
  - Detail lengkap di tab "Quality"
  - Progress bar di chart section
  - Distribusi peran dengan visual bar

## Cara Kerja

### Perhitungan Shannon Diversity Index
```php
// Hitung proporsi setiap peran
$proportion = $count / $totalMembers;

// Hitung Shannon Index
$shannonIndex -= $proportion * log($proportion);

// Normalisasi ke skala 0-100
$maxShannon = log($uniqueRoles);
$normalizedScore = ($shannonIndex / $maxShannon) * 100;

// Tambah bonus untuk peran unik
$roleCountBonus = min($uniqueRoles * 2, 20);
```

### Skor Ekosistem yang Diperbarui
Skor ekosistem sekarang dihitung dari 7 metrik:
1. Tingkat Aktivasi (Membership Activation Rate)
2. Tingkat Penerimaan (Ecosystem Acceptance Rate)
3. Tingkat Penyelesaian (Contribution Completion Rate)
4. Keragaman Kontribusi (Contribution Diversity)
5. Kesesuaian Peran (Role Fit)
6. **Keragaman Peran (Role Diversity)** - BARU
7. Keterlibatan Aksi Kolektif (Engagement in Collective Actions)

## Tampilan Dashboard

### Overview Cards
- Card baru dengan warna cyan untuk "Keragaman Peran"
- Menampilkan skor persentase

### Tab Quality - Detail Section
- Informasi lengkap tentang distribusi peran
- Visual bar untuk setiap peran
- Statistik anggota dengan dan tanpa peran

### Chart Section
- Progress bar untuk keragaman peran
- Detail statistik di tooltip

## Keuntungan

1. **Pengukuran Objektif**: Menggunakan algoritma matematis yang terbukti
2. **Visualisasi Jelas**: Menampilkan distribusi peran secara visual
3. **Insight Mendalam**: Memberikan informasi detail tentang komposisi peran
4. **Motivasi Peningkatan**: Membantu mengidentifikasi area yang perlu ditingkatkan

## Contoh Interpretasi

- **Skor 90-100%**: Ekosistem dengan keragaman peran sangat tinggi, distribusi merata
- **Skor 70-89%**: Keragaman peran baik, beberapa peran dominan
- **Skor 50-69%**: Keragaman peran sedang, beberapa peran sangat dominan
- **Skor 0-49%**: Keragaman peran rendah, dominasi beberapa peran

## Dependencies

- Model `Peran` untuk data peran
- Model `Profile` untuk relasi peran user
- Model `Ecosystem` untuk perhitungan skor
- Livewire component `Ecosystem\Dashboard` untuk tampilan

## Testing

Untuk menguji fitur ini:
1. Buat ekosistem dengan beberapa anggota
2. Assign peran yang berbeda ke setiap anggota
3. Lihat skor keragaman peran di dashboard ekosistem
4. Verifikasi distribusi peran ditampilkan dengan benar

## Catatan Teknis

- Method `calculateRoleDiversityScore()` dipanggil dalam `calculateEkosistemScore()`
- Data detail disimpan dalam `role_diversity_details` array
- Skor dinormalisasi untuk memastikan konsistensi dengan metrik lain
- Bonus peran unik mendorong diversifikasi peran di ekosistem
