# Implementasi Tombol Kontribusi dengan Method canUserContribute

## Deskripsi
Memperbarui implementasi tombol kontribusi untuk menggunakan method `canUserContribute()` yang sudah ada di model, mengikuti logika yang sama dengan dashboard ekosistem dan aksi kolektif.

## Perubahan yang Dilakukan

### 1. File: `resources/views/livewire/ecosystem/browse.blade.php`

**Lokasi perubahan:** Baris 263

**Perubahan:**
- Mengganti kondisi `@elseif($userStatus === 'accepted')` menjadi `@elseif($ecosystem->canUserContribute(Auth::user()))`
- Menggunakan method `canUserContribute()` yang sudah ada di model Ecosystem

**Kode yang diubah:**
```blade
@elseif($ecosystem->canUserContribute(Auth::user()))
    <!-- Contribute button for users who can contribute -->
    <flux:button href="{{ route('ecosystem.contribute', $ecosystem) }}" variant="primary"
        size="sm" class="w-full" wire:navigate>
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Berkontribusi
    </flux:button>
```

### 2. File: `resources/views/livewire/collective-action/browse.blade.php`

**Lokasi perubahan:** Baris 375

**Perubahan:**
- Mengganti kondisi `@if ($userStatus === 'active')` menjadi `@if ($action->canUserContribute(Auth::user()))`
- Menggunakan method `canUserContribute()` yang sudah ada di model CollectiveAction

**Kode yang diubah:**
```blade
@if ($action->canUserContribute(Auth::user()))
    <!-- Contribute button for users who can contribute -->
    <div class="flex space-x-2">
        <flux:button href="{{ route('collective-action.contribute', $action) }}"
            variant="primary" wire:navigate size="sm"
            class="flex-1 bg-primary-blue hover:bg-primary-blue/90 dark:bg-secondary-green dark:hover:bg-secondary-green/90 border border-primary-blue hover:border-primary-blue/80 dark:border-secondary-green dark:hover:border-secondary-green/80 shadow-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Berkontribusi
        </flux:button>
        <flux:button href="{{ route('collective-action.show', $action) }}"
            variant="outline" size="sm" class="flex-1">
            Lihat Detail
        </flux:button>
    </div>
@else
    <!-- Simple buttons for users who cannot contribute -->
    <div class="flex space-x-2">
        <flux:button href="{{ route('collective-action.show', $action) }}"
            variant="outline" size="sm" class="flex-1">
            Lihat Detail
        </flux:button>
    </div>
@endif
```

## Logika Method canUserContribute

### Ecosystem Model
```php
public function canUserContribute(User $user): bool
{
    if (!$this->is_active) {
        return false;
    }

    // Creator can always contribute
    if ($user->id === $this->creator_id) {
        // Check if creator is already a contributor
        if ($this->contributors()->where('users.id', $user->id)->exists()) {
            return false;
        }
        return true;
    }

    // Only accepted users can contribute
    $userStatus = $this->getUserStatus($user);
    if ($userStatus !== 'accepted') {
        return false;
    }

    // Check if user is already a contributor
    if ($this->contributors()->where('users.id', $user->id)->exists()) {
        return false;
    }

    return true;
}
```

### CollectiveAction Model
```php
public function canUserContribute(User $user): bool
{
    if ($this->status !== 'active' && $this->status !== 'planning') {
        return false;
    }

    // Only joined users (members, contributors, admins) can contribute
    if (!$this->isUserMember($user) && !$this->isUserAdmin($user) && !$this->isUserContributor($user)) {
        return false;
    }

    // Check if user has any pending or accepted contributions
    if (
        $this->contributions()->where('user_id', $user->id)
            ->whereIn('status', ['offered', 'accepted'])
            ->exists()
    ) {
        return false;
    }

    return true;
}
```

## Kondisi yang Diperiksa

### Untuk Ekosistem:
1. **Ekosistem aktif** (`is_active = true`)
2. **User adalah creator** - dapat berkontribusi kecuali sudah berkontribusi
3. **User status 'accepted'** - dapat berkontribusi kecuali sudah berkontribusi
4. **User belum berkontribusi** - tidak ada kontribusi yang sedang pending/accepted

### Untuk Aksi Kolektif:
1. **Status aktif** (`status = 'active'` atau `'planning'`)
2. **User sudah bergabung** (member, admin, atau contributor)
3. **User belum berkontribusi** - tidak ada kontribusi yang sedang pending/accepted

## Keuntungan Menggunakan canUserContribute

1. **Konsistensi**: Menggunakan logika yang sama dengan dashboard
2. **Akurasi**: Memeriksa semua kondisi yang diperlukan untuk kontribusi
3. **Maintainability**: Perubahan logika hanya perlu dilakukan di model
4. **Reusability**: Method dapat digunakan di berbagai tempat

## Testing Scenarios

### Ekosistem:
- [ ] User creator yang belum berkontribusi → Tombol "Berkontribusi"
- [ ] User creator yang sudah berkontribusi → Tidak ada tombol
- [ ] User accepted yang belum berkontribusi → Tombol "Berkontribusi"
- [ ] User accepted yang sudah berkontribusi → Tidak ada tombol
- [ ] User pending → Tidak ada tombol
- [ ] User rejected → Tidak ada tombol
- [ ] Ekosistem tidak aktif → Tidak ada tombol

### Aksi Kolektif:
- [ ] User member yang belum berkontribusi → Tombol "Berkontribusi"
- [ ] User member yang sudah berkontribusi → Tidak ada tombol
- [ ] User admin yang belum berkontribusi → Tombol "Berkontribusi"
- [ ] User admin yang sudah berkontribusi → Tidak ada tombol
- [ ] User pending → Tidak ada tombol
- [ ] User rejected → Tidak ada tombol
- [ ] Aksi tidak aktif → Tidak ada tombol

## Files Modified
1. `resources/views/livewire/ecosystem/browse.blade.php` - Baris 263
2. `resources/views/livewire/collective-action/browse.blade.php` - Baris 375

## Status
✅ **SELESAI** - Implementasi menggunakan method `canUserContribute()` yang sudah ada dan teruji di dashboard.
