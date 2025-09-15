# Market Session Button Disable Feature

## Overview
Implementasi fitur untuk menonaktifkan tombol navigasi (Koneksi, Ekosistem, dan Aksi Kolektif) ketika user tidak memiliki sesi pasar aktif, mirip dengan ketika fitur dinonaktifkan oleh admin.

## Fitur yang Diimplementasikan

### 1. Desktop Navigation Bar
- **Lokasi**: `resources/views/components/layouts/app/header.blade.php` (baris 48-203)
- **Fitur**:
  - Menampilkan tombol normal jika user memiliki sesi pasar aktif dan fitur diaktifkan
  - Menampilkan tombol disabled dengan styling berbeda jika user tidak memiliki sesi pasar aktif
  - Tooltip informatif yang berbeda untuk setiap kondisi (tidak ada sesi pasar vs fitur dinonaktifkan admin)
  - Super admin dan ecosystem builder bypass - selalu menampilkan tombol normal

### 2. Mobile Navigation Bar
- **Lokasi**: `resources/views/components/layouts/app/header.blade.php` (baris 520-708)
- **Fitur**:
  - Responsive design untuk mobile
  - Tombol disabled dengan opacity dan cursor not-allowed
  - Tooltip yang disesuaikan untuk ukuran mobile
  - Konsistensi dengan desktop navigation

## Implementasi Teknis

### 1. PHP Logic
```php
@php
    $user = auth()->user();
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $ecosystemsEnabled = \App\Models\SystemSetting::isEcosystemsEnabled($user);
    $userActionsEnabled = \App\Models\SystemSetting::isUserActionsEnabled();
    $collectiveActionsEnabled = \App\Models\SystemSetting::isCollectiveActionsEnabled();
    $isSuperAdmin = $user->isSuperAdmin();
    $isEcosystemBuilder = $user->isEcosystemBuilder();
    $hasActiveMarketSession = $user->hasActivePasarKolaboraya();
@endphp
```

### 2. Conditional Rendering untuk Desktop
```blade
@if (($connectionsEnabled && $hasActiveMarketSession) || $isSuperAdmin)
    <!-- Normal menu item -->
    <flux:navbar.item icon="link" :href="route('connections')" ...>
@else
    <!-- Disabled menu item with tooltip -->
    <div class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
         x-data="{ tooltip: false }"
         @mouseenter="tooltip = true"
         @mouseleave="tooltip = false">
        <!-- Tooltip content -->
    </div>
@endif
```

### 3. Conditional Rendering untuk Mobile
```blade
@if (($connectionsEnabled && $hasActiveMarketSession) || $isSuperAdmin)
    <!-- Normal mobile button -->
    <a href="{{ route('connections') }}" class="flex flex-col items-center justify-center size-20...">
@else
    <!-- Disabled mobile button with tooltip -->
    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
         x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
        <!-- Tooltip content -->
    </div>
@endif
```

### 4. Dynamic Tooltip Messages
```blade
<span>
    @if (!$hasActiveMarketSession)
        Anda harus bergabung dengan sesi pasar terlebih dahulu
    @else
        Fitur [nama_fitur] sedang dinonaktifkan oleh administrator
    @endif
</span>
```

## Tombol yang Dimodifikasi

### 1. Koneksi
- **Kondisi**: `($connectionsEnabled && $hasActiveMarketSession) || $isSuperAdmin`
- **Pesan tooltip**: 
  - Tidak ada sesi pasar: "Anda harus bergabung dengan sesi pasar terlebih dahulu"
  - Fitur dinonaktifkan: "Fitur koneksi sedang dinonaktifkan oleh administrator"

### 2. Ekosistem
- **Kondisi**: `($ecosystemsEnabled && $hasActiveMarketSession) || $isSuperAdmin || $isEcosystemBuilder`
- **Pesan tooltip**:
  - Tidak ada sesi pasar: "Anda harus bergabung dengan sesi pasar terlebih dahulu"
  - Fitur dinonaktifkan: "Fitur ekosistem dinonaktifkan untuk user biasa. Hanya ecosystem builder yang dapat mengakses."

### 3. Aksi Kolektif
- **Kondisi**: `($collectiveActionsEnabled && $hasActiveMarketSession) || $isSuperAdmin`
- **Pesan tooltip**:
  - Tidak ada sesi pasar: "Anda harus bergabung dengan sesi pasar terlebih dahulu"
  - Fitur dinonaktifkan: "Fitur aksi kolektif dinonaktifkan. Aktifkan aksi pengguna di admin panel."

## Styling dan UX

### Desktop
- Tombol disabled: `text-slate-400 dark:text-slate-500 cursor-not-allowed opacity-60`
- Background disabled: `bg-slate-200/20 dark:bg-slate-700/20`
- Tooltip: `bg-slate-800 dark:bg-slate-700 text-white`

### Mobile
- Tombol disabled: `opacity-60 cursor-not-allowed`
- Icon disabled: `text-slate-400 dark:text-slate-500`
- Text disabled: `text-slate-400 dark:text-slate-500`
- Tooltip: `bg-slate-800 dark:bg-slate-700 text-white text-xs`

## Alpine.js Tooltip
```javascript
x-data="{ tooltip: false }"
@mouseenter="tooltip = true"
@mouseleave="tooltip = false"
```

## Dependencies
- `User::hasActivePasarKolaboraya()` method untuk mengecek sesi pasar aktif
- `SystemSetting` methods untuk mengecek status fitur
- `User::isSuperAdmin()` dan `User::isEcosystemBuilder()` untuk bypass

## Testing
1. Login sebagai user tanpa sesi pasar aktif - tombol harus disabled
2. Login sebagai user dengan sesi pasar aktif - tombol harus normal (jika fitur diaktifkan)
3. Login sebagai super admin - tombol selalu normal
4. Login sebagai ecosystem builder - tombol ekosistem selalu normal
5. Hover pada tombol disabled - tooltip harus muncul dengan pesan yang sesuai
6. Test pada desktop dan mobile view

## Notes
- Fitur ini bekerja sama dengan sistem disable admin yang sudah ada
- Super admin dan ecosystem builder tetap bisa mengakses semua fitur
- Pesan tooltip berbeda untuk kondisi yang berbeda (tidak ada sesi vs fitur dinonaktifkan)
- Konsisten antara desktop dan mobile navigation
