# Fitur Export Data User Pasar Kolaboraya

## 📋 Ringkasan

Fitur export data user dari Pasar Kolaboraya memungkinkan admin untuk mengunduh data pengguna yang terdaftar dalam sebuah sesi Pasar Kolaboraya dalam format **CSV** dan **SQL**. Fitur ini dirancang untuk backup data dan memudahkan import data ke aplikasi on-site local ketika API public users tidak dapat diakses.

## 🎯 Tujuan

- **Backup Data**: Menyediakan backup data user yang terdaftar di Pasar Kolaboraya
- **Import ke Aplikasi Local**: Memudahkan transfer data ke aplikasi on-site local
- **Data Portability**: Memberikan fleksibilitas dalam pengelolaan data
- **Offline Access**: Memastikan data tetap tersedia meskipun koneksi API terputus

## ✨ Fitur Utama

### 1. Export ke Format CSV
- **Format**: CSV dengan encoding UTF-8 (Excel compatible)
- **Isi Data**: Informasi lengkap user termasuk profil dan relasi dengan Pasar Kolaboraya
- **Penggunaan**: Untuk analisis data, import ke spreadsheet, atau database sederhana

### 2. Export ke Format SQL
- **Format**: SQL INSERT statements
- **Isi Data**: User data dan relasi Pasar Kolaboraya dengan sintaks SQL yang siap dijalankan
- **Penggunaan**: Import langsung ke database MySQL/MariaDB aplikasi on-site local

## 🔧 Implementasi Teknis

### File yang Dibuat/Dimodifikasi

1. **Controller**: `app/Http/Controllers/Admin/PasarKolaborayaExportController.php`
   - Method `exportCsv()`: Handle export CSV
   - Method `exportSql()`: Handle export SQL
   - Streaming response untuk optimasi memory

2. **Routes**: `routes/web.php`
   ```php
   Route::get('/pasar-kolaboraya/{pasarKolaboraya}/export-csv', [PasarKolaborayaExportController::class, 'exportCsv'])
       ->name('pasar-kolaboraya.export-csv');
   Route::get('/pasar-kolaboraya/{pasarKolaboraya}/export-sql', [PasarKolaborayaExportController::class, 'exportSql'])
       ->name('pasar-kolaboraya.export-sql');
   ```

3. **View**: `resources/views/livewire/admin/pasar-kolaboraya-management.blade.php`
   - Tombol "Export CSV" dan "Export SQL" untuk setiap Pasar Kolaboraya

### Optimisasi

#### 1. Streaming Response
```php
return new StreamedResponse(function () use ($pasarKolaboraya) {
    // Data diproses dan dikirim secara streaming
}, 200, $headers);
```

**Keuntungan**:
- Memory efficient: Data tidak dimuat sekaligus ke memory
- Dapat handle dataset besar tanpa timeout
- Response langsung dikirim ke client

#### 2. Chunk Processing
```php
$pasarKolaboraya->users()
    ->chunk(100, function ($users) use ($handle) {
        // Proses 100 user per batch
    });
```

**Keuntungan**:
- Menghindari memory overflow
- Proses data dalam batch kecil
- Performa stabil untuk dataset besar

#### 3. Query Optimization
```php
$pasarKolaboraya->users()
    ->wherePivot('status', 'accepted')
    ->select([...]) // Select only needed columns
    ->chunk(100, ...);
```

**Keuntungan**:
- Hanya mengambil data yang diperlukan
- Filter di database level (lebih cepat)
- Mengurangi data transfer

#### 4. Eager Loading
```php
$pasarKolaboraya->users()->with(['pivot'])
```

**Keuntungan**:
- Menghindari N+1 query problem
- Relasi dimuat sekaligus
- Query database lebih efisien

## 📊 Struktur Data Export

### CSV Export

**Header Columns**:
| Column | Description |
|--------|-------------|
| ID | User ID |
| Name | Nama lengkap user |
| Email | Email address |
| Gender | Jenis kelamin |
| Phone Number | Nomor telepon |
| Organization Type | Tipe organisasi |
| Organization Name | Nama organisasi |
| Role | Role di sistem |
| User Type | Tipe user |
| Status | Status di Pasar Kolaboraya |
| Pasar Kolaboraya Role | Role di Pasar Kolaboraya (admin/member) |
| Join Reason | Alasan bergabung |
| Joined At | Tanggal bergabung |
| Email Verified | Status verifikasi email |
| Approval Status | Status approval user |
| Created At | Tanggal registrasi |

**Contoh Output**:
```csv
ID,Name,Email,Gender,Phone Number,...
1,John Doe,john@example.com,male,08123456789,...
2,Jane Smith,jane@example.com,female,08198765432,...
```

### SQL Export

**Struktur**:
1. **Header Comments**: Informasi export (nama Pasar Kolaboraya, tanggal, jumlah user)
2. **Transaction Start**: `START TRANSACTION;`
3. **Foreign Key Disable**: `SET FOREIGN_KEY_CHECKS=0;`
4. **Users Insert**: INSERT statements untuk tabel `users` dengan ON DUPLICATE KEY UPDATE
5. **Relationship Insert**: INSERT statements untuk tabel `pasar_kolaboraya_users`
6. **Foreign Key Enable**: `SET FOREIGN_KEY_CHECKS=1;`
7. **Transaction Commit**: `COMMIT;`

**Contoh Output**:
```sql
-- Pasar Kolaboraya Users Data Export
-- Pasar Kolaboraya: Pasar Testing
-- Export Date: 2025-10-28 15:30:45
-- Total Users: 25

START TRANSACTION;
SET FOREIGN_KEY_CHECKS=0;

-- Insert Users
INSERT INTO `users` (...) VALUES (...) ON DUPLICATE KEY UPDATE ...;

-- Insert Pasar Kolaboraya Relationships
INSERT INTO `pasar_kolaboraya_users` (...) VALUES (...) ON DUPLICATE KEY UPDATE ...;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
```

