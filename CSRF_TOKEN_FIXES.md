# CSRF Token Fixes - Mengatasi Bug "Page Expired"

## Overview
Dokumen ini menjelaskan perbaikan yang telah diimplementasikan untuk mengatasi bug "page expired" yang muncul setelah login pada dashboard.

## Masalah yang Ditemukan

### 1. CSRF Token Expired
- **Gejala**: Muncul popup "page expired" setelah login
- **Penyebab**: 
  - CSRF token yang terlalu cepat expired
  - Session lifetime yang terlalu pendek
  - Livewire polling yang tidak optimal
  - Middleware yang tidak menangani token refresh dengan baik

### 2. Session Management Issues
- **Gejala**: Session expired terlalu cepat
- **Penyebab**:
  - Session lifetime default hanya 2 jam
  - Tidak ada mekanisme untuk extend session secara otomatis
  - Middleware yang tidak optimal

## Solusi yang Diimplementasikan

### 1. Middleware Improvements

#### a. RefreshCsrfToken Middleware
- **File**: `app/Http/Middleware/RefreshCsrfToken.php`
- **Fungsi**: Refresh CSRF token setiap 30 menit
- **Perbaikan**: 
  - Mengurangi interval refresh dari 1 jam ke 30 menit
  - Error handling yang lebih robust
  - Logging untuk debugging

#### b. SessionRefresh Middleware
- **File**: `app/Http/Middleware/SessionRefresh.php`
- **Fungsi**: Extend session lifetime dan refresh token
- **Perbaikan**:
  - Update last activity setiap request
  - Refresh token jika diperlukan
  - Session extension otomatis

#### c. CsrfTokenManager Middleware
- **File**: `app/Http/Middleware/CsrfTokenManager.php`
- **Fungsi**: Manajemen CSRF token yang lebih advanced
- **Perbaikan**:
  - Token refresh setiap 20 menit
  - Logging yang detail
  - Error handling yang komprehensif

### 2. Configuration Improvements

#### a. Session Configuration
- **File**: `config/session.php`
- **Perbaikan**: 
  - Session lifetime dinaikkan dari 2 jam ke 8 jam
  - Mengurangi kemungkinan session expired

#### b. Livewire Configuration
- **File**: `config/livewire.php`
- **Perbaikan**:
  - CSRF token refresh otomatis
  - Session extension otomatis
  - Component auto-discovery

### 3. Service Provider

#### a. SessionServiceProvider
- **File**: `app/Providers/SessionServiceProvider.php`
- **Fungsi**: 
  - Listen untuk session events
  - Extend session untuk authenticated users
  - CSRF token management

### 4. Client-Side Improvements

#### a. JavaScript CSRF Token Manager
- **File**: `resources/js/csrf-token-manager.js`
- **Fungsi**:
  - Auto-refresh token setiap 15 menit
  - Token refresh sebelum form submission
  - Activity-based token refresh

### 5. Route Improvements

#### a. CSRF Token Refresh Route
- **File**: `routes/web.php`
- **Route**: `POST /csrf-token-refresh`
- **Fungsi**: Endpoint untuk refresh token via AJAX

## Cara Kerja Perbaikan

### 1. Token Refresh Flow
```
User Activity → Middleware Check → Token Age Check → Refresh if Needed → Update Session
```

### 2. Session Extension Flow
```
Request → Check Last Activity → Extend if Needed → Update Timestamps → Continue
```

### 3. Client-Side Token Management
```
Page Load → Initialize Manager → Start Timer → Auto Refresh → Update DOM
```

## Testing

### 1. Manual Testing
1. **Login Flow**:
   - Login ke aplikasi
   - Tunggu beberapa menit
   - Verifikasi tidak ada "page expired"

2. **Dashboard Usage**:
   - Akses dashboard
   - Tunggu 30+ menit
   - Verifikasi masih bisa akses

3. **Form Submission**:
   - Submit form setelah lama idle
   - Verifikasi tidak ada CSRF error

### 2. Automated Testing
```bash
# Test CSRF token refresh
php artisan test --filter=CsrfTokenTest

# Test session management
php artisan test --filter=SessionTest
```

## Monitoring dan Logging

### 1. CSRF Token Events
- Token refresh
- Token expiration
- Error handling

### 2. Session Events
- Session extension
- Last activity updates
- Session validation

### 3. Error Logging
- Failed token refresh
- Session errors
- Middleware failures

## Performance Considerations

### 1. Token Refresh Frequency
- **Server-side**: Setiap 20-30 menit
- **Client-side**: Setiap 15 menit
- **Activity-based**: Setelah 30 detik idle

### 2. Session Management
- **Lifetime**: 8 jam (480 menit)
- **Extension**: Otomatis setiap request
- **Cleanup**: Otomatis oleh Laravel

## Security Features

### 1. CSRF Protection
- Token validation tetap aktif
- Secure token generation
- Token rotation

### 2. Session Security
- Secure cookie settings
- HTTP-only cookies
- Same-site protection

## Troubleshooting

### 1. Common Issues
- **Token masih expired**: Check middleware order
- **Session tidak extend**: Check SessionServiceProvider
- **Client-side error**: Check JavaScript console

### 2. Debug Commands
```bash
# Check session status
php artisan session:table

# Clear session cache
php artisan session:clear

# Check middleware status
php artisan route:list --middleware
```

## Maintenance

### 1. Regular Checks
- Monitor log files untuk error
- Check session table size
- Verify middleware performance

### 2. Updates
- Update middleware jika diperlukan
- Adjust token refresh intervals
- Monitor security advisories

## Conclusion

Dengan implementasi perbaikan ini, bug "page expired" seharusnya sudah teratasi. Sistem sekarang memiliki:

1. **CSRF token management** yang robust
2. **Session extension** otomatis
3. **Client-side token refresh** yang proaktif
4. **Error handling** yang komprehensif
5. **Logging dan monitoring** yang detail

Jika masih ada masalah, periksa log files dan pastikan semua middleware terdaftar dengan benar.
