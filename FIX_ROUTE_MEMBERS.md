# Fix: Route [collective-action.members] not defined

## Masalah
Error `Route [collective-action.members] not defined` muncul ketika mengakses halaman member management.

## Penyebab
Inkonsistensi naming route:
- Di `routes/web.php`: route name adalah `collective-action.member-management`
- Di view: menggunakan `{{ route('collective-action.members') }}`

## Solusi
Mengubah route name di `routes/web.php` untuk konsistensi dengan penggunaan di view.

### Perubahan di `routes/web.php`:
```php
// Sebelum:
Route::get('collective-actions/{collectiveAction}/members', \App\Livewire\CollectiveAction\MemberManagement::class)->name('collective-action.member-management');

// Sesudah:
Route::get('collective-actions/{collectiveAction}/members', \App\Livewire\CollectiveAction\MemberManagement::class)->name('collective-action.members');
```

### Perubahan di `resources/views/livewire/collective-action/user-approvals.blade.php`:
```php
// Diperbaiki reference yang masih menggunakan nama lama:
{{ route('collective-action.member-management', $collectiveAction) }}
// Menjadi:
{{ route('collective-action.members', $collectiveAction) }}
```

## File yang Diperbaiki:
1. `routes/web.php` - Mengubah route name
2. `resources/views/livewire/collective-action/user-approvals.blade.php` - Memperbaiki reference

## Verifikasi:
```bash
php artisan route:list --name=collective-action.members
# Output: Route ditemukan dengan benar
```

## Status: ✅ Fixed
Route sekarang berfungsi dengan normal dan tidak ada lagi error "Route not defined".
