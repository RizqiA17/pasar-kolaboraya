# Cara Menggunakan Notifikasi Ekosistem

## 🚀 Quick Start

### 1. Mengirim Notifikasi Penerimaan
```php
use App\Services\NotificationService;

// Di dalam method acceptMember() di Ecosystem Dashboard
$notificationService = app(NotificationService::class);
$notificationService->createEcosystemAcceptanceNotification(
    $user,           // User yang diterima
    $ecosystem,      // Ekosistem yang bersangkutan
    Auth::user()     // Admin yang menyetujui
);
```

### 2. Mengirim Notifikasi Penolakan
```php
use App\Services\NotificationService;

// Di dalam method rejectMember() di Ecosystem Dashboard
$notificationService = app(NotificationService::class);
$notificationService->createEcosystemRejectionNotification(
    $user,           // User yang ditolak
    $ecosystem,      // Ekosistem yang bersangkutan
    Auth::user()     // Admin yang menolak
);
```

## 📱 Tampilan di Frontend

### Header Notification Dropdown
```html
<!-- Notifikasi akan muncul otomatis di header -->
<div class="notification-dropdown">
    <div class="notification-item">
        <div class="notification-title">Bergabung dengan Ekosistem</div>
        <div class="notification-message">
            Permintaan bergabung Anda dengan ekosistem 'Nama Ekosistem' 
            telah disetujui oleh Admin Name. Selamat bergabung!
        </div>
        <div class="notification-actions">
            <button class="btn-view">Lihat</button>
            <button class="btn-mark-read">✓</button>
        </div>
    </div>
</div>
```

### Real-time Updates
```javascript
// Notifikasi akan update otomatis setiap 5 detik
// atau via WebSocket jika Pusher dikonfigurasi
setInterval(() => {
    loadNotifications();
}, 5000);
```

## 🔧 Konfigurasi

### 1. Environment Variables
```env
# .env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

### 2. Database Migration
```bash
# Pastikan tabel notifications sudah ada
php artisan migrate

# Cek struktur tabel
php artisan tinker
>>> Schema::getColumnListing('notifications');
```

## 🧪 Testing

### 1. Manual Testing
```bash
# Jalankan test script
php test_ecosystem_notification.php
```

### 2. Browser Testing
1. Login sebagai user biasa
2. Ajukan bergabung ke ekosistem
3. Login sebagai admin ekosistem
4. Terima/tolak permintaan
5. Cek notifikasi di header user

### 3. API Testing
```bash
# Test notification endpoints
curl -X GET "http://localhost/notifications/recent" \
  -H "Authorization: Bearer YOUR_TOKEN"

curl -X POST "http://localhost/notifications/{id}/mark-read" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## 📊 Monitoring

### 1. Database Queries
```sql
-- Cek total notifikasi
SELECT COUNT(*) FROM notifications;

-- Cek notifikasi per user
SELECT 
    u.name,
    COUNT(n.id) as total_notifications,
    COUNT(CASE WHEN n.is_read = 0 THEN 1 END) as unread_count
FROM users u
LEFT JOIN notifications n ON u.id = n.notifiable_id
GROUP BY u.id, u.name;

-- Cek notifikasi ekosistem
SELECT 
    n.title,
    n.message,
    n.created_at,
    n.is_read
FROM notifications n
WHERE n.data->>'type' IN ('ecosystem_acceptance', 'ecosystem_rejection')
ORDER BY n.created_at DESC;
```

### 2. Laravel Tinker
```php
// Cek notifikasi user
$user = User::find(1);
$user->notifications()->count();

// Cek notifikasi ekosistem
$ecosystem = Ecosystem::find(1);
$notifications = Notification::where('data->ecosystem_id', $ecosystem->id)->get();

// Test notification service
$service = app(NotificationService::class);
$notification = $service->createEcosystemAcceptanceNotification($user, $ecosystem, $user);
```

## 🐛 Troubleshooting

