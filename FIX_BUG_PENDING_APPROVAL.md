# Fix: Bug Tombol Bergabung Masih Muncul saat Menunggu Persetujuan

## Masalah
User yang sudah mengajukan bergabung ke aksi kolektif dan statusnya `pending_approval` masih melihat tombol "Bergabung" di halaman browse, padahal seharusnya menampilkan badge "Menunggu Persetujuan".

## Penyebab
Logika di view hanya mengecek user dengan status `active` melalui method:
- `isUserMember()` - hanya user dengan status `active`
- `isUserAdmin()` - hanya user dengan status `active` 
- `isUserContributor()` - hanya user dengan status `active`

User dengan status `pending_approval` tidak terdeteksi, sehingga dianggap belum bergabung.

## Solusi

### 1. Menambahkan Method Baru di Model CollectiveAction

```php
/**
 * Check if user is registered in this collective action (any status)
 */
public function isUserRegistered(User $user): bool
{
    return $this->users()->where('users.id', $user->id)->exists();
}

/**
 * Get user status in this collective action
 */
public function getUserStatus(User $user): ?string
{
    $pivotData = $this->users()->where('users.id', $user->id)->first();
    return $pivotData ? $pivotData->pivot->status : null;
}
```

### 2. Memperbarui Method canUserJoin()

```php
public function canUserJoin(User $user): bool
{
    // Check if user is already registered (any status)
    if ($this->isUserRegistered($user)) {
        return false;
    }

    // Check if action is open for joining
    return in_array($this->status, ['planning', 'active']);
}
```

### 3. Memperbarui Logic di View

```php
@php
    $isUserRegistered = $user ? $action->isUserRegistered($user) : false;
    $userStatus = $user && $isUserRegistered ? $action->getUserStatus($user) : null;
@endphp

@if($isUserRegistered)
    @if($userStatus === 'active')
        <span>✅ Sudah Bergabung</span>
    @elseif($userStatus === 'pending_approval')
        <span>⏳ Menunggu Persetujuan</span>
    @elseif($userStatus === 'rejected')
        <span>❌ Ditolak</span>
    @elseif($userStatus === 'inactive')
        <span>⚪ Tidak Aktif</span>
    @endif
@elseif($canJoin)
    <button>Bergabung</button>
@endif
```

## File yang Diubah

1. **`app/Models/CollectiveAction.php`**
   - Menambahkan `isUserRegistered()`
   - Menambahkan `getUserStatus()`
   - Memperbarui `canUserJoin()`

2. **`resources/views/livewire/collective-action/browse.blade.php`**
   - Menggunakan `isUserRegistered` bukan `isUserMember`
   - Menggunakan `getUserStatus` untuk mendapatkan status yang tepat
   - Menambahkan handling untuk status `inactive`

## Testing

```bash
# Test user dengan status pending_approval
$ca->users()->attach($user->id, [
    'status' => 'pending_approval'
]);

echo $ca->isUserRegistered($user); // true
echo $ca->canUserJoin($user);      // false  
echo $ca->getUserStatus($user);    // pending_approval
```

## Hasil

- ✅ User dengan status `pending_approval` → Badge "Menunggu Persetujuan"
- ✅ User dengan status `active` → Badge "Sudah Bergabung"
- ✅ User dengan status `rejected` → Badge "Ditolak"
- ✅ User dengan status `inactive` → Badge "Tidak Aktif"
- ✅ User yang belum bergabung → Tombol "Bergabung"

## Status: ✅ Fixed

Bug sudah diperbaiki. User tidak akan melihat tombol "Bergabung" lagi jika sudah terdaftar dengan status apapun.

