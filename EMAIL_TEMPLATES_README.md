# Email Templates - Pasar Kolaboraya

Dokumentasi lengkap untuk semua template email custom yang telah dibuat untuk project Pasar Kolaboraya.

## 📁 Struktur File

```
resources/views/emails/
├── layouts/
│   └── base.blade.php              # Template dasar untuk semua email
├── verification/
│   ├── verify-email.blade.php      # Template lama (legacy)
│   └── verify-email-new.blade.php  # Template baru dengan desain modern
├── collaboration/
│   ├── invitation.blade.php        # Email undangan kolaborasi
│   └── status-update.blade.php     # Email update status kolaborasi
├── auth/
│   └── reset-password.blade.php    # Email reset password
├── general/
│   └── welcome.blade.php           # Email welcome untuk member baru
├── events/
│   └── event-notification.blade.php # Email notifikasi event baru
└── connections/
    └── new-connection.blade.php    # Email notifikasi koneksi baru
```

## 🎨 Template Base (Layout)

**File:** `resources/views/emails/layouts/base.blade.php`

Template dasar yang digunakan oleh semua email dengan fitur:
- Header dengan gradient dan logo Pasar Kolaboraya
- Responsive design untuk mobile dan desktop
- Color scheme yang konsisten (ungu-biru gradient)
- Footer dengan informasi kontak dan disclaimer
- CSS inline untuk kompatibilitas email client

### Fitur Utama:
- **Header Gradient:** Linear gradient ungu-biru dengan pattern overlay
- **Typography:** Font Segoe UI dengan hierarchy yang jelas
- **Components:** Button, info grid, highlight box, warning/success alerts
- **Responsive:** Mobile-first design dengan breakpoint 600px
- **Accessibility:** High contrast dan readable text

## 📧 Template Email yang Tersedia

### 1. Email Verifikasi
**File:** `resources/views/emails/verification/verify-email-new.blade.php`
**Subject:** "Verifikasi Email - Pasar Kolaboraya"

**Fitur:**
- Welcome message yang ramah
- Call-to-action button untuk verifikasi
- Informasi fitur yang tersedia setelah verifikasi
- Warning tentang expiry time
- Grid informasi fitur platform

### 2. Email Undangan Kolaborasi
**File:** `resources/views/emails/collaboration/invitation.blade.php`
**Subject:** "Undangan Kolaborasi: [Judul] - Pasar Kolaboraya"

**Fitur:**
- Detail lengkap kolaborasi
- Informasi pengundang
- Benefit dari bergabung kolaborasi
- Button aksi (terima/tolak)
- Reminder expiry time

### 3. Email Update Status Kolaborasi
**File:** `resources/views/emails/collaboration/status-update.blade.php`
**Subject:** "Update Status Kolaborasi: [Judul] - Pasar Kolaboraya"

**Fitur:**
- Status update (diterima/ditolak)
- Informasi member yang merespon
- Motivasi dan next steps
- Button untuk lihat detail kolaborasi

### 4. Email Reset Password
**File:** `resources/views/emails/auth/reset-password.blade.php`
**Subject:** "Reset Password - Pasar Kolaboraya"

**Fitur:**
- Security-focused design
- Step-by-step guide reset password
- Tips password yang aman
- Warning keamanan
- Button reset password

### 5. Email Welcome
**File:** `resources/views/emails/general/welcome.blade.php`
**Subject:** "Selamat Datang di Pasar Kolaboraya! 🎉"

**Fitur:**
- Welcome message yang menarik
- Overview fitur platform
- Step-by-step guide untuk member baru
- Highlight fitur unggulan
- Multiple CTA buttons

### 6. Email Notifikasi Event
**File:** `resources/views/emails/events/event-notification.blade.php`
**Subject:** "Event Baru: [Judul] - Pasar Kolaboraya"

**Fitur:**
- Detail lengkap event
- Alasan event menarik untuk user
- Multiple action buttons
- Info kuota dan deadline
- Suggestion event serupa

### 7. Email Notifikasi Koneksi Baru
**File:** `resources/views/emails/connections/new-connection.blade.php`
**Subject:** "Koneksi Baru: [Nama] - Pasar Kolaboraya"