### 1. Notifikasi Tidak Muncul
```bash
# Cek database connection
php artisan tinker
>>> App\Models\Notification::count();

# Cek Pusher configuration
php artisan config:show broadcasting

# Cek queue workers
php artisan queue:work --once
```

### 2. Real-time Tidak Bekerja
```javascript
// Cek console browser untuk error
console.log('Pusher status:', typeof Pusher !== 'undefined');

// Cek WebSocket connection
// Buka Network tab di DevTools
// Cari request ke pusher.com
```

### 3. Permission Issues
```php
// Cek user permissions
$user = Auth::user();
$user->canAccessEcosystem(); // true/false

// Cek ecosystem ownership
$ecosystem = Ecosystem::find(1);
$ecosystem->creator_id === Auth::id(); // true/false
```

## 🔄 Workflow Lengkap

### 1. User Flow
```
User Login → Browse Ecosystems → Join Request → Wait for Approval
                                                      ↓
User Dashboard ← Notification ← Admin Approves/Rejects
```

### 2. Admin Flow
```
Admin Login → Ecosystem Dashboard → View Requests → Approve/Reject
                                                      ↓
User Gets Notification ← System Sends Notification
```

### 3. System Flow
```
User Action → Database Update → Notification Service → Database Store
                                                              ↓
Real-time Broadcast ← Pusher/WebSocket ← Notification Created
```

## 📈 Performance Tips

### 1. Database Optimization
```sql
-- Index untuk query notifikasi
CREATE INDEX idx_notifications_user_read ON notifications(notifiable_id, is_read);
CREATE INDEX idx_notifications_created ON notifications(created_at);
CREATE INDEX idx_notifications_type ON notifications((data->>'type'));
```

### 2. Caching
```php
// Cache unread count
$unreadCount = Cache::remember("user.{$userId}.unread_count", 60, function() use ($userId) {
    return User::find($userId)->notifications()->where('is_read', false)->count();
});
```

### 3. Queue Jobs
```php
// Untuk notifikasi bulk, gunakan queue
dispatch(new SendEcosystemNotificationJob($users, $ecosystem, $type));
```

## 🎯 Best Practices

### 1. Notification Content
- Gunakan bahasa yang jelas dan sopan
- Sertakan nama ekosistem dan admin
- Berikan action yang jelas (Lihat, Terima, dll)

### 2. Timing
- Kirim notifikasi segera setelah action
- Jangan spam notifikasi
- Berikan waktu yang wajar untuk response

### 3. User Experience
- Notifikasi harus actionable
- Berikan feedback visual yang jelas
- Support untuk mobile dan desktop

### 4. Security
- Validasi permission sebelum kirim notifikasi
- Jangan expose data sensitif
- Sanitize user input

## 📚 API Reference

### NotificationService Methods

#### `createEcosystemAcceptanceNotification(User $user, Ecosystem $ecosystem, User $approver)`
- **Parameters**: User, Ecosystem, User (approver)
- **Returns**: Notification instance
- **Purpose**: Kirim notifikasi penerimaan ekosistem

#### `createEcosystemRejectionNotification(User $user, Ecosystem $ecosystem, User $approver)`
- **Parameters**: User, Ecosystem, User (approver)
- **Returns**: Notification instance
- **Purpose**: Kirim notifikasi penolakan ekosistem

### Notification Model

#### Properties
- `id`: UUID notification
- `title`: Judul notifikasi
- `message`: Pesan notifikasi
- `redirect_url`: URL untuk redirect
- `is_read`: Status baca
- `data`: Data tambahan (JSON)
- `created_at`: Waktu dibuat

#### Methods
- `markAsRead()`: Tandai sebagai sudah dibaca
- `markAsUnread()`: Tandai sebagai belum dibaca
- `isRead()`: Cek status baca
- `time_ago`: Waktu relatif

---

**Status**: ✅ **READY TO USE** - Sistem notifikasi ekosistem siap digunakan dalam production.
