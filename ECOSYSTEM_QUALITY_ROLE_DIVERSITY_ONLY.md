# Implementasi Kualitas Ekosistem Berdasarkan Keragaman Peran

## Overview
Fitur ini mengubah perhitungan kualitas ekosistem menjadi **HANYA** berdasarkan keragaman peran dengan rumus sederhana: **Peran yang Ada / Total Seluruh Peran di Database**.

## Perubahan Utama

### 1. Model Ecosystem (`app/Models/Ecosystem.php`)
- **Method `calculateEkosistemScore()`** diubah total untuk hanya menghitung keragaman peran
- **Rumus**: `(existing_roles_count / total_roles_in_database) * 100`
- **Return**: Hanya `ekosistem_score` dan `role_diversity_score` yang sama
- **Details**: Informasi peran yang ada, total peran database, dan daftar nama peran

### 2. Dashboard Ekosistem (`resources/views/livewire/ecosystem/dashboard.blade.php`)

#### Overview Cards (3 cards):
1. **Kualitas Ekosistem** - Skor utama berdasarkan keragaman peran
2. **Keragaman Peran** - Persentase peran yang ada vs total
3. **Peran Tersedia** - Rasio peran yang ada / total peran database

#### Tab Quality - Detail Section:
1. **Keragaman Peran** - Detail perhitungan dan statistik
2. **Statistik Peran** - Informasi peran tersedia, total, dan tersisa
3. **Peran yang Ada** - Daftar nama peran yang ada di ekosistem

#### Charts Section:
1. **Distribusi Peran** - Radar chart menampilkan keragaman peran
2. **Progress Keragaman Peran** - Bar chart perbandingan data

#### Progress Bars:
- Progress bar utama untuk keragaman peran
- Progress bar cakupan peran

#### Summary Information:
1. **Ringkasan Keragaman Peran** - Statistik lengkap peran
2. **Insight Keragaman Peran** - Analisis status dan potensi peningkatan

## Rumus Perhitungan

```php
// Kualitas Ekosistem = (Peran yang Ada / Total Peran Database) × 100
$ekosistemScore = ($existingRolesCount / $totalRolesInDatabase) * 100;
```

## Data yang Ditampilkan

### Overview:
- **Kualitas Ekosistem**: Persentase keragaman peran
- **Keragaman Peran**: Persentase yang sama
- **Peran Tersedia**: Format "X/Y" (peran ada / total peran)

### Detail:
- **Peran yang ada**: Jumlah peran unik di ekosistem
- **Total peran database**: Jumlah total peran di sistem
- **Peran tersisa**: Peran yang belum ada di ekosistem
- **Daftar peran**: Nama-nama peran yang ada

### Status Kualitas:
- **≥80%**: Sangat Baik (hijau)
- **≥60%**: Baik (kuning)
- **≥40%**: Cukup (orange)
- **<40%**: Perlu Ditingkatkan (merah)

## Keuntungan

1. **Sederhana**: Rumus yang mudah dipahami
2. **Objektif**: Berdasarkan data peran yang ada vs total
3. **Motivasi**: Mendorong diversifikasi peran di ekosistem
4. **Transparan**: Menampilkan peran mana yang sudah ada dan belum

## Cara Kerja

1. **Ambil peran anggota**: Dari profile.peran anggota yang diterima
2. **Hitung peran unik**: Jumlah peran berbeda yang ada
3. **Hitung total peran**: Jumlah semua peran di database
4. **Hitung persentase**: (peran ada / total peran) × 100
5. **Tampilkan di dashboard**: Dengan visualisasi yang jelas

## Contoh Interpretasi

- **100%**: Ekosistem memiliki semua peran yang tersedia
- **75%**: Ekosistem memiliki 3/4 dari total peran
- **50%**: Ekosistem memiliki setengah dari total peran
- **25%**: Ekosistem memiliki seperempat dari total peran
- **0%**: Ekosistem belum memiliki peran apapun

## Dependencies

- Model `Peran` untuk data peran
- Model `Profile` untuk relasi peran user
- Model `Ecosystem` untuk perhitungan
- Livewire component `Ecosystem\Dashboard` untuk tampilan

## Testing

Untuk menguji:
1. Buat beberapa peran di database
2. Assign peran berbeda ke anggota ekosistem
3. Lihat skor kualitas di dashboard ekosistem
4. Verifikasi perhitungan: (peran ada / total peran) × 100

## Catatan Teknis

- Skor ekosistem sekarang hanya berdasarkan keragaman peran
- Semua metrik lain dihapus dari perhitungan
- Dashboard difokuskan pada informasi peran
- Chart menampilkan data peran yang relevan
