# 🚀 Email Custom Pasar Kolaboraya

Implementasi sistem email custom yang menggantikan template default Laravel dengan desain yang menarik dan profesional.

## ✨ Fitur Email yang Tersedia

| Jenis Email | File Notification | Template | Deskripsi |
|-------------|------------------|----------|-----------|
| 🔐 Reset Password | `ResetPasswordNotification` | `auth/reset-password.blade.php` | Email reset password dengan tips keamanan |
| ✅ Email Verifikasi | `EmailVerificationNotification` | `verification/verify-email-new.blade.php` | Email verifikasi dengan info platform |
| 🎉 Welcome Email | `WelcomeEmailNotification` | `general/welcome.blade.php` | Email selamat datang dengan panduan |
| 📅 Event Notification | `EventNotificationCustom` | `events/event-notification.blade.php` | Notifikasi event baru |
| 🤝 Collaboration Invitation | `CollaborationInvitationCustom` | `collaboration/invitation.blade.php` | Undangan kolaborasi |
| 👥 New Connection | `NewConnectionNotificationCustom` | `connections/new-connection.blade.php` | Notifikasi koneksi baru |
| 📊 Status Update | `CollaborationStatusUpdateCustom` | `collaboration/status-update.blade.php` | Update status kolaborasi |

## 🎨 Layout Base

Semua email menggunakan layout base yang konsisten:
- **Header**: Gradient dengan logo dan tagline
- **Content**: Area konten yang fleksibel
- **Footer**: Copyright dan social links
- **Responsive**: Mobile-friendly design

## 🚀 Cara Penggunaan

### 1. Reset Password
```php
use App\Notifications\ResetPasswordNotification;

$user->notify(new ResetPasswordNotification($token));
```

### 2. Email Verifikasi
```php
use App\Notifications\EmailVerificationNotification;

$user->notify(new EmailVerificationNotification());
```

### 3. Welcome Email
```php
use App\Notifications\WelcomeEmailNotification;

$user->notify(new WelcomeEmailNotification($user));
```

### 4. Event Notification
```php
use App\Notifications\EventNotificationCustom;

$user->notify(new EventNotificationCustom($event, $user));
```

### 5. Collaboration Invitation
```php
use App\Notifications\CollaborationInvitationCustom;

$invitee->notify(new CollaborationInvitationCustom($collaboration, $inviter));
```

### 6. New Connection
```php
use App\Notifications\NewConnectionNotificationCustom;

$user->notify(new NewConnectionNotificationCustom($connection, $connectedUser));
```

### 7. Status Update
```php
use App\Notifications\CollaborationStatusUpdateCustom;

$user->notify(new CollaborationStatusUpdateCustom($collaboration, $user, $status, $action));
```

## 🧪 Testing & Preview

### Preview Email Templates
- Welcome: `/email-preview/welcome`
- Event: `/email-preview/event-notification`
- Connection: `/email-preview/new-connection`
- Collaboration: `/email-preview/collaboration-invitation`
- Status: `/email-preview/collaboration-status-update`
- Reset Password: `/email-preview/reset-password`

### Test Pengiriman Email
- Dashboard: `/email-testing-dashboard`
- Test routes tersedia untuk setiap jenis email

## ⚙️ Konfigurasi

### 1. Auth Config (`config/auth.php`)
```php
'notifications' => [
    'password_reset' => \App\Notifications\ResetPasswordNotification::class,
    'email_verification' => \App\Notifications\EmailVerificationNotification::class,
],
```

### 2. User Model (`app/Models/User.php`)
```php
public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}

public function sendEmailVerificationNotification()
{
    $this->notify(new EmailVerificationNotification);
}
```

## 📁 Struktur File

```
app/Notifications/
├── ResetPasswordNotification.php
├── EmailVerificationNotification.php
├── WelcomeEmailNotification.php
├── EventNotificationCustom.php
├── CollaborationInvitationCustom.php
├── NewConnectionNotificationCustom.php
└── CollaborationStatusUpdateCustom.php

resources/views/emails/
├── layouts/base.blade.php
├── auth/reset-password.blade.php
├── verification/verify-email-new.blade.php
├── general/welcome.blade.php
├── events/event-notification.blade.php
├── collaboration/
│   ├── invitation.blade.php
│   └── status-update.blade.php
└── connections/new-connection.blade.php
```

## 🎯 Keunggulan

- ✅ **Konsistensi**: Semua email menggunakan layout yang sama
- ✅ **Professional**: Desain yang menarik dan modern
- ✅ **Responsive**: Mobile-friendly design
- ✅ **Maintainable**: Kode yang terorganisir dengan baik
- ✅ **Branding**: Konsisten dengan brand Pasar Kolaboraya

## 🔧 Customisasi

### Menambah Template Baru
1. Buat notification class di `app/Notifications/`
2. Buat template view di `resources/views/emails/`
3. Extend layout base: `@extends('emails.layouts.base')`
4. Tambahkan route preview dan test

### Mengubah Warna/Theme
Edit file `resources/views/emails/layouts/base.blade.php` untuk mengubah styling global.

## 🚨 Troubleshooting

- **Email tidak terkirim**: Cek konfigurasi SMTP dan queue worker
- **Template tidak muncul**: Clear view cache dengan `php artisan view:clear`
- **Styling tidak konsisten**: Pastikan semua template extend layout base

## 📚 Dokumentasi Lengkap

Lihat file `CUSTOM_EMAIL_IMPLEMENTATION.md` untuk dokumentasi lengkap dan detail implementasi.

---

**Pasar Kolaboraya** - Platform Kolaborasi dan Koneksi Profesional 🚀
