# Survey Chart Troubleshooting Guide

## Masalah: Chart pada hasil survey tidak muncul

### Penyebab Umum dan Solusi:

#### 1. **Chart.js tidak dimuat**
**Gejala**: Canvas kosong, tidak ada error di console
**Solusi**: 
- Pastikan Chart.js CDN dimuat dengan benar
- Cek network tab di browser developer tools
- URL yang digunakan: `https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js`

#### 2. **Canvas element tidak ditemukan**
**Gejala**: Error "Canvas element not found" di console
**Solusi**:
- Pastikan canvas dengan id `radarChart` ada di DOM
- Pastikan tab "Radar Chart" aktif saat script dijalankan
- Tambahkan delay untuk memastikan Livewire selesai render

#### 3. **Data tidak tersedia**
**Gejala**: Chart kosong atau error saat render
**Solusi**:
- Pastikan ada data survey response
- Cek apakah `$totalResponses > 0`
- Pastikan data radar chart valid

#### 4. **Livewire re-render issue**
**Gejala**: Chart hilang saat switch tab
**Solusi**:
- Gunakan `window.radarChartInstance` untuk destroy chart lama
- Tambahkan event listener untuk Livewire update

### Kode yang Sudah Diperbaiki:

```javascript
// Script chart yang sudah diperbaiki
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const canvas = document.getElementById('radarChart');
        if (!canvas) {
            console.error('Canvas element not found');
            return;
        }
        
        const ctx = canvas.getContext('2d');
        const radarData = @json($radarData);
        
        // Destroy existing chart if it exists
        if (window.radarChartInstance) {
            window.radarChartInstance.destroy();
        }

        window.radarChartInstance = new Chart(ctx, {
            // ... chart configuration
        });
    }, 100);
});
```

### Testing Steps:

1. **Login sebagai admin**: `admin@pasar-kolaboraya.com` / `admin123`
2. **Buat survey**: Admin > Survey > Buat Survey Baru
3. **Aktifkan survey**: Klik tombol "Aktifkan"
4. **Buat data sample**: 
   ```bash
   php artisan tinker
   # Jalankan script untuk membuat survey responses
   ```
5. **Lihat hasil**: Admin > Survey > Klik "Hasil" pada survey
6. **Test chart**: Klik tab "Radar Chart"

### Debugging Tips:

1. **Buka Developer Tools** (F12)
2. **Cek Console** untuk error messages
3. **Cek Network tab** untuk memastikan Chart.js dimuat
4. **Cek Elements tab** untuk memastikan canvas ada
5. **Test dengan data sample** yang sudah dibuat

### Data Sample yang Tersedia:

Data sample survey response sudah dibuat dengan:
- 3 user responses
- Data lengkap untuk semua kategori
- Rata-rata yang dapat divisualisasikan

### Status Perbaikan:

✅ **Chart.js CDN** - Sudah diperbaiki dengan versi yang stabil
✅ **Canvas sizing** - Sudah diperbaiki dengan height yang tepat
✅ **Livewire compatibility** - Sudah ditambahkan delay dan destroy logic
✅ **Data validation** - Sudah ditambahkan error handling
✅ **Sample data** - Sudah dibuat untuk testing

Chart seharusnya sudah berfungsi dengan baik sekarang!
