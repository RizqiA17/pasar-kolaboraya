# Implementasi QR Code untuk Bergabung Ekosistem

## Overview
Fitur QR code static untuk bergabung dengan ekosistem memungkinkan pemilik ekosistem untuk membuat QR code yang dapat di-scan oleh user untuk langsung masuk ke form bergabung ekosistem.

## Fitur yang Diimplementasikan

### 1. QR Code Static
- **Tidak memerlukan tabel baru** - menggunakan URL static yang mengarah ke route join
- **QR code tidak expired** - dapat digunakan kapan saja selama ekosistem aktif
- **URL format**: `/ecosystem/qr/join/{ecosystem_id}`

### 2. Controller EcosystemQrController
- `generateQr()` - Generate QR code SVG dan URL
- `showQr()` - Tampilkan halaman QR code untuk pemilik ekosistem
- `handleQrJoin()` - Handle scan QR code dan redirect ke form join
- `getQrData()` - API untuk mendapatkan data QR code

### 3. Livewire Component QrScanner
- Interface untuk scan QR code menggunakan kamera
- Support manual input URL QR code
- Auto-redirect ke form join setelah scan berhasil
- Error handling untuk QR code tidak valid

### 4. Routes
```php
// Protected routes (hanya pemilik ekosistem)
Route::get('ecosystem/{ecosystem}/qr', [EcosystemQrController::class, 'showQr'])->name('ecosystem.qr.show');
Route::get('ecosystem/{ecosystem}/qr/generate', [EcosystemQrController::class, 'generateQr'])->name('ecosystem.qr.generate');
Route::get('ecosystem/{ecosystem}/qr/data', [EcosystemQrController::class, 'getQrData'])->name('ecosystem.qr.data');

// Public route (accessible tanpa login)
Route::get('ecosystem/qr/join/{ecosystem}', [EcosystemQrController::class, 'handleQrJoin'])->name('ecosystem.qr.join');

// QR Scanner route
Route::get('ecosystem/qr-scanner', QrScanner::class)->name('ecosystem.qr.scanner');
```

### 5. Model Methods (Ecosystem)
- `getQrJoinUrl()` - Generate URL untuk join ekosistem
- `getQrCodeSvg($size)` - Generate QR code SVG
- `canGenerateQr($user)` - Check apakah user dapat generate QR

## Cara Penggunaan

### Untuk Pemilik Ekosistem:
1. Masuk ke dashboard ekosistem
2. Klik tombol "QR Code" di header
3. Tampilkan QR code kepada user yang ingin bergabung
4. User dapat scan QR code atau copy URL

### Untuk User yang Ingin Bergabung:
1. Scan QR code menggunakan kamera smartphone
2. Atau akses URL QR code langsung
3. Akan diarahkan ke form bergabung ekosistem
4. Isi form dan tunggu persetujuan pemilik

### Untuk Scan QR Code:
1. Akses halaman "Scan QR Code" dari menu ekosistem
2. Klik "Mulai Scanning" untuk mengaktifkan kamera
3. Arahkan kamera ke QR code ekosistem
4. QR code akan otomatis terdeteksi dan diproses

## Keamanan

### Access Control:
- Hanya pemilik ekosistem yang dapat melihat/generate QR code
- Route join bersifat public untuk memungkinkan akses tanpa login
- Validasi ekosistem aktif sebelum redirect ke form join

### Validation:
- Check apakah ekosistem masih aktif
- Check apakah user sudah menjadi anggota
- Handle error untuk QR code tidak valid

## File yang Dibuat/Dimodifikasi

### Controller:
- `app/Http/Controllers/EcosystemQrController.php` (baru)

### Livewire Components:
- `app/Livewire/Ecosystem/QrScanner.php` (baru)

### Views:
- `resources/views/ecosystem/qr-show.blade.php` (baru)
- `resources/views/livewire/ecosystem/qr-scanner.blade.php` (baru)
- `resources/views/livewire/ecosystem/dashboard.blade.php` (dimodifikasi - tambah tombol QR)
- `resources/views/livewire/ecosystem/browse.blade.php` (dimodifikasi - tambah tombol scan)

### Model:
- `app/Models/Ecosystem.php` (dimodifikasi - tambah method QR)

### Routes:
- `routes/web.php` (dimodifikasi - tambah route QR)

## Dependencies
- `simplesoftwareio/simple-qrcode` - untuk generate QR code
- `jsQR` library - untuk scan QR code di frontend

## Testing
1. Login sebagai pemilik ekosistem
2. Akses dashboard ekosistem
3. Klik tombol "QR Code"
4. Test scan QR code dengan smartphone
5. Test akses URL QR code langsung
6. Test form bergabung setelah scan
7. **Test dark mode** - Pastikan semua elemen terlihat baik di dark mode

## Catatan
- QR code bersifat static dan tidak memerlukan database storage
- URL QR code mengarah langsung ke form join ekosistem
- Fitur ini terintegrasi dengan sistem join ekosistem yang sudah ada
- **Full dark mode support** - Semua elemen UI mendukung dark mode
- Responsive design untuk semua ukuran layar
