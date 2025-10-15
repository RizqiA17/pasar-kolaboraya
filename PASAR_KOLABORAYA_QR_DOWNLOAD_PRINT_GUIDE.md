# 📥 Panduan Download & Print QR Code Pasar Kolaboraya

**Tanggal:** 15 Oktober 2025  
**Status:** ✅ SIAP DIGUNAKAN

---

## 🎯 Fitur Download & Print QR Code

### **1. Download QR Code sebagai PNG**
- ✅ High resolution (800x800px) untuk kualitas print yang baik
- ✅ Format PNG dengan transparansi
- ✅ Filename otomatis dengan tanggal
- ✅ Langsung download tanpa preview

### **2. Print Poster QR Code**
- ✅ Layout poster A4 yang menarik
- ✅ QR code besar di tengah
- ✅ Instruksi cara scan
- ✅ Design gradient yang profesional
- ✅ Print-friendly CSS

---

## 📍 Lokasi Tombol Download & Print

### **A. Halaman Admin Pasar Kolaboraya**
**URL:** `/admin/pasar-kolaboraya`

**Tombol yang tersedia:**
- 🔵 **QR Registrasi** - Buka halaman QR code
- 📥 **Download QR** - Download PNG langsung
- 🖨️ **Print Poster** - Buka halaman print poster
- 📷 **Buka Scanner** - Scanner untuk admin

### **B. Halaman Kelola User**
**URL:** `/admin/pasar-kolaboraya/{id}/users`

**Tombol yang tersedia:**
- 🔵 **QR Registrasi** - Buka halaman QR code
- 📥 **Download QR** - Download PNG langsung
- 🖨️ **Print Poster** - Buka halaman print poster

### **C. Halaman QR Code**
**URL:** `/pasar-kolaboraya/qr/{nama-pasar}`

**Tombol yang tersedia:**
- 📥 **Download PNG** - Download QR code sebagai PNG
- 🖨️ **Print Poster** - Buka halaman print poster

---

## 📥 Cara Download QR Code

### **Metode 1: Dari Admin Panel**
1. Login sebagai admin
2. Buka `/admin/pasar-kolaboraya`
3. Cari Pasar Kolaboraya yang aktif
4. Klik tombol **"Download QR"**
5. File PNG akan langsung terdownload

### **Metode 2: Dari Halaman QR**
1. Buka `/pasar-kolaboraya/qr/{nama-pasar}`
2. Klik tombol **"📥 Download PNG"**
3. File PNG akan langsung terdownload

### **Format File Download:**
```
Filename: QR-Registrasi-{Nama-Pasar}-{Tanggal}.png
Contoh: QR-Registrasi-Event-2025-2025-10-15.png
```

---

## 🖨️ Cara Print Poster

### **Metode 1: Dari Admin Panel**
1. Login sebagai admin
2. Buka `/admin/pasar-kolaboraya`
3. Cari Pasar Kolaboraya yang aktif
4. Klik tombol **"Print Poster"**
5. Halaman print akan terbuka
6. Klik **"🖨️ Print Poster"** di halaman
7. Pilih printer dan print

### **Metode 2: Dari Halaman QR**
1. Buka `/pasar-kolaboraya/qr/{nama-pasar}`
2. Klik tombol **"🖨️ Print Poster"**
3. Halaman print akan terbuka
4. Klik **"🖨️ Print Poster"** di halaman
5. Pilih printer dan print

### **Auto Print:**
Tambahkan `?autoprint=1` di URL untuk auto print:
```
/pasar-kolaboraya/qr-printable/{nama-pasar}?autoprint=1
```

---

## 🎨 Design Poster

### **Layout A4 (21cm x 29.7cm):**
- **Background:** Gradient biru-ungu yang menarik
- **Header:** Nama Pasar Kolaboraya dengan font besar
- **QR Code:** 600x600px di tengah dengan background putih
- **Instruksi:** 4 langkah cara scan QR code
- **Footer:** Tanggal generate dan branding

