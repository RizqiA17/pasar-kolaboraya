# QR Code System Implementation

## Overview
Sistem QR code telah berhasil diimplementasikan untuk mengubah cara masuk ke Pasar Kolaboraya. User yang sudah memiliki akun akan mendapatkan QR code yang dapat di-scan oleh admin untuk memberikan akses.

## Fitur yang Diimplementasikan

### 1. QR Code Generation untuk User
- **Field Database**: Ditambahkan `qr_code` dan `qr_code_generated_at` ke tabel `users`
- **Auto Generation**: QR code otomatis dibuat saat user pertama kali mengakses halaman QR code
- **Format QR Code**: `PK_{user_id}_{timestamp}_{random_string}`
- **Expiration**: QR code berlaku selama 30 hari
- **Regeneration**: User dapat membuat QR code baru kapan saja

### 2. Halaman QR Code User
- **URL**: `/qr-code`
- **Fitur**:
  - Menampilkan QR code dalam format visual
  - Informasi user dan status QR code
  - Download QR code sebagai file text
  - Print QR code
  - Regenerate QR code baru
  - Instruksi penggunaan
  - Peringatan keamanan

### 3. Admin QR Scanner
- **URL**: `/admin/qr-scanner`
- **Fitur**:
  - Manual input QR code
  - Camera scanner (menggunakan qr-scanner.js)
  - Validasi QR code real-time
  - Informasi user yang ter-scan
  - **Pemilihan Pasar Kolaboraya** - Admin memilih pasar mana yang akan dimasuki user
  - Grant access ke Pasar Kolaboraya yang dipilih
  - Riwayat scan (20 scan terakhir) dengan info Pasar Kolaboraya
  - Clear form dan reset

### 4. API Endpoints
- `POST /qr-code/generate` - Generate QR code untuk user
- `POST /qr-code/validate` - Validasi QR code
- `POST /qr-code/grant-access` - Berikan akses ke Pasar Kolaboraya yang dipilih

## Struktur Database

### Migration: add_qr_code_to_users_table
```sql
ALTER TABLE users ADD COLUMN qr_code VARCHAR(255) UNIQUE NULL;
ALTER TABLE users ADD COLUMN qr_code_generated_at TIMESTAMP NULL;
```

### Model User - Method Baru
```php
// Generate QR code baru
public function generateQrCode(): string

// Get data QR code untuk display
public function getQrCodeData(): array

// Check apakah QR code masih valid
public function isQrCodeValid(): bool
```

## Cara Penggunaan

### Untuk User:
1. Login ke sistem
2. Buka dashboard dan klik "Lihat QR Code" di card QR Code
3. Tunjukkan QR code kepada admin Pasar Kolaboraya
4. Admin akan scan QR code dan memberikan akses

### Untuk Admin:
1. Login sebagai super admin
2. Buka admin dashboard dan klik "Buka Scanner" di card QR Scanner
3. Scan QR code user menggunakan kamera atau input manual
4. Validasi QR code
5. **Pilih Pasar Kolaboraya** yang akan dimasuki user dari dropdown
6. Klik "Berikan Akses ke Pasar Kolaboraya" jika valid

## Fitur Pemilihan Pasar Kolaboraya

### Admin Scanner Enhancement:
- **Dropdown Pasar Kolaboraya**: Menampilkan semua Pasar Kolaboraya yang aktif
- **Informasi Pasar**: Setiap opsi menampilkan nama dan jumlah peserta
- **Preview Pasar**: Admin dapat melihat detail pasar yang dipilih
- **Validasi**: Memastikan user belum menjadi anggota pasar yang sama
- **Assignment**: User otomatis ditambahkan ke Pasar Kolaboraya yang dipilih
- **Active Session**: User langsung masuk ke Pasar Kolaboraya yang dipilih

### Workflow Lengkap:
1. **Scan QR Code** → Validasi user
2. **Pilih Pasar Kolaboraya** → Admin memilih dari dropdown
3. **Preview Pasar** → Lihat detail pasar yang dipilih
4. **Grant Access** → User ditambahkan ke pasar dan dijadikan active session
5. **Logging** → Semua aktivitas dicatat dengan info pasar yang dipilih

