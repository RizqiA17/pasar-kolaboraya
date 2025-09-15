# Fix: Undefined array key "percentage" Error

## Masalah
Error "Undefined array key 'percentage'" terjadi karena ada referensi ke struktur data lama di header dashboard ekosistem.

## Penyebab
- Dashboard header masih menggunakan `$ecosystemQuality['percentage']` 
- Struktur data baru menggunakan `$ecosystemQuality['ekosistem_score']`

## Solusi
**File**: `resources/views/livewire/ecosystem/dashboard.blade.php`

**Perubahan**:
```php
// Sebelum (Error)
{{ $ecosystemQuality['percentage'] }}%

// Sesudah (Fixed)
{{ $ecosystemQuality['ekosistem_score'] }}%
```

## Verifikasi
- Test dengan `php artisan tinker` menunjukkan method `calculateEkosistemScore()` berfungsi normal
- Struktur data yang dikembalikan sesuai dengan yang diharapkan
- Tidak ada referensi lain ke struktur data lama

## Status
✅ **FIXED** - Error sudah diperbaiki dan dashboard dapat berfungsi normal
