# Sistem Kolaborasi dengan Notifikasi dan Soft Delete

## Overview
Sistem kolaborasi ini telah diimplementasikan dengan fitur notifikasi real-time dan soft delete untuk menjaga data tetap tersedia meskipun ditolak. Sistem ini mirip dengan sistem koneksi yang sudah ada, namun dengan fitur tambahan untuk manajemen kolaborasi.

## Fitur Utama

### 1. Manajemen Kolaborasi
- **Buat Kolaborasi**: User dapat membuat kolaborasi baru dengan judul dan deskripsi
- **Undang User**: Sistem memungkinkan pengundangan multiple user ke dalam kolaborasi
- **Status Kolaborasi**: 
  - `pending`: Kolaborasi baru dibuat, menunggu anggota
  - `active`: Kolaborasi aktif dengan minimal 2 anggota

### 2. Sistem Undangan
- **Status Undangan**:
  - `pending`: Undangan belum direspon
  - `accepted`: Undangan diterima
  - `declined`: Undangan ditolak (soft delete)

### 3. Notifikasi Real-time
- **CollaborationInvitation**: Notifikasi saat user diundang ke kolaborasi
- **CollaborationStatusUpdate**: Notifikasi saat undangan diterima/ditolak
- **Channel**: Database dan Email

### 4. Soft Delete
- Data undangan yang ditolak tidak dihapus permanen
- Menggunakan `deleted_at` timestamp
- Data tetap tersedia untuk audit dan analytics

### 5. Sistem Tab untuk Manajemen Kolaborasi
- **Overview Tab**: Dashboard dengan statistik kolaborasi
- **Undangan Masuk Tab**: Lihat dan kelola undangan kolaborasi yang pending
- **Kolaborasi Saya Tab**: Daftar kolaborasi yang diikuti user
- **Yang Saya Buat Tab**: Daftar kolaborasi yang dibuat oleh user

## Struktur Database

