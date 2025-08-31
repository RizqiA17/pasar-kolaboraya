# Panduan Penggunaan Komponen UI

## Overview
Dokumen ini menjelaskan cara penggunaan komponen UI yang telah dibuat untuk menampilkan foto profil dan banner dengan handling yang tepat jika belum di-set.

## Komponen yang Tersedia

### 1. Avatar Component (`x-ui.avatar`)

Komponen untuk menampilkan foto profil user dengan fallback ke initials jika belum ada foto.

#### Props:
- `user` - Model User (required)
- `size` - Ukuran avatar: `xs`, `sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl` (default: `md`)
- `showStatus` - Tampilkan status indicator (default: `false`)
- `statusColor` - Warna status: `green`, `red`, `yellow`, `blue` (default: `green`)
- `class` - CSS classes tambahan

#### Contoh Penggunaan:
```blade
<!-- Avatar dengan ukuran default -->
<x-ui.avatar :user="$user" />

<!-- Avatar dengan ukuran besar dan status -->
<x-ui.avatar :user="$user" size="xl" :showStatus="true" />

<!-- Avatar dengan ukuran custom dan class tambahan -->
<x-ui.avatar :user="$user" size="2xl" class="ring-4 ring-white" />
```

### 2. Banner Component (`x-ui.banner`)

Komponen untuk menampilkan banner user dengan fallback ke placeholder jika belum ada banner.

#### Props:
- `user` - Model User (required)
- `height` - Tinggi banner dalam Tailwind classes (default: `h-40`)
- `class` - CSS classes tambahan
- `showOverlay` - Tampilkan overlay (default: `false`)
- `overlayContent` - Konten overlay jika `showOverlay` true

#### Contoh Penggunaan:
```blade
<!-- Banner dengan tinggi default -->
<x-ui.banner :user="$user" />

<!-- Banner dengan tinggi custom -->
<x-ui.banner :user="$user" height="h-32" />

<!-- Banner dengan overlay -->
<x-ui.banner :user="$user" :showOverlay="true" :overlayContent="'Custom Overlay'" />
```

### 3. User Card Component (`x-ui.user-card`)

Komponen card lengkap untuk menampilkan informasi user dengan foto profil dan banner.

#### Props:
- `user` - Model User (required)
- `showBanner` - Tampilkan banner (default: `true`)
- `showAvatar` - Tampilkan avatar (default: `true`)
- `avatarSize` - Ukuran avatar (default: `lg`)
- `bannerHeight` - Tinggi banner (default: `h-24`)
- `showStats` - Tampilkan statistik (default: `false`)
- `showActions` - Tampilkan action buttons (default: `false`)
- `actions` - Array action buttons
- `class` - CSS classes tambahan

#### Contoh Penggunaan:
```blade
<!-- User card sederhana -->
<x-ui.user-card :user="$user" />

<!-- User card dengan statistik -->
<x-ui.user-card :user="$user" :showStats="true" />

<!-- User card dengan action buttons -->
<x-ui.user-card :user="$user" :showActions="true" :actions="$actions" />
```

### 4. Profile Header Component (`x-ui.profile-header`)

Komponen header lengkap untuk halaman profil dengan banner dan foto profil besar.

#### Props:
- `user` - Model User (required)
- `bannerHeight` - Tinggi banner (default: `h-40`)
- `avatarSize` - Ukuran avatar (default: `4xl`)
- `showStatus` - Tampilkan status indicator (default: `true`)
- `class` - CSS classes tambahan

#### Contoh Penggunaan:
```blade
<!-- Profile header lengkap -->
<x-ui.profile-header :user="$user" />

<!-- Profile header dengan tinggi banner custom -->
<x-ui.profile-header :user="$user" bannerHeight="h-48" />
```

### 5. User List Item Component (`x-ui.user-list-item`)

Komponen untuk menampilkan user dalam list dengan foto profil.

#### Props:
- `user` - Model User (required)
- `avatarSize` - Ukuran avatar (default: `md`)
- `showAvatar` - Tampilkan avatar (default: `true`)
- `showEmail` - Tampilkan email (default: `true`)
- `showOrganization` - Tampilkan organisasi (default: `true`)
- `showActions` - Tampilkan action buttons (default: `false`)
- `actions` - Array action buttons
- `clickable` - Buat item clickable (default: `false`)
- `onClick` - Action saat diklik
- `class` - CSS classes tambahan

#### Contoh Penggunaan:
```blade
<!-- User list item sederhana -->
<x-ui.user-list-item :user="$user" />

<!-- User list item dengan actions -->
<x-ui.user-list-item :user="$user" :showActions="true" :actions="$actions" />

<!-- User list item clickable -->
<x-ui.user-list-item :user="$user" :clickable="true" onClick="showProfile({{ $user->id }})" />
```

## Contoh Implementasi Lengkap

### Halaman Profile
```blade
<div class="w-full">
    <!-- Profile Header -->
    <x-ui.profile-header :user="$user" />
    
    <!-- Profile Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>
            <!-- Content here -->
        </div>
    </div>
</div>
```

### User List
```blade
<div class="space-y-4">
    @foreach($users as $user)
        <x-ui.user-list-item 
            :user="$user" 
            :showActions="true" 
            :actions="[
                ['label' => 'Lihat Profile', 'action' => 'viewProfile(' . $user->id . ')', 'icon' => '<svg>...</svg>'],
                ['label' => 'Kirim Pesan', 'action' => 'sendMessage(' . $user->id . ')', 'icon' => '<svg>...</svg>']
            ]"
        />
    @endforeach
</div>
```

### Connection Card
```blade
<div class="bg-white rounded-xl border border-gray-100 p-6">
    <div class="flex items-center space-x-4">
        <x-ui.avatar :user="$user" size="lg" :showStatus="true" />
        <div class="flex-1">
            <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>
    </div>
</div>
```

## Fallback Handling

Semua komponen secara otomatis menangani kasus ketika user belum memiliki:
- **Foto Profil**: Akan menampilkan initials dengan gradient background yang menarik
- **Banner**: Akan menampilkan placeholder dengan gradient dan icon yang sesuai

## Styling

Komponen menggunakan Tailwind CSS dan dapat dikustomisasi dengan:
- Props untuk ukuran dan tampilan
- Class tambahan untuk styling custom
- Variasi warna dan efek visual

## Best Practices

1. **Gunakan ukuran yang sesuai**: Pilih ukuran avatar yang sesuai dengan konteks
2. **Konsistensi**: Gunakan komponen yang sama untuk tampilan yang konsisten
3. **Performance**: Komponen sudah dioptimasi untuk performa yang baik
4. **Accessibility**: Semua komponen sudah mengikuti standar accessibility

## Troubleshooting

### Avatar tidak muncul
- Pastikan user model memiliki relasi `profile`
- Periksa apakah ada error di console browser
- Pastikan storage link sudah dibuat

### Banner tidak muncul
- Periksa apakah file banner tersimpan di storage
- Pastikan permission file storage sudah benar
- Periksa apakah ada error di log Laravel
