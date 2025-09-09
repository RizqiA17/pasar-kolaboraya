# Panduan Penggunaan Fitur Auto-Join dan Persetujuan Aksi Kolektif

## Fitur Baru yang Tersedia

### 1. 🏢 Pengaturan Auto-Join Ekosistem

#### Untuk Pemilik Ekosistem:

**Mengakses Pengaturan:**
1. Login ke akun Anda
2. Masuk ke dashboard ekosistem yang Anda miliki
3. Klik tombol "⚙️ Pengaturan" di bagian kanan atas
4. Anda akan melihat halaman pengaturan ekosistem

**Mengatur Auto-Join:**
- ✅ **Centang "Anggota Otomatis Bergabung ke Aksi Kolektif"** jika Anda ingin:
  - Semua anggota ekosistem otomatis bergabung saat ekosistem diundang ke aksi kolektif
  - Tidak ada proses persetujuan tambahan
  - Proses lebih cepat dan otomatis

- ❌ **Biarkan tidak tercentang** jika Anda ingin:
  - Anggota ekosistem memerlukan persetujuan admin aksi kolektif terlebih dahulu
  - Kontrol lebih ketat terhadap partisipasi
  - Admin aksi kolektif dapat memilih anggota yang sesuai

### 2. 👥 Sistem Persetujuan untuk User Non-Ekosistem

#### Untuk User yang Ingin Bergabung:

**Cara Bergabung:**
1. Buka halaman aksi kolektif yang ingin Anda ikuti
2. Klik tombol "Bergabung"
3. Isi form dengan lengkap:
   - Pilih role yang diinginkan (Anggota/Kontributor)
   - Tuliskan alasan bergabung minimal 10 karakter
   - Setujui syarat dan ketentuan
4. Klik "Bergabung"

**Hasil Bergabung:**
- 🟢 **Jika Anda anggota ekosistem dengan auto-join aktif**: Langsung bergabung
- 🟡 **Jika bukan anggota ekosistem atau auto-join nonaktif**: Menunggu persetujuan admin

#### Untuk Admin Aksi Kolektif:

**Mengelola Persetujuan:**
1. Masuk ke halaman "Member Management" aksi kolektif Anda
2. Klik tombol "⚠️ Persetujuan Anggota" (akan ada badge merah jika ada yang menunggu)
3. Review informasi setiap user yang meminta bergabung:
   - Nama dan profil user
   - Alasan bergabung
   - Role yang diminta
   - Informasi organisasi dan lokasi
4. Berikan catatan admin jika diperlukan
5. Klik "✅ Setujui" atau "❌ Tolak"

## Skenario Penggunaan

### Skenario 1: Ekosistem dengan Auto-Join Aktif
```
1. Admin ekosistem mengaktifkan auto-join
2. Ekosistem diundang ke aksi kolektif
3. Semua anggota ekosistem otomatis bergabung ke aksi kolektif
4. User non-ekosistem tetap perlu approval
```

### Skenario 2: Ekosistem dengan Auto-Join Nonaktif
```
1. Admin ekosistem tidak mengaktifkan auto-join
2. Ekosistem diundang ke aksi kolektif
3. Anggota ekosistem perlu menunggu approval admin aksi kolektif
4. User non-ekosistem juga perlu approval
```

### Skenario 3: User Individual Bergabung
```
1. User yang bukan anggota ekosistem mana pun
2. Mendaftar ke aksi kolektif
3. Selalu memerlukan approval admin aksi kolektif
4. Admin review dan approve/reject
```

## Status dan Notifikasi

### Status User di Aksi Kolektif:
- 🟢 **Aktif**: Sudah bergabung dan dapat berpartisipasi penuh
- 🟡 **Menunggu Persetujuan**: Permintaan sedang ditinjau admin
- 🔴 **Ditolak**: Permintaan ditolak oleh admin
- ⚪ **Nonaktif**: Dinonaktifkan oleh admin

### Notifikasi yang Akan Anda Terima:
- ✅ Pesan sukses saat berhasil bergabung langsung
- ⏳ Pesan informasi saat permintaan dikirim untuk review
- 📧 Email notifikasi saat permintaan disetujui/ditolak (akan diimplementasi)

## Tips Penggunaan

### Untuk Pemilik Ekosistem:
- Aktifkan auto-join jika anggota ekosistem Anda terpercaya dan selaras visi
- Nonaktifkan auto-join jika Anda ingin kontrol lebih ketat atau ekosistem besar
- Anda dapat mengubah pengaturan kapan saja

### Untuk Admin Aksi Kolektif:
- Review profil user sebelum menyetujui
- Berikan catatan yang jelas saat menolak permintaan
- Gunakan badge notifikasi untuk mengetahui permintaan baru

### Untuk User yang Ingin Bergabung:
- Tulis alasan bergabung yang jelas dan relevan
- Lengkapi profil Anda untuk meningkatkan peluang disetujui
- Bersabar menunggu review dari admin

## Troubleshooting

### Masalah Umum:

**Q: Saya tidak bisa mengakses pengaturan ekosistem**
A: Pastikan Anda adalah pemilik ekosistem. Hanya pemilik yang dapat mengubah pengaturan.

**Q: Permintaan bergabung saya tidak disetujui**
A: Hubungi admin aksi kolektif atau perbaiki profil Anda dan coba lagi.

**Q: Anggota ekosistem saya tidak otomatis bergabung**
A: Periksa pengaturan auto-join di pengaturan ekosistem dan pastikan sudah diaktifkan.

**Q: Saya tidak melihat tombol persetujuan anggota**
A: Pastikan Anda adalah admin aksi kolektif dan ada permintaan yang menunggu persetujuan.

## Fitur Selanjutnya

Fitur yang akan dikembangkan:
- 📧 Email notifikasi otomatis
- 📊 Dashboard analytics persetujuan
- 🔔 Push notifications real-time
- 📝 Template catatan admin
- 🎯 Auto-approval berdasarkan kriteria

---

**Catatan**: Jika mengalami masalah atau ada pertanyaan, silakan hubungi tim support atau buat issue di repository.
