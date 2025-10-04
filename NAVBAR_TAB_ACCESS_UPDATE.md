# Update Akses Navbar Tab untuk User Tamu dan Undangan

## 🎯 **Masalah yang Diperbaiki**

Tab navbar (Ekosistem dan Aksi Kolektif) masih disabled untuk user tamu dan undangan meskipun sudah diimplementasikan sistem like yang memungkinkan mereka mengakses halaman tersebut.

## 🔧 **Perubahan yang Dilakukan**

### **1. Desktop Navigation Bar**

#### **Ekosistem Tab**
**Sebelum:**
```php
@if (
    ($ecosystemsEnabled || $isEcosystemBuilder) &&
        $hasActiveMarketSession &&
        ($user->canAccessEcosystem() || $isSuperAdmin))
```

**Sesudah:**
```php
@if (
    ($ecosystemsEnabled || $isEcosystemBuilder) &&
        $hasActiveMarketSession &&
        ($user->canAccessEcosystem() || $user->isGuestOrInvitation() || $isSuperAdmin))
```

#### **Aksi Kolektif Tab**
**Sebelum:**
```php
@if (($collectiveActionsEnabled && $hasActiveMarketSession) || ($isSuperAdmin && $user->canAccessEcosystem()))
```

**Sesudah:**
```php
@if (($collectiveActionsEnabled && $hasActiveMarketSession) || ($isSuperAdmin && ($user->canAccessEcosystem() || $user->isGuestOrInvitation())))
```

### **2. Mobile Navigation Bar**

#### **Ekosistem Tab**
**Sebelum:**
```php
@if (
    ($ecosystemsEnabled || $isEcosystemBuilder) &&
        $hasActiveMarketSession &&
        ($user->canAccessEcosystem() || $isSuperAdmin))
```

**Sesudah:**
```php
@if (
    ($ecosystemsEnabled || $isEcosystemBuilder) &&
        $hasActiveMarketSession &&
        ($user->canAccessEcosystem() || $user->isGuestOrInvitation() || $isSuperAdmin))
```

#### **Aksi Kolektif Tab**
**Sebelum:**
```php
@if (($collectiveActionsEnabled && $hasActiveMarketSession) || ($isSuperAdmin && $user->canAccessEcosystem()))
```

**Sesudah:**
```php
@if (($collectiveActionsEnabled && $hasActiveMarketSession) || ($isSuperAdmin && ($user->canAccessEcosystem() || $user->isGuestOrInvitation())))
```

### **3. Tooltip Messages Update**

#### **Ekosistem Tooltip**
**Sebelum:**
```php
@if (!$hasActiveMarketSession)
    Anda harus bergabung dengan sesi pasar terlebih dahulu
@elseif($user->canOnlyConnect())
    Fitur ekosistem tidak tersedia untuk user tipe {{ $user->getUserTypeLabelAttribute() }}. Hanya partisipan yang dapat mengakses fitur ekosistem.
@else
    Fitur ekosistem dinonaktifkan untuk user biasa. Hanya ecosystem builder yang dapat mengakses.
@endif
```

**Sesudah:**
```php
@if (!$hasActiveMarketSession)
    Anda harus bergabung dengan sesi pasar terlebih dahulu
@elseif(!$ecosystemsEnabled && !$isEcosystemBuilder)
    Fitur ekosistem dinonaktifkan untuk user biasa. Hanya ecosystem builder yang dapat mengakses.
@else
    Fitur ekosistem tidak tersedia untuk user tipe {{ $user->getUserTypeLabelAttribute() }}. Hanya partisipan, tamu, dan komunitas yang dapat mengakses fitur ekosistem.
@endif
```

#### **Aksi Kolektif Tooltip**
**Sebelum:**
```php
@if (!$hasActiveMarketSession)
    Anda harus bergabung dengan sesi pasar terlebih dahulu
@elseif($user->canOnlyConnect())
    Fitur aksi kolektif tidak tersedia untuk user tipe {{ $user->getUserTypeLabelAttribute() }}. Hanya partisipan yang dapat mengakses fitur aksi kolektif.
@else
    Fitur aksi kolektif dinonaktifkan. Aktifkan aksi pengguna di admin panel.
@endif
```

**Sesudah:**
```php
@if (!$hasActiveMarketSession)
    Anda harus bergabung dengan sesi pasar terlebih dahulu
@elseif(!$collectiveActionsEnabled)
    Fitur aksi kolektif dinonaktifkan. Aktifkan aksi pengguna di admin panel.
@else
    Fitur aksi kolektif tidak tersedia untuk user tipe {{ $user->getUserTypeLabelAttribute() }}. Hanya partisipan, tamu, dan komunitas yang dapat mengakses fitur aksi kolektif.
@endif
```

## 🎯 **Hasil Perubahan**

### **Untuk User Tamu dan Undangan:**
- ✅ **Tab Ekosistem**: Sekarang dapat diakses (tidak disabled)
- ✅ **Tab Aksi Kolektif**: Sekarang dapat diakses (tidak disabled)
- ✅ **Akses Terbatas**: Hanya dapat melihat dan like, tidak dapat bergabung
- ✅ **Tooltip Informatif**: Pesan tooltip yang sesuai dengan kemampuan user

### **Untuk User Partisipan:**
- ✅ **Akses Penuh**: Tetap dapat mengakses semua fitur
- ✅ **Tidak Ada Perubahan**: Fungsionalitas tetap sama

### **Untuk Super Admin:**
- ✅ **Bypass**: Tetap dapat mengakses semua fitur tanpa batasan

## 🔍 **Kondisi Akses**

### **Ekosistem Tab**
**Aktif jika:**
- `$ecosystemsEnabled` = true ATAU `$isEcosystemBuilder` = true
- DAN `$hasActiveMarketSession` = true
- DAN (`$user->canAccessEcosystem()` = true ATAU `$user->isGuestOrInvitation()` = true ATAU `$isSuperAdmin` = true)

### **Aksi Kolektif Tab**
**Aktif jika:**
- (`$collectiveActionsEnabled` = true DAN `$hasActiveMarketSession` = true)
- ATAU (`$isSuperAdmin` = true DAN (`$user->canAccessEcosystem()` = true ATAU `$user->isGuestOrInvitation()` = true))

## 📱 **Responsive Design**

Perubahan diterapkan pada:
- ✅ **Desktop Navigation Bar** (`resources/views/components/layouts/app/header.blade.php` baris 134-178)
- ✅ **Mobile Navigation Bar** (`resources/views/components/layouts/app/header.blade.php` baris 724-828)

## 🧪 **Testing**

Setelah perubahan ini:
1. **User Tamu**: Dapat mengakses tab Ekosistem dan Aksi Kolektif
2. **User Undangan (Komunitas)**: Dapat mengakses tab Ekosistem dan Aksi Kolektif
3. **User Partisipan**: Tetap dapat mengakses semua tab
4. **Super Admin**: Tetap dapat mengakses semua tab

## 🎉 **Status**

✅ **SELESAI** - Tab navbar sekarang dapat diakses oleh user tamu dan undangan untuk melihat dan melakukan like pada ekosistem dan aksi kolektif.