## Security Features

### QR Code Security:
- Format unik dengan user ID dan timestamp
- Random string untuk mencegah guessing
- Expiration 30 hari
- Logging semua akses yang diberikan

### Access Control:
- Hanya super admin yang bisa akses QR scanner
- Validasi QR code sebelum memberikan akses
- Logging semua aktivitas scan

## Technical Implementation

### Dependencies:
- `simplesoftwareio/simple-qrcode` - QR code generation
- `qr-scanner` (CDN) - Camera scanning

### Files Created/Modified:
- `app/Http/Controllers/QrCodeController.php` - API endpoints
- `app/Livewire/Admin/QrScanner.php` - Admin scanner component
- `app/Models/User.php` - QR code methods
- `resources/views/qr-code/show.blade.php` - User QR page
- `resources/views/livewire/admin/qr-scanner.blade.php` - Admin scanner
- `resources/views/dashboard.blade.php` - Added QR card
- `resources/views/admin/dashboard.blade.php` - Added scanner card
- `database/migrations/2025_09_17_094526_add_qr_code_to_users_table.php`
- `database/seeders/QrCodeSeeder.php`

### Routes Added:
```php
// QR Code Routes
Route::middleware(['auth', 'check.login.status', VerifiedEmail::class])->group(function () {
    Route::get('qr-code', [QrCodeController::class, 'show'])->name('qr.show');
    Route::post('qr-code/generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('qr-code/validate', [QrCodeController::class, 'validate'])->name('qr.validate');
    Route::post('qr-code/grant-access', [QrCodeController::class, 'grantAccess'])->name('qr.grant-access');
});

// Admin QR Scanner
Route::get('/admin/qr-scanner', \App\Livewire\Admin\QrScanner::class)->name('admin.qr-scanner');
```

## Testing

### Manual Testing Steps:
1. **User QR Code Generation**:
   - Login sebagai user
   - Buka `/qr-code`
   - Verify QR code ditampilkan
   - Test regenerate functionality

2. **Admin QR Scanner**:
   - Login sebagai super admin
   - Buka `/admin/qr-scanner`
   - Test manual input QR code
   - Test camera scanning (jika tersedia)
   - Verify validation dan grant access

3. **End-to-End Flow**:
   - User generate QR code
   - Admin scan QR code
   - Verify access granted

## Future Enhancements

### Potential Improvements:
1. **QR Code Visual**: Implementasi QR code visual yang lebih baik
2. **Mobile App**: Scanner mobile app untuk admin
3. **Batch Processing**: Scan multiple QR codes sekaligus
4. **Analytics**: Dashboard analytics untuk QR code usage
5. **Notifications**: Real-time notifications untuk user saat akses diberikan
6. **QR Code History**: Riwayat lengkap QR code per user

## Troubleshooting

### Common Issues:
1. **Camera Access**: Pastikan browser mengizinkan akses kamera
2. **QR Code Expired**: User perlu regenerate QR code
3. **Invalid QR Code**: Pastikan format QR code sesuai dengan yang diharapkan
4. **Permission Denied**: Pastikan user memiliki role yang tepat

### Debug Commands:
```bash
# Check QR codes in database
php artisan tinker
>>> User::whereNotNull('qr_code')->count()

# Generate QR codes for existing users
php artisan db:seed --class=QrCodeSeeder

# Check specific user QR code
>>> User::find(1)->getQrCodeData()
```

## Conclusion

Sistem QR code telah berhasil diimplementasikan dengan fitur lengkap untuk:
- User dapat generate dan menampilkan QR code
- Admin dapat scan dan validasi QR code
- Akses ke Pasar Kolaboraya diberikan setelah validasi
- Security dan logging yang memadai
- UI/UX yang user-friendly

Sistem ini mengubah cara masuk ke Pasar Kolaboraya menjadi lebih aman dan terkontrol, dengan admin yang memiliki kontrol penuh atas akses user.
