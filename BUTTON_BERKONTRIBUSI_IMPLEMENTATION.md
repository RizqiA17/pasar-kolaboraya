# Implementasi Tombol Berkontribusi untuk User yang Sudah Bergabung

## Deskripsi
Implementasi fitur untuk mengubah tombol "Bergabung" menjadi "Berkontribusi" ketika user sudah bergabung dan diterima oleh pemilik ekosistem atau aksi kolektif. Tombol "Berkontribusi" akan redirect langsung ke tampilan untuk berkontribusi.

## Perubahan yang Dilakukan

### 1. File: `resources/views/livewire/ecosystem/browse.blade.php`

**Lokasi perubahan:** Baris 250-278

**Perubahan:**
- Menambahkan kondisi `@elseif($userStatus === 'accepted')` untuk menampilkan tombol "Berkontribusi" ketika user sudah diterima
- Tombol "Berkontribusi" menggunakan route `ecosystem.contribute` dan redirect ke halaman kontribusi
- Menambahkan icon plus (+) untuk tombol berkontribusi
- Mempertahankan logika existing untuk tombol "Bergabung" dan pesan untuk user komunitas

**Kode yang ditambahkan:**
```blade
@elseif($userStatus === 'accepted')
    <!-- Contribute button for accepted users -->
    <flux:button href="{{ route('ecosystem.contribute', $ecosystem) }}" variant="primary"
        size="sm" class="w-full" wire:navigate>
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Berkontribusi
    </flux:button>
```

### 2. File: `resources/views/livewire/collective-action/browse.blade.php`

**Lokasi perubahan:** Baris 374-401

**Perubahan:**
- Memodifikasi kondisi untuk user yang sudah terdaftar dengan status 'active'
- Mengganti tombol "Lihat Detail" saja menjadi kombinasi tombol "Berkontribusi" dan "Lihat Detail"
- Tombol "Berkontribusi" menggunakan route `collective-action.contribute` dan redirect ke halaman kontribusi
- Menambahkan icon plus (+) untuk tombol berkontribusi
- Mempertahankan layout flex dengan space-x-2 untuk kedua tombol

**Kode yang dimodifikasi:**
```blade
@if ($userStatus === 'active')
    <!-- Contribute button for active users -->
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
```

## Logika Implementasi

### Untuk Ekosistem:
1. **User belum bergabung:** Menampilkan tombol "Bergabung" (jika user dapat bergabung)
2. **User sudah bergabung dan diterima:** Menampilkan tombol "Berkontribusi" yang redirect ke `ecosystem.contribute`
3. **User komunitas:** Menampilkan pesan "Hanya dapat terhubung dengan pengguna lain"
4. **Ekosistem penuh:** Menampilkan pesan "Ekosistem Penuh"

### Untuk Aksi Kolektif:
1. **User belum terdaftar:** Menampilkan tombol "Bergabung" dan "Lihat Detail"
2. **User sudah terdaftar dengan status 'active':** Menampilkan tombol "Berkontribusi" dan "Lihat Detail"
3. **User sudah terdaftar dengan status lain:** Menampilkan tombol "Lihat Detail" saja
4. **User sudah berkontribusi:** Menampilkan status kontribusi (Diterima, Menunggu, Selesai, Ditolak)

## Routes yang Digunakan

- `ecosystem.contribute` - Halaman kontribusi ekosistem
- `collective-action.contribute` - Halaman kontribusi aksi kolektif

## Status User yang Diperiksa

### Ekosistem:
- `$userStatus === 'accepted'` - User sudah diterima di ekosistem

### Aksi Kolektif:
- `$userStatus === 'active'` - User sudah aktif di aksi kolektif

## Styling

- Tombol "Berkontribusi" menggunakan variant="primary" dengan styling yang konsisten
- Icon plus (+) ditambahkan untuk memberikan visual cue yang jelas
- Layout responsive dengan flex untuk aksi kolektif (dua tombol berdampingan)
- Warna dan styling mengikuti design system yang ada

## Testing

Untuk menguji implementasi ini:

1. **Login sebagai user yang dapat bergabung** (tamu/partisipan)
2. **Bergabung dengan ekosistem/aksi kolektif**
3. **Tunggu persetujuan dari pemilik**
4. **Setelah diterima, periksa apakah tombol berubah menjadi "Berkontribusi"**
5. **Klik tombol "Berkontribusi" dan pastikan redirect ke halaman kontribusi yang benar**

## Catatan

- Implementasi ini mempertahankan semua logika existing untuk berbagai status user
- Tidak ada perubahan pada backend logic, hanya frontend display
- Routes untuk kontribusi sudah ada dan berfungsi
- Styling konsisten dengan design system yang ada