### Tabel `notifications`
```sql
CREATE TABLE notifications (
    id UUID PRIMARY KEY,
    type VARCHAR,
    notifiable_type VARCHAR,
    notifiable_id BIGINT,
    data TEXT,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel `collaborations`
```sql
CREATE TABLE collaborations (
    id BIGINT PRIMARY KEY,
    created_by BIGINT,
    title VARCHAR,
    description TEXT,
    status ENUM('pending', 'active'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel `collaboration_user`
```sql
CREATE TABLE collaboration_user (
    id BIGINT PRIMARY KEY,
    collaboration_id BIGINT,
    user_id BIGINT,
    status ENUM('pending', 'accepted', 'declined'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL  -- Soft delete
);
```

## Komponen yang Dibuat

### 1. Models
- **Collaboration**: Model utama kolaborasi
- **CollaborationUser**: Pivot table dengan soft delete
- **User**: Extended dengan relasi kolaborasi

### 2. Notifications
- **CollaborationInvitation**: Notifikasi undangan kolaborasi
- **CollaborationStatusUpdate**: Notifikasi update status

### 3. Services
- **CollaborationService**: Business logic untuk kolaborasi
  - `createCollaboration()`: Buat kolaborasi baru
  - `inviteUsers()`: Undang user ke kolaborasi
  - `acceptInvitation()`: Terima undangan
  - `declineInvitation()`: Tolak undangan (soft delete)
  - `removeUser()`: Hapus user dari kolaborasi

### 4. Livewire Components
- **CollaborationManager**: Manajemen kolaborasi utama dengan sistem tab
- **CollaborationNotifications**: Notifikasi kolaborasi di top bar
- **RequestedCollaboration**: Komponen untuk menampilkan undangan yang masuk

## Cara Penggunaan

### 1. Membuat Kolaborasi
```php
// Menggunakan service
$collaborationService = app(CollaborationService::class);
$collaboration = $collaborationService->createCollaboration(
    [
        'title' => 'Judul Kolaborasi',
        'description' => 'Deskripsi kolaborasi'
    ],
    Auth::user(),
    [1, 2, 3] // User IDs yang diundang
);
```

### 2. Mengundang User
```php
$collaborationService->inviteUsers(
    $collaboration,
    [4, 5, 6], // User IDs baru
    Auth::user()
);
```

### 3. Menerima/Menolak Undangan
```php
// Terima
$collaborationService->acceptInvitation($collaboration, $user);

// Tolak (soft delete)
$collaborationService->declineInvitation($collaboration, $user);
```

### 4. Mengirim Notifikasi
```php
// Notifikasi otomatis dikirim saat:
// - User diundang ke kolaborasi
// - Undangan diterima/ditolak
$user->notify(new CollaborationInvitation($collaboration, $inviter));
```

## Routes

```php
Route::get('collaborations/manage', CollaborationManager::class)
    ->name('collaborations.manage');
```

## Integrasi dengan UI

### 1. Top Bar Notifications
- **Icon Koneksi** (abu-abu): Notifikasi koneksi yang sudah ada
- **Icon Kolaborasi** (biru): Notifikasi kolaborasi dengan badge jumlah undangan
- Dropdown menampilkan daftar notifikasi kolaborasi
- Fitur "Tandai semua sudah dibaca"

### 2. Collaboration Manager dengan Tab System
- **Overview Tab**: Dashboard dengan 3 card statistik
  - Undangan Pending (kuning)
  - Kolaborasi Saya (biru)
  - Yang Saya Buat (hijau)
- **Undangan Masuk Tab**: 
  - Daftar undangan kolaborasi yang pending
  - Tombol Terima/Tolak untuk setiap undangan
  - Informasi detail kolaborasi dan creator
- **Kolaborasi Saya Tab**: 
  - Daftar kolaborasi yang diikuti user
  - Status kolaborasi dan jumlah anggota
  - Tombol untuk mengundang user tambahan
- **Yang Saya Buat Tab**: 
  - Daftar kolaborasi yang dibuat oleh user
  - Status dan jumlah anggota
  - Tombol untuk mengundang user tambahan

### 3. Form dan Modal
- Form pembuatan kolaborasi dengan validasi
- Form undangan user dengan search dan multi-select
- Modal untuk mengundang user ke kolaborasi yang sudah ada

## Fitur Tab System

### Overview Tab
- **Card Statistik**: Menampilkan jumlah undangan pending, kolaborasi yang diikuti, dan kolaborasi yang dibuat
- **Quick Actions**: Link cepat ke tab yang relevan
- **Visual Indicators**: Icon dan warna yang berbeda untuk setiap kategori

### Undangan Masuk Tab
- **List View**: Grid layout untuk undangan kolaborasi
- **Action Buttons**: Terima/Tolak untuk setiap undangan
- **Real-time Updates**: Auto-refresh saat ada perubahan status
- **Empty State**: Pesan dan icon ketika tidak ada undangan

### Kolaborasi Saya Tab
- **Member Count**: Jumlah anggota yang sudah diterima
- **Status Display**: Status kolaborasi (pending/active)
- **Invite Button**: Tombol untuk mengundang user tambahan
- **Responsive Grid**: Layout yang responsif untuk berbagai ukuran layar

### Yang Saya Buat Tab
- **Creator View**: Perspektif dari pembuat kolaborasi
- **Member Management**: Lihat dan kelola anggota kolaborasi
- **Invite System**: Undang user baru ke kolaborasi yang sudah ada

## Keamanan dan Validasi

### 1. Authorization
- Hanya creator yang dapat mengundang user tambahan
- User hanya dapat mengelola kolaborasi yang mereka buat
- Validasi input untuk judul dan deskripsi

### 2. Data Integrity
- Soft delete untuk data undangan yang ditolak
- Transaction untuk operasi yang melibatkan multiple table
- Error handling dan logging

## Testing

### 1. Unit Tests
- Test model relationships
- Test service methods
- Test notification sending

### 2. Feature Tests
- Test collaboration creation flow
- Test invitation acceptance/rejection
- Test notification delivery
- Test tab system functionality

## Monitoring dan Analytics

### 1. Metrics
- Jumlah kolaborasi aktif
- Tingkat penerimaan undangan
- Waktu rata-rata respon undangan
- Distribusi status kolaborasi

### 2. Logging
- Semua operasi kolaborasi di-log
- Error logging untuk debugging
- Audit trail untuk compliance

## Future Enhancements

### 1. Real-time Updates
- WebSocket untuk notifikasi real-time
- Live collaboration status updates
- Real-time tab updates

### 2. Advanced Features
- Collaboration templates
- Bulk user invitation
- Collaboration analytics dashboard
- Advanced filtering dan search

### 3. Integration
- Calendar integration
- File sharing
- Task management
- Email notifications

## Troubleshooting

### 1. Common Issues
- **Notifikasi tidak terkirim**: Periksa queue worker
- **Soft delete tidak berfungsi**: Pastikan migration sudah dijalankan
- **Relasi error**: Periksa foreign key constraints
- **Tab tidak berfungsi**: Periksa JavaScript dan Livewire

### 2. Debug Commands
```bash
# Periksa status migration
php artisan migrate:status

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Periksa queue
php artisan queue:work
```

## Kesimpulan

Sistem kolaborasi ini telah berhasil diimplementasikan dengan fitur lengkap:
- ✅ Manajemen kolaborasi dengan CRUD operations
- ✅ Sistem undangan dengan status tracking
- ✅ Notifikasi real-time (database + email)
- ✅ Soft delete untuk data integrity
- ✅ UI yang modern dan responsive dengan sistem tab
- ✅ Integrasi dengan sistem notifikasi yang ada
- ✅ Service layer untuk business logic
- ✅ Error handling dan validation
- ✅ Tab system untuk manajemen kolaborasi yang terorganisir
- ✅ Notifikasi kolaborasi di top bar dengan badge counter

Sistem ini siap digunakan dan dapat dikembangkan lebih lanjut sesuai kebutuhan bisnis. Fitur tab system memudahkan user untuk mengelola berbagai aspek kolaborasi dalam satu halaman yang terorganisir dengan baik.
