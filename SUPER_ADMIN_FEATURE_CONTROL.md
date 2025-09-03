# Super Admin Feature Control System

## Overview
Sistem kontrol fitur super admin memungkinkan administrator untuk menonaktifkan fitur-fitur tertentu seperti koneksi, kolaborasi, dan aksi pengguna, sambil tetap mempertahankan akses penuh untuk super admin.

## Fitur yang Dapat Dikontrol

### 1. Koneksi Antar Pengguna
- **Pengaturan**: `connections_enabled`
- **Fungsi**: Mengontrol apakah pengguna dapat membuat dan mengelola koneksi dengan pengguna lain
- **Dampak**: 
  - Menonaktifkan akses ke halaman koneksi
  - Mencegah pembuatan koneksi baru
  - Mencegah penerimaan/penolakan koneksi

### 2. Kolaborasi
- **Pengaturan**: `collaborations_enabled`
- **Fungsi**: Mengontrol apakah pengguna dapat membuat dan mengelola kolaborasi
- **Dampak**:
  - Menonaktifkan akses ke halaman kolaborasi
  - Mencegah pembuatan kolaborasi baru
  - Mencegah pengelolaan kolaborasi yang ada

### 3. Aksi Pengguna
- **Pengaturan**: `user_actions_enabled`
- **Fungsi**: Mengontrol apakah pengguna dapat melakukan aksi seperti bergabung dengan event
- **Dampak**:
  - Menonaktifkan akses ke halaman event
  - Mencegah pembuatan event baru
  - Mencegah bergabung dengan event

## Cara Menggunakan

### 1. Akses Pengaturan Sistem
1. Login sebagai super admin
2. Buka halaman admin: `/admin`
3. Pilih "System Settings"

### 2. Mengatur Fitur
1. Toggle switch untuk mengaktifkan/menonaktifkan fitur yang diinginkan
2. Klik "Simpan Pengaturan"
3. Perubahan akan berlaku segera

### 3. Status Saat Ini
Halaman pengaturan menampilkan status real-time dari semua fitur:
- ✅ Hijau: Fitur diaktifkan
- ❌ Merah: Fitur dinonaktifkan

## Implementasi Teknis

### 1. Model SystemSetting
```php
// Method baru yang ditambahkan:
SystemSetting::isConnectionsEnabled()
SystemSetting::isCollaborationsEnabled()
SystemSetting::isUserActionsEnabled()
```

### 2. Middleware CheckFeatureAccess
Middleware yang memeriksa akses fitur berdasarkan pengaturan sistem:
```php
Route::middleware('check.feature.access:connections')->group(function () {
    // Routes untuk koneksi
});
```

### 3. Livewire Components
Components yang telah diupdate untuk memeriksa akses fitur:
- `app/Livewire/Connections/Suggestion.php`
- `app/Livewire/Profile/ProfileCard.php`

## Keamanan

### 1. Super Admin Bypass
Super admin selalu dapat mengakses semua fitur, terlepas dari pengaturan sistem.

### 2. Middleware Protection
Semua route yang terkait dengan fitur yang dapat dikontrol dilindungi oleh middleware.

### 3. Component Level Protection
Livewire components juga memeriksa akses fitur sebelum menjalankan aksi.

## Database

### Tabel system_settings
Pengaturan baru yang ditambahkan:
- `connections_enabled`: '1' atau '0'
- `collaborations_enabled`: '1' atau '0'
- `user_actions_enabled`: '1' atau '0'

### Seeder
Gunakan `FeatureSettingsSeeder` untuk menginisialisasi pengaturan default:
```bash
php artisan db:seed --class=FeatureSettingsSeeder
```

## Pesan Error

Ketika fitur dinonaktifkan, pengguna akan melihat pesan:
- "Fitur koneksi sedang dinonaktifkan oleh administrator."
- "Fitur kolaborasi sedang dinonaktifkan oleh administrator."
- "Aksi pengguna sedang dinonaktifkan oleh administrator."

## Catatan Penting

1. **Perubahan Real-time**: Perubahan pengaturan berlaku segera tanpa perlu restart aplikasi
2. **Super Admin Access**: Super admin tidak terpengaruh oleh pengaturan ini
3. **Backward Compatibility**: Fitur ini tidak mempengaruhi data yang sudah ada
4. **Logging**: Semua perubahan pengaturan dapat dilacak melalui log sistem

## Troubleshooting

### Jika fitur tidak berfungsi setelah diaktifkan:
1. Periksa cache aplikasi: `php artisan cache:clear`
2. Periksa konfigurasi middleware di `bootstrap/app.php`
3. Pastikan seeder telah dijalankan

### Jika super admin tidak bisa mengakses fitur:
1. Pastikan user memiliki role `super_admin`
2. Periksa method `isSuperAdmin()` di model User
3. Periksa middleware `SuperAdminMiddleware`
