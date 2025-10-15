# 📱 Panduan Penggunaan QR Code Registrasi Pasar Kolaboraya

**Tanggal:** 15 Oktober 2025  
**Status:** ✅ SIAP DIGUNAKAN

---

## 🎯 Cara Menampilkan QR Code

### **1. Dari Admin Panel**

#### **A. Halaman Manajemen Pasar Kolaboraya**
1. Login sebagai admin
2. Buka `/admin/pasar-kolaboraya`
3. Cari Pasar Kolaboraya yang **status = Aktif**
4. Klik tombol **"QR Registrasi"** (ikon QR code biru)
5. QR code akan terbuka di halaman baru

#### **B. Halaman Kelola User**
1. Login sebagai admin
2. Buka `/admin/pasar-kolaboraya/{id}/users`
3. Klik tombol **"QR Registrasi"** di header
4. QR code akan terbuka di halaman baru

### **2. Akses Langsung URL**
```
URL: /pasar-kolaboraya/qr
atau: /pasar-kolaboraya/qr/{nama-pasar}
```

---

## 📱 Tampilan QR Code

### **Header:**
- Nama Pasar Kolaboraya
- Deskripsi "Scan QR Code untuk mendaftar langsung"

### **QR Code:**
- QR code besar di tengah halaman
- Background putih dengan border
- Responsive untuk mobile

### **Link Registrasi:**
- Input field dengan link registrasi
- Tombol "Copy" untuk menyalin link
- Feedback "Copied!" saat berhasil

### **Instruksi:**
- Cara scan QR code
- Cara buka link manual
- Langkah-langkah registrasi

---

## 🔗 Link yang Dihasilkan

### **Format URL:**
```
https://yourdomain.com/register/pasar-kolaboraya/{nama-pasar}
```

### **Contoh:**
```
https://pasar-kolaboraya.com/register/pasar-kolaboraya/event-2025
```

---

## 👥 Cara Penggunaan untuk Peserta

### **Metode 1: Scan QR Code**
1. Buka kamera smartphone
2. Arahkan ke QR code
3. Klik notifikasi yang muncul
4. Browser akan membuka halaman registrasi

### **Metode 2: Link Manual**
1. Salin link dari halaman QR code
2. Buka browser
3. Paste link di address bar
4. Tekan Enter

### **Metode 3: Share Link**
1. Admin copy link
2. Share via WhatsApp/Telegram/Email
3. Peserta klik link
4. Langsung ke halaman registrasi

---

## 📋 Form Registrasi Event

### **Field yang Ditampilkan:**
- ✅ **Nama Lengkap** (wajib)
- ✅ **Email** (wajib, unik)
- ✅ **Jenis Kelamin** (wajib)
- ✅ **Nomor Telepon** (wajib)
- ✅ **Password** (wajib)
- ✅ **Konfirmasi Password** (wajib)

### **Field yang TIDAK Ditampilkan:**
- ❌ Kode Registrasi
- ❌ Tipe Organisasi (otomatis: komunitas)
- ❌ Nama Organisasi (otomatis: Pasar Kolaboraya)

---

## ⚙️ Konfigurasi Admin

### **Syarat Pasar Kolaboraya:**
- Status harus **"Aktif"**
- Tombol QR Registrasi hanya muncul untuk status aktif
- Jika tidak aktif, tombol tidak akan muncul

### **Pengaturan Sistem:**
- Registrasi harus diaktifkan di System Settings
- Jika dinonaktifkan, akan muncul pesan error

---

## 🎨 Customization

### **QR Code Size:**
- Default: 300x300px
- Responsive untuk mobile
- Background putih dengan shadow

### **Link Format:**
- Menggunakan nama Pasar Kolaboraya sebagai slug
- URL-friendly (spasi diganti dengan dash)
- Case insensitive

---

## 🔒 Keamanan

### **Validasi:**
- ✅ Pasar Kolaboraya harus aktif
- ✅ Registrasi harus diaktifkan
- ✅ Email unik di sistem
- ✅ Format email valid

### **Error Handling:**
- Pasar Kolaboraya tidak ditemukan
- Registrasi dinonaktifkan
- Email sudah terdaftar
- Validasi form gagal

---

## 📱 Mobile Responsive

### **QR Code Page:**
- ✅ Responsive layout
- ✅ Touch-friendly buttons
- ✅ Mobile-optimized QR code
- ✅ Dark mode support

### **Registration Form:**
- ✅ Mobile-friendly form
- ✅ Touch-friendly inputs
- ✅ Responsive buttons
- ✅ Dark mode support

---

## 🧪 Testing

### **Test Cases:**
1. ✅ QR code generate dengan benar
2. ✅ Link mengarah ke form registrasi
3. ✅ Form tanpa kode registrasi
4. ✅ User otomatis join Pasar Kolaboraya
5. ✅ Email verifikasi dikirim
6. ✅ Error handling berbagai skenario

---

## 🚀 Deployment

### **File yang Perlu Di-deploy:**
1. `app/Livewire/Auth/RegisterPasarKolaboraya.php`
2. `resources/views/livewire/auth/register-pasar-kolaboraya.blade.php`
3. `app/Http/Controllers/PasarKolaborayaQrController.php`
4. `resources/views/pasar-kolaboraya/qr-registration.blade.php`
5. `routes/auth.php` (updated)
6. `routes/web.php` (updated)
7. `resources/views/livewire/admin/pasar-kolaboraya-management.blade.php` (updated)
8. `resources/views/livewire/admin/manage-pasar-kolaboraya-users.blade.php` (updated)

### **Route yang Ditambahkan:**
- `GET /register/pasar-kolaboraya/{slug?}` - Form registrasi
- `GET /pasar-kolaboraya/qr/{slug?}` - QR code page
- `GET /pasar-kolaboraya/qr-data/{slug?}` - API data

---

## 📞 Support

### **Jika QR Code Tidak Muncul:**
1. Pastikan Pasar Kolaboraya status = "Aktif"
2. Pastikan registrasi diaktifkan di System Settings
3. Cek console browser untuk error
4. Pastikan route sudah terdaftar

### **Jika Link Tidak Bekerja:**
1. Pastikan URL format benar
2. Cek apakah Pasar Kolaboraya masih aktif
3. Pastikan registrasi tidak dinonaktifkan
4. Cek log aplikasi untuk error

---

## 🎉 Kesimpulan

Sistem QR code registrasi Pasar Kolaboraya sudah siap digunakan dengan fitur:

- ✅ **Tombol QR Registrasi** di admin panel
- ✅ **QR Code Static** yang bisa di-scan
- ✅ **Link Copy-paste** untuk sharing
- ✅ **Form Registrasi Event** tanpa kode registrasi
- ✅ **Auto-join** ke Pasar Kolaboraya
- ✅ **Mobile Responsive** untuk semua device
- ✅ **Error Handling** yang komprehensif

Admin bisa dengan mudah menampilkan QR code untuk peserta event, dan peserta bisa mendaftar langsung tanpa kode registrasi!
