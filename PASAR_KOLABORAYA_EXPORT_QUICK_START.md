# Quick Start: Export Data User Pasar Kolaboraya

## 🚀 Cara Cepat Menggunakan Fitur Export

### Untuk Admin

#### 1. Akses Halaman Pasar Kolaboraya
```
URL: /admin/pasar-kolaboraya
Login sebagai: Super Admin
```

#### 2. Pilih Pasar Kolaboraya
Scroll ke card Pasar Kolaboraya yang ingin di-export datanya.

#### 3. Klik Tombol Export
- **Export CSV**: Untuk format spreadsheet (Excel, Google Sheets, dll)
- **Export SQL**: Untuk import langsung ke database MySQL/MariaDB

#### 4. File Akan Terdownload Otomatis
Format nama file:
- CSV: `pasar_kolaboraya_users_1_20251028_153045.csv`
- SQL: `pasar_kolaboraya_users_1_20251028_153045.sql`

---

## 📥 Import ke Aplikasi On-Site Local

### Import CSV

**Option 1: Via Excel/Google Sheets**
1. Buka file CSV di Excel
2. Review data
3. Export ke format lain jika diperlukan

**Option 2: Via MySQL Import Wizard**
```sql
LOAD DATA LOCAL INFILE '/path/to/file.csv'
INTO TABLE users
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

### Import SQL

**Via Command Line (Recommended)**
```bash
mysql -u username -p database_name < pasar_kolaboraya_users_1_20251028.sql
```

**Via MySQL Shell**
```sql
mysql -u username -p
USE database_name;
source /path/to/pasar_kolaboraya_users_1_20251028.sql;
```

**Via phpMyAdmin**
1. Login ke phpMyAdmin
2. Pilih database
3. Tab "Import"
4. Choose file & klik "Go"

---

## 📊 Isi Data Export

### CSV Export
16 kolom data user dan relationship dengan Pasar Kolaboraya:
- User Profile: ID, Name, Email, Gender, Phone, Organization
- System Data: Role, User Type, Status, Approval
- Pasar Kolaboraya: PK Role, Join Reason, Joined Date
- Timestamps: Email Verified, Created At

### SQL Export
2 tables:
1. **users**: Complete user profile data
2. **pasar_kolaboraya_users**: Relationship/pivot data

SQL file include:
- Transaction wrapper (safe import)
- Foreign key handling
- ON DUPLICATE KEY UPDATE (no duplicate errors)
- Metadata comments

---

## ⚠️ Perhatian

1. **Authorization**: Hanya Super Admin yang bisa export data
2. **Data Sensitivity**: File berisi data user (handle dengan hati-hati)
3. **Large Dataset**: Export > 10,000 users mungkin memerlukan beberapa menit
4. **SQL Import**: Pastikan database structure sudah sesuai sebelum import
5. **Backup**: Backup database sebelum import SQL untuk safety

---

## 🐛 Troubleshooting

### Problem: Export button tidak muncul
**Solution**: Pastikan Anda login sebagai Super Admin

### Problem: Download gagal / timeout
**Solution**: Dataset terlalu besar, gunakan pagination atau filter

### Problem: CSV tidak terbuka dengan benar di Excel
**Solution**: 
- File sudah UTF-8 BOM compatible
- Coba: File > Import Data > Browse file di Excel

### Problem: SQL import error "Duplicate entry"
**Solution**: 
- SQL menggunakan ON DUPLICATE KEY UPDATE (seharusnya tidak error)
- Check primary key constraints di database

### Problem: SQL import error "Foreign key constraint"
**Solution**:
- SQL sudah disable FK checks
- Pastikan menjalankan full SQL file (bukan sebagian)

---

## 💡 Tips

1. **Regular Backup**: Export data secara berkala untuk backup
2. **Test Import**: Test import di database development terlebih dahulu
3. **Data Review**: Review CSV di Excel sebelum import ke sistem
4. **Documentation**: Simpan file export dengan naming yang jelas
5. **Version Control**: Gunakan timestamp di filename untuk tracking

---

## 📞 Support

Jika mengalami masalah:
1. Check `storage/logs/laravel.log` untuk error details
2. Verifikasi authorization (Super Admin)
3. Check server resources (memory, timeout limits)
4. Contact development team jika issue persist

---

**Last Updated**: 28 Oktober 2025  
**Feature Version**: 1.0.0

