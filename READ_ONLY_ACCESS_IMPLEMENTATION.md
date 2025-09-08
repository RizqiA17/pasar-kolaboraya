# Implementasi Read-Only Access untuk User Biasa

## 🎯 Tujuan

Membatasi akses user biasa agar hanya bisa melihat (read-only) fitur-fitur tertentu, sementara ecosystem builders dan admin memiliki akses penuh untuk mengelola sistem.

## 🔐 Sistem Role dan Permission

### User Roles:
1. **Super Admin** - Akses penuh ke semua fitur
2. **Ecosystem Builder** - Dapat mengelola ecosystem dan collective actions
3. **User Biasa** - Hanya dapat melihat (read-only) dan berkontribusi

### Permission Matrix:

| Fitur | Super Admin | Ecosystem Builder | User Biasa |
|-------|-------------|-------------------|------------|
| View Ecosystems | ✅ | ✅ | ✅ |
| Create Ecosystem | ✅ | ✅ | ❌ |
| Manage Ecosystem | ✅ | ✅ | ❌ (Read-only) |
| View Collective Actions | ✅ | ✅ | ✅ |
| Create Collective Actions | ✅ | ✅ | ❌ |
| Respond to Invitations | ✅ | ✅ | ❌ |
| Contribute to Actions | ✅ | ✅ | ✅ |

## 🛠️ Implementasi Teknis

### 1. Middleware

#### `EcosystemBuilderOnly` Middleware
```php
// Membatasi akses hanya untuk ecosystem builders dan super admin
Route::get('collective-actions/create', Create::class)
    ->middleware('ecosystem.builder.only');
```

#### `ReadOnlyAccess` Middleware
```php
// Membatasi user biasa hanya untuk GET requests
// POST/PUT/DELETE diblokir untuk user biasa
```

### 2. Dashboard Ecosystem

#### Properties Baru:
- `$isEcosystemBuilder` - Status ecosystem builder
- `$isReadOnly` - Mode read-only untuk user biasa

#### Logic Read-Only:
```php
public function getIsReadOnlyProperty()
{
    return !$this->getIsOwnerProperty() && !$this->getIsEcosystemBuilderProperty();
}
```

#### UI Indicators:
- **Pemilik**: Badge biru "Pemilik"
- **Ecosystem Builder**: Badge ungu "Ecosystem Builder"  
- **User Biasa**: Badge abu-abu "Pengunjung" + Badge orange "Mode Lihat Saja"

### 3. Tab Access Control

#### Tab yang Dapat Diakses User Biasa:
- ✅ **Ringkasan** - Informasi umum ecosystem
- ✅ **Kualitas & Keahlian** - Analisis kualitas
- ✅ **Aksi Kolektif** - Daftar aksi yang dibuat

#### Tab yang Dibatasi:
- ❌ **Anggota** - Hanya ecosystem builder+ yang bisa lihat
- ❌ **Undangan Aksi** - Hanya pemilik yang bisa lihat

### 4. Action Restrictions

#### Method Protection:
```php
public function acceptMember($userId)
{
    if ($this->isReadOnly) {
        session()->flash('error', 'Akses ditolak. User biasa hanya dapat melihat data, tidak dapat melakukan perubahan.');
        return;
    }
    // ... existing logic
}
```

## 🎨 UI/UX Changes

### 1. Header Dashboard
- **Status Badge**: Menampilkan role user dengan warna berbeda
- **Read-Only Indicator**: Badge orange "Mode Lihat Saja" untuk user biasa

### 2. Tab Navigation
- **Conditional Tabs**: Tab "Anggota" dan "Undangan Aksi" disembunyikan untuk user biasa
- **Visual Feedback**: Tab yang tidak bisa diakses tidak ditampilkan

### 3. Action Buttons
- **Create Actions**: Tombol "Buat Aksi Kolektif" hanya untuk ecosystem builder
- **Manage Members**: Tombol approve/reject hanya untuk pemilik ecosystem
- **Response Invitations**: Hanya ecosystem builder yang bisa merespons undangan

### 4. Read-Only Messages
- **Informational Banners**: Pesan jelas tentang mode read-only
- **Error Messages**: Pesan error yang informatif saat aksi diblokir

## 📋 Routes Protection

### Routes dengan Middleware `ecosystem.builder.only`:
```php
Route::get('collective-actions/create', Create::class)
    ->middleware('ecosystem.builder.only');

Route::get('collective-actions/invitations/{invitation}/respond', RespondInvitation::class)
    ->middleware('ecosystem.builder.only');
```

### Routes yang Tetap Terbuka untuk Semua User:
```php
Route::get('ecosystem', Browse::class); // View ecosystems
Route::get('ecosystem/{ecosystem}/dashboard', Dashboard::class); // View dashboard (read-only)
Route::get('collective-actions', Browse::class); // View collective actions
Route::get('collective-actions/{collectiveAction}/contribute', Contribute::class); // Contribute
```

## 🔒 Security Features

### 1. Server-Side Protection
- **Middleware Level**: Blokir akses di level route
- **Component Level**: Validasi di Livewire component
- **Method Level**: Check permission di setiap method

### 2. Client-Side Indicators
- **Visual Feedback**: Badge dan indikator status
- **Button States**: Tombol disabled/hidden untuk aksi yang tidak diizinkan
- **Informational Messages**: Pesan jelas tentang keterbatasan akses

### 3. Error Handling
- **Graceful Degradation**: User tetap bisa menggunakan fitur yang diizinkan
- **Clear Messages**: Pesan error yang informatif dan actionable
- **Fallback Behavior**: Redirect atau show read-only view

## 🎯 User Experience

### Untuk User Biasa:
1. **Clear Expectations**: Badge "Mode Lihat Saja" memberikan feedback jelas
2. **Focused Experience**: Hanya fitur yang relevan yang ditampilkan
3. **Contribution Access**: Tetap bisa berkontribusi ke collective actions
4. **Information Access**: Bisa melihat semua informasi ecosystem

### Untuk Ecosystem Builders:
1. **Full Access**: Semua fitur management tersedia
2. **Clear Distinction**: Badge "Ecosystem Builder" menunjukkan status
3. **Management Tools**: Tab dan tombol management tersedia

### Untuk Pemilik Ecosystem:
1. **Owner Privileges**: Badge "Pemilik" dan akses penuh
2. **Member Management**: Bisa approve/reject anggota
3. **Invitation Management**: Bisa merespons undangan collective action

## ✅ Testing Checklist

- [ ] User biasa tidak bisa akses route create collective action
- [ ] User biasa tidak bisa akses route respond invitation
- [ ] User biasa bisa lihat dashboard dalam mode read-only
- [ ] User biasa tidak bisa approve/reject anggota
- [ ] User biasa tidak bisa lihat tab "Anggota" dan "Undangan Aksi"
- [ ] Ecosystem builder bisa akses semua fitur management
- [ ] Pemilik ecosystem bisa akses semua fitur management
- [ ] Super admin bisa akses semua fitur
- [ ] UI menampilkan badge status yang benar
- [ ] Error messages informatif dan user-friendly

## 🚀 Benefits

1. **Security**: Mencegah user biasa melakukan aksi yang tidak diizinkan
2. **User Experience**: Interface yang jelas dan tidak membingungkan
3. **Scalability**: Sistem permission yang mudah dikembangkan
4. **Maintainability**: Code yang terstruktur dan mudah dipelihara
5. **Compliance**: Memenuhi requirement untuk role-based access control
