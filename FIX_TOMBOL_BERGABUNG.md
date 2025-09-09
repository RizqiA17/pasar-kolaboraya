# Fix: Tombol Bergabung di Halaman Aksi Kolektif

## Masalah
User tidak melihat tombol "Bergabung" di halaman browse aksi kolektif (`/collective-actions`).

## Penyebab
Tombol bergabung hanya tersedia di halaman detail aksi kolektif (`/collective-actions/{id}`), tidak di halaman listing/browse.

## Solusi
Ditambahkan logika untuk menampilkan tombol bergabung di halaman browse collective action dengan status yang sesuai.

## Perubahan di `resources/views/livewire/collective-action/browse.blade.php`

### Logika Baru:
```php
@php
    $user = Auth::user();
    $canJoin = $user ? $action->canUserJoin($user) : false;
    $isUserMember = $user ? ($action->isUserMember($user) || $action->isUserAdmin($user) || $action->isUserContributor($user)) : false;
    $userStatus = null; // active, pending_approval, rejected
@endphp
```

### UI Berdasarkan Status:

1. **Jika user sudah bergabung (`$isUserMember = true`)**:
   - Status `active` → Badge hijau "Sudah Bergabung"
   - Status `pending_approval` → Badge kuning "Menunggu Persetujuan" 
   - Status `rejected` → Badge merah "Ditolak"

2. **Jika user bisa bergabung (`$canJoin = true`)**:
   - Tombol "Bergabung" (primary) + Tombol "Lihat Detail" (outline)
   - Dua tombol side-by-side untuk kemudahan akses

3. **Jika user sudah berkontribusi**:
   - Badge status kontribusi (diterima/menunggu/selesai/ditolak)

4. **Default**:
   - Tombol "Lihat Detail" saja

## Hasil
- ✅ User sekarang bisa melihat tombol "Bergabung" di halaman listing
- ✅ Status keanggotaan ditampilkan dengan jelas
- ✅ UX lebih baik dengan akses langsung ke form bergabung
- ✅ Tetap ada opsi "Lihat Detail" untuk informasi lengkap

## Testing
Tested dengan:
- User yang belum bergabung → Tombol "Bergabung" muncul
- User yang sudah bergabung → Badge status sesuai
- User yang belum login → Tombol "Lihat Detail" saja

## Screenshot Expected
Di halaman `/collective-actions`, setiap card aksi kolektif sekarang akan menampilkan:
- Tombol biru "Bergabung" untuk user yang bisa bergabung
- Badge status untuk user yang sudah terdaftar
- Kombinasi tombol untuk fleksibilitas navigasi