## 🚀 Cara Penggunaan

### Untuk Admin

1. **Akses Halaman Admin Pasar Kolaboraya**
   - Login sebagai Super Admin
   - Navigasi ke `/admin/pasar-kolaboraya`

2. **Pilih Pasar Kolaboraya**
   - Scroll ke Pasar Kolaboraya yang ingin di-export
   - Lihat daftar tombol aksi di sebelah kanan

3. **Export Data**
   - Klik tombol **"Export CSV"** untuk download format CSV
   - Klik tombol **"Export SQL"** untuk download format SQL
   - File akan otomatis terdownload dengan nama:
     - CSV: `pasar_kolaboraya_users_{id}_{timestamp}.csv`
     - SQL: `pasar_kolaboraya_users_{id}_{timestamp}.sql`

### Import ke Aplikasi On-Site Local

#### Import CSV
1. Buka file CSV di Excel/LibreOffice untuk review
2. Gunakan import wizard database atau script custom untuk import ke database
3. Mapping kolom sesuai dengan struktur database local

#### Import SQL
1. Buka terminal/command prompt
2. Login ke MySQL:
   ```bash
   mysql -u username -p database_name
   ```
3. Import file SQL:
   ```bash
   source /path/to/pasar_kolaboraya_users_1_20251028_153045.sql;
   ```
   
   Atau menggunakan command line:
   ```bash
   mysql -u username -p database_name < pasar_kolaboraya_users_1_20251028_153045.sql
   ```

4. Verifikasi data:
   ```sql
   SELECT COUNT(*) FROM users;
   SELECT COUNT(*) FROM pasar_kolaboraya_users;
   ```

## 🔒 Security

### Authorization
- **Akses Terbatas**: Hanya Super Admin yang dapat mengakses fitur export
- **Middleware Check**: Menggunakan `isSuperAdmin()` check di controller
- **Route Protection**: Routes berada dalam `admin` middleware group

### Data Protection
- **HTTPS**: Pastikan menggunakan HTTPS untuk download data sensitif
- **Audit Log**: Pertimbangkan untuk menambahkan logging aktivitas export
- **Data Sensitivity**: Data password di-export dalam bentuk hash (aman)

### SQL Injection Prevention
- **Escape Function**: Semua data di-escape sebelum dimasukkan ke SQL statement
- **Prepared Values**: Menggunakan proper escaping untuk special characters
- **Parameterization**: Data tidak langsung di-concat ke query string

## 📈 Performance

### Benchmark (Estimasi)

| Jumlah User | CSV Export Time | SQL Export Time | Memory Usage |
|-------------|----------------|----------------|--------------|
| 100 users   | ~1 second      | ~1.5 seconds   | ~5 MB        |
| 1,000 users | ~5 seconds     | ~8 seconds     | ~10 MB       |
| 10,000 users| ~30 seconds    | ~45 seconds    | ~20 MB       |

**Note**: Waktu dapat bervariasi tergantung server specs dan network speed

### Tips Optimasi Lebih Lanjut

1. **Gunakan Queue untuk Dataset Besar**
   ```php
   // Jika > 10,000 users, pertimbangkan queue
   ExportPasarKolaborayaJob::dispatch($pasarKolaboraya, $format);
   ```

2. **Add Caching untuk Frequent Exports**
   ```php
   Cache::remember("pasar_{$id}_export", 3600, function() {
       return $this->generateExport();
   });
   ```

3. **Compress Large Files**
   ```php
   // Add gzip compression untuk file besar
   response()->download($file)->withHeaders([
       'Content-Encoding' => 'gzip'
   ]);
   ```

## 🐛 Troubleshooting

### Error: "Memory limit exceeded"
**Solusi**:
- Increase PHP memory limit di `php.ini`: `memory_limit = 512M`
- Atau gunakan chunking dengan size lebih kecil

### Error: "Maximum execution time exceeded"
**Solusi**:
- Increase max execution time: `max_execution_time = 300`
- Atau gunakan queue untuk export besar

### CSV tidak terbuka dengan benar di Excel
**Solusi**:
- File sudah menggunakan UTF-8 BOM untuk kompatibilitas Excel
- Jika masih issue, buka dengan "Import Data" di Excel

### SQL Import Error: "Duplicate entry"
**Solusi**:
- SQL menggunakan `ON DUPLICATE KEY UPDATE`, seharusnya tidak error
- Jika masih error, check constraint di database local

## 📝 Future Enhancements

### Rencana Pengembangan

1. **Export Format Tambahan**
   - JSON export
   - XML export
   - Excel (.xlsx) native format

2. **Filter & Customize Export**
   - Pilih kolom yang ingin di-export
   - Filter by date range
   - Export by user status

3. **Schedule Export**
   - Automated daily/weekly export
   - Email notification dengan attachment
   - Cloud backup integration

4. **Batch Export**
   - Export multiple Pasar Kolaboraya sekaligus
   - Export all Pasar Kolaboraya dalam satu file

5. **Import Feature**
   - Upload CSV/SQL untuk bulk import users
   - Validation & preview before import
   - Rollback mechanism

## 📞 Support

Jika ada pertanyaan atau issue terkait fitur export:
1. Check dokumentasi ini terlebih dahulu
2. Review error logs di `storage/logs/laravel.log`
3. Contact development team untuk support lebih lanjut

---

**Last Updated**: 28 Oktober 2025  
**Version**: 1.0.0  
**Author**: Development Team