**Fitur:**
- Info profil koneksi baru
- Skill yang dimiliki
- Benefit dari koneksi
- Tips membangun koneksi kuat
- Action buttons untuk engagement

## 🔧 Notification Classes

### Class yang Sudah Diupdate:
1. **CollaborationInvitation** - Menggunakan template `invitation.blade.php`
2. **CollaborationStatusUpdate** - Menggunakan template `status-update.blade.php`
3. **CustomVerifyEmail** - Menggunakan template `verify-email-new.blade.php`

### Class Baru yang Dibuat:
1. **WelcomeEmail** - Untuk email welcome member baru
2. **EventNotification** - Untuk notifikasi event baru
3. **NewConnectionNotification** - Untuk notifikasi koneksi baru

## 🎯 Cara Penggunaan

### 1. Menggunakan Template Email
```php
use App\Notifications\CollaborationInvitation;

// Kirim notifikasi
$user->notify(new CollaborationInvitation($collaboration, $inviter));
```

### 2. Custom Template
```php
use Illuminate\Notifications\Messages\MailMessage;

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Subject Email')
        ->view('emails.custom.template', [
            'data' => $this->data,
        ]);
}
```

### 3. Extend Base Layout
```blade
@extends('emails.layouts.base')

@section('title', 'Judul Email')

@section('content')
    <!-- Konten email Anda -->
@endsection
```

## 🎨 Customization

### 1. Warna
- **Primary:** `#667eea` (Ungu)
- **Secondary:** `#764ba2` (Ungu gelap)
- **Success:** `#22543d` (Hijau)
- **Warning:** `#c53030` (Merah)
- **Info:** `#2d3748` (Abu gelap)

### 2. Typography
- **Font Family:** Segoe UI, Tahoma, Geneva, Verdana, sans-serif
- **Heading:** 24px, 600 weight
- **Body:** 16px, 400 weight
- **Small:** 14px, 400 weight

### 3. Spacing
- **Container:** max-width 600px
- **Padding:** 40px 30px (content), 40px 20px (header)
- **Margin:** 20px, 25px, 30px untuk spacing elements

## 📱 Responsive Design

### Breakpoints:
- **Desktop:** > 600px (default)
- **Mobile:** ≤ 600px

### Mobile Optimizations:
- Full-width container
- Reduced padding
- Single column info grid
- Smaller font sizes
- Touch-friendly buttons

## 🔒 Security & Best Practices

1. **No Sensitive Data:** Template tidak menampilkan data sensitif
2. **HTTPS Links:** Semua link menggunakan HTTPS
3. **Unsubscribe:** Footer dengan informasi kontak
4. **Spam Prevention:** Disclaimer "tidak membalas email ini"
5. **Rate Limiting:** Menggunakan queue untuk pengiriman

## 🚀 Fitur Lanjutan

### 1. Dynamic Content
- Conditional rendering dengan `@if`
- Looping dengan `@foreach`
- Variable interpolation
- Carbon date formatting

### 2. Interactive Elements
- Primary buttons dengan hover effects
- Secondary buttons dengan multiple styles
- Info grids yang responsive
- Highlight boxes untuk emphasis

### 3. Accessibility
- High contrast colors
- Semantic HTML structure
- Alt text untuk emojis
- Keyboard navigation friendly

## 📋 Testing

### 1. Email Client Testing
- Gmail (Web & Mobile)
- Outlook (Web & Desktop)
- Apple Mail
- Thunderbird
- Mobile email apps

### 2. Browser Testing
- Chrome, Firefox, Safari, Edge
- Mobile browsers
- Email preview tools

### 3. Content Testing
- Long text handling
- Special characters
- Unicode emojis
- Link functionality

## 🔧 Maintenance

### 1. Regular Updates
- Test dengan email client baru
- Update color scheme jika diperlukan
- Optimize responsive design
- Monitor deliverability

### 2. Performance
- Optimize CSS inline
- Minimize image usage
- Efficient HTML structure
- Fast loading times

## 📞 Support

Untuk pertanyaan atau masalah dengan template email:
- **Email:** support@pasar-kolaboraya.com
- **Documentation:** Lihat file ini dan inline comments
- **Issues:** Buat issue di repository project

---

**Dibuat dengan ❤️ untuk Pasar Kolaboraya**
*Last Updated: {{ date('Y-m-d') }}*