### **Warna & Style:**
- **Background:** Linear gradient (135deg, #667eea → #764ba2)
- **Text:** Putih dengan opacity untuk hierarchy
- **QR Code:** Background putih dengan shadow
- **Buttons:** Rounded dengan backdrop blur

### **Responsive:**
- ✅ Mobile-friendly
- ✅ Print-optimized CSS
- ✅ Dark mode support
- ✅ Touch-friendly controls

---

## 📱 Fitur Halaman Print

### **Print Controls (No Print):**
- 🖨️ **Print Poster** - Trigger print dialog
- 📥 **Download PNG** - Download QR code PNG
- ← **Kembali ke QR** - Kembali ke halaman QR

### **Print-Only Elements:**
- Poster content akan tampil saat print
- Controls disembunyikan saat print
- Layout A4 otomatis saat print

### **Auto Print:**
- URL dengan `?autoprint=1` akan auto print setelah 1 detik
- Berguna untuk batch printing
- Bisa dibuka di tab baru untuk print otomatis

---

## 🔧 Technical Details

### **Download QR Code:**
```php
// Controller method
public function downloadQr($slug = null)
{
    $qrCode = QrCode::size(800)
        ->format('png')
        ->margin(2)
        ->generate($registrationUrl);
    
    return response($qrCode)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
}
```

### **Print Poster:**
```php
// Controller method
public function showPrintableQr($slug = null)
{
    $qrCode = QrCode::size(600)
        ->format('svg')
        ->margin(2)
        ->generate($registrationUrl);
    
    return view('pasar-kolaboraya.printable-qr', [
        'pasarKolaboraya' => $pasarKolaboraya,
        'qrCode' => $qrCode,
    ]);
}
```

### **Routes:**
```php
// Download QR
Route::get('pasar-kolaboraya/qr-download/{slug?}', [PasarKolaborayaQrController::class, 'downloadQr'])
    ->name('pasar-kolaboraya.qr.download');

// Print Poster
Route::get('pasar-kolaboraya/qr-printable/{slug?}', [PasarKolaborayaQrController::class, 'showPrintableQr'])
    ->name('pasar-kolaboraya.qr.printable');
```

---

## 📋 Use Cases

### **1. Event On-Site Registration**
- Download QR code untuk print di banner
- Print poster untuk ditempel di dinding
- Share link untuk registrasi online

### **2. Marketing Materials**
- QR code untuk flyer
- Poster untuk booth event
- Sticker untuk meja registrasi

### **3. Digital Sharing**
- Share link QR code via WhatsApp
- Embed di website event
- Post di social media

---

## 🎯 Best Practices

### **Untuk Print:**
- ✅ Gunakan kertas A4 untuk hasil terbaik
- ✅ Print dengan kualitas tinggi (300 DPI)
- ✅ Pastikan QR code tidak terpotong
- ✅ Test scan sebelum print banyak

### **Untuk Digital:**
- ✅ Download PNG untuk kualitas terbaik
- ✅ Share link untuk kemudahan akses
- ✅ Test di berbagai device

### **Untuk Event:**
- ✅ Print beberapa poster sebagai backup
- ✅ Siapkan link alternatif jika QR tidak bisa di-scan
- ✅ Test registrasi sebelum event dimulai

---

## 🚀 Deployment

### **File yang Ditambahkan:**
1. `app/Http/Controllers/PasarKolaborayaQrController.php` (updated)
2. `resources/views/pasar-kolaboraya/printable-qr.blade.php` (new)
3. `resources/views/pasar-kolaboraya/qr-registration.blade.php` (updated)
4. `resources/views/livewire/admin/pasar-kolaboraya-management.blade.php` (updated)
5. `resources/views/livewire/admin/manage-pasar-kolaboraya-users.blade.php` (updated)
6. `routes/web.php` (updated)

### **Dependencies:**
- ✅ SimpleSoftwareIO/QrCode package (sudah ada)
- ✅ Laravel Response headers
- ✅ CSS Print media queries

---

## 🎉 Kesimpulan

Sistem download dan print QR code sudah siap dengan fitur:

- ✅ **Download PNG** - High resolution untuk print
- ✅ **Print Poster** - Layout A4 yang menarik
- ✅ **Auto Print** - Untuk batch printing
- ✅ **Mobile Responsive** - Bisa diakses dari mobile
- ✅ **Admin Integration** - Tombol di admin panel
- ✅ **Professional Design** - Gradient dan typography yang menarik

Admin bisa dengan mudah download QR code untuk print atau membuat poster yang menarik untuk event!
