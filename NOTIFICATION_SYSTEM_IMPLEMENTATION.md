# Sistem Notifikasi - Pasar Kolaboraya

## Overview
Sistem notifikasi telah berhasil diimplementasikan dengan fitur real-time menggunakan Pusher. Sistem ini memungkinkan pengguna untuk menerima notifikasi langsung di browser dan mengelola notifikasi mereka.

## Fitur yang Diimplementasikan

### 1. Database Schema
- Tabel `notifications` dengan field:
  - `id` (UUID)
  - `type` (string)
  - `notifiable_type` dan `notifiable_id` (polymorphic relationship)
  - `data` (JSON)
  - `title` (string, nullable)
  - `message` (text)
  - `redirect_url` (string, nullable)
  - `is_read` (boolean, default false)
  - `read_at` (timestamp, nullable)
  - `created_at` dan `updated_at`

### 2. Model dan Controller
- **Notification Model**: Menangani UUID, relationships, dan methods untuk mark as read/unread
- **NotificationController**: CRUD operations, mark as read, get unread count, dll.
- **NotificationService**: Service class untuk membuat notifikasi dengan berbagai tipe

### 3. Views
- **notifications/index.blade.php**: Halaman daftar semua notifikasi
- **notifications/show.blade.php**: Halaman detail notifikasi
- **Navbar dropdown**: Notifikasi real-time di header

### 4. Real-time Features
- **Pusher Integration**: Notifikasi real-time menggunakan Pusher
- **Browser Notifications**: Notifikasi browser native
- **Auto-refresh**: Notifikasi ter-update otomatis setiap 30 detik

### 5. Routes
```php
// Notification Routes
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
Route::get('notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
Route::get('notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::delete('notifications/read/all', [NotificationController::class, 'destroyAllRead'])->name('notifications.destroy-all-read');
```

## Cara Penggunaan

### 1. Membuat Notifikasi
```php
use App\Services\NotificationService;

$notificationService = new NotificationService();

// Notifikasi untuk satu user
$notification = $notificationService->createNotification(
    $user,
    'Judul Notifikasi',
    'Pesan notifikasi',
    route('some.route'), // URL redirect (optional)
    ['data' => 'tambahan'] // Data tambahan (optional)
);

// Notifikasi untuk multiple users
$notifications = $notificationService->createBulkNotifications(
    [1, 2, 3], // Array user IDs
    'Judul Notifikasi',
    'Pesan notifikasi'
);

// Notifikasi untuk semua user di Pasar Kolaboraya
$notifications = $notificationService->createPasarKolaborayaNotification(
    $pasarKolaborayaId,
    'Judul Notifikasi',
    'Pesan notifikasi'
);
```

### 2. Notifikasi Khusus
```php
// Notifikasi permintaan koneksi
$notification = $notificationService->createConnectionRequestNotification($receiver, $sender);

// Notifikasi koneksi diterima
$notification = $notificationService->createConnectionAcceptedNotification($receiver, $sender);

// Notifikasi undangan ekosistem
$notification = $notificationService->createEcosystemInvitationNotification($user, $ecosystem, $inviter);

// Notifikasi aksi kolektif
$notification = $notificationService->createCollectiveActionNotification($user, $collectiveAction, 'Pesan');
```

### 3. Testing
```bash
# Test notifikasi
php artisan notification:test [user_id]

# Contoh output:
# Test notification created successfully!
# Notification ID: b15ab298-5e76-435b-80f8-62415dfaabc9
# User: Super Admin (superadmin@example.com)
# Title: Test Notification
# Message: This is a test notification to verify the notification system is working properly.
```

## Konfigurasi Pusher

### 1. Environment Variables
Tambahkan ke `.env`:
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

### 2. Pusher Channels
- Channel: `notifications.{user_id}` (private channel)
- Events: `notification.created`, `notification.updated`

## Integrasi dengan Fitur Existing

### 1. Connection System
```php
// Di ConnectionController atau service yang menangani connection
public function acceptConnection(Connection $connection)
{
    // ... existing logic ...
    
    // Kirim notifikasi ke requester
    $notificationService = new NotificationService();
    $notificationService->createConnectionAcceptedNotification(
        $connection->requester,
        $connection->receiver
    );
}
```

### 2. Ecosystem System
```php
// Di EcosystemController
public function inviteUser(Ecosystem $ecosystem, User $user)
{
    // ... existing logic ...
    
    // Kirim notifikasi undangan
    $notificationService = new NotificationService();
    $notificationService->createEcosystemInvitationNotification(
        $user,
        $ecosystem,
        auth()->user()
    );
}
```

## Frontend JavaScript

### 1. Real-time Updates
Notifikasi akan ter-update otomatis melalui Pusher. JavaScript sudah terintegrasi di navbar.

### 2. Browser Notifications
Sistem akan meminta izin untuk menampilkan notifikasi browser native.

### 3. Auto-refresh
Notifikasi akan di-refresh setiap 30 detik untuk memastikan data ter-update.

## Troubleshooting

### 1. Pusher tidak berfungsi
- Pastikan environment variables sudah benar
- Cek koneksi internet
- Pastikan Pusher app sudah aktif

### 2. Notifikasi tidak muncul
- Cek console browser untuk error
- Pastikan user sudah login
- Cek database untuk data notifikasi

### 3. Real-time tidak bekerja
- Pastikan Pusher credentials benar
- Cek network tab di browser
- Pastikan broadcasting driver = pusher

## File yang Dibuat/Dimodifikasi

### Baru:
- `app/Models/Notification.php`
- `app/Http/Controllers/NotificationController.php`
- `app/Services/NotificationService.php`
- `app/Events/NotificationCreated.php`
- `app/Events/NotificationUpdated.php`
- `app/Console/Commands/TestNotificationCommand.php`
- `resources/views/notifications/index.blade.php`
- `resources/views/notifications/show.blade.php`
- `config/broadcasting.php`
- `database/migrations/2025_09_20_112520_add_notification_fields_to_notifications_table.php`

### Dimodifikasi:
- `database/migrations/2025_08_30_091609_create_notifications_table.php`
- `app/Models/User.php` (tambah relationship notifications)
- `resources/views/components/layouts/app/header.blade.php` (navbar dropdown)
- `routes/web.php` (tambah routes notifikasi)

## Next Steps

1. **Integrasi dengan fitur existing**: Tambahkan notifikasi ke connection, ecosystem, collective action, dll.
2. **Email notifications**: Implementasi notifikasi via email
3. **Push notifications**: Implementasi push notifications untuk mobile
4. **Notification preferences**: User bisa set preferensi notifikasi
5. **Notification templates**: Template untuk berbagai jenis notifikasi
6. **Analytics**: Tracking notifikasi yang dibuka/diklik

Sistem notifikasi sudah siap digunakan dan dapat diintegrasikan dengan fitur-fitur existing di Pasar Kolaboraya.
