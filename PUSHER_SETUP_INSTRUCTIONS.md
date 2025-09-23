# Setup Pusher untuk Real-time QR Code Redirect

## Konfigurasi yang Diperlukan

### 1. Install Pusher Dependencies
```bash
# Pusher PHP server sudah terinstall
composer show pusher/pusher-php-server

# Untuk development, gunakan Pusher JS dari CDN (sudah ditambahkan di QR code page)
```

### 2. Konfigurasi Environment Variables
Tambahkan ke file `.env`:

```env
# Broadcasting Configuration
BROADCAST_DRIVER=pusher

# Pusher Configuration
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=ap1
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
```

### 3. Daftar di Pusher.com
1. Buka https://pusher.com
2. Buat akun atau login
3. Buat aplikasi baru
4. Pilih cluster terdekat (ap1 untuk Asia Pacific)
5. Copy App ID, Key, dan Secret ke file .env

### 4. Test Konfigurasi
```bash
# Clear config cache
php artisan config:clear

# Test broadcasting
php artisan tinker
>>> broadcast(new App\Events\UserQrScannedSuccessfully(1, 'Test Pasar', 'http://localhost/dashboard'));
```

## Cara Kerja

1. **User** membuka halaman QR code (`/qr-code`)
2. **Pusher JS** connect dan subscribe ke private channel `private-user.{user_id}`
3. **Admin** scan QR code di pasar-kolaboraya-qr-scanner
4. **Event** `UserQrScannedSuccessfully` di-broadcast ke channel user
5. **User browser** menerima event dan redirect ke dashboard

## Troubleshooting

### Jika Pusher tidak connect:
1. Periksa konfigurasi di .env
2. Pastikan Pusher app sudah aktif
3. Check browser console untuk error
4. Pastikan CSRF token valid

### Jika event tidak diterima:
1. Periksa user ID di channel subscription
2. Pastikan event di-broadcast ke channel yang benar
3. Check Pusher dashboard untuk melihat event yang dikirim

## File yang Dimodifikasi

1. `app/Events/UserQrScannedSuccessfully.php` - Event untuk broadcasting
2. `app/Livewire/Admin/PasarKolaborayaQrScanner.php` - Broadcast event setelah scan berhasil
3. `resources/views/qr-code/show.blade.php` - Listen Pusher events dan redirect
4. `routes/web.php` - Route untuk broadcasting auth
