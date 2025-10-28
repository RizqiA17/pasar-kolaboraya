# Instruksi Setup API - WAJIB DIBACA

> **PENTING:** Lakukan langkah-langkah berikut sebelum menggunakan API!

---

## Langkah Setup (Wajib)

### **Step 1: Generate API Key untuk Aplikasi Local** WAJIB

```bash
# Buka terminal di folder project
cd /path/to/pasar-kolaboraya

# Generate API Key untuk aplikasi local
php artisan api:generate-key --name="Local App" --show-secret
```

**Output akan seperti ini:**
```
API Key generated successfully!

Name: Local App
Key: pk_PqNzZJrneo430fx9LLNXaJk7JGaFvzey
Expires: 2026-10-28 08:12:57

IMPORTANT: Save this secret securely. It will not be shown again!

Secret:
Gu34dmvl52jkMAegiuhtaB1VgxshlGtYmv1FPdYpVkJfLZf55K6rpck0mzIcNBVb

Use these headers in your API requests:
X-API-Key: pk_PqNzZJrneo430fx9LLNXaJk7JGaFvzey
X-API-Secret: Gu34dmvl52jkMAegiuhtaB1VgxshlGtYmv1FPdYpVkJfLZf55K6rpck0mzIcNBVb
```

**SIMPAN API KEY DAN SECRET INI DENGAN AMAN!**  
Secret hanya ditampilkan SEKALI dan tidak bisa dilihat lagi.

---

### **Step 2: Test API** (Opsional tapi Direkomendasikan)

```bash
# Copy file contoh untuk aplikasi
cp examples/api-client-app.php test-api.php

# Edit file test-api.php:
# - Ganti pk_PqNzZJrneo430fx9LLNXaJk7JGaFvzey dengan API Key Anda
# - Ganti Gu34dmvl52jkMAegiuhtaB1VgxshlGtYmv1FPdYpVkJfLZf55K6rpck0mzIcNBVb dengan Secret Anda
# - Ganti yourdomain.com dengan domain Anda
# - Ganti PK_1_1698765432_abc123 dengan QR code user yang valid (jika ada)

# Jalankan test
php test-api.php
```

**Expected output:**
```
=== Example 1: Get User by QR Code ===
Status: 200
Response: {
    "status": "success",
    "data": { ... }
}
```

---

## Verifikasi Setup

### Check 1: Routes terdaftar
```bash
php artisan route:list --path=api
```

**Harus menampilkan 9 routes:**
- `api/v1/users` (Sanctum)
- `api/v1/users/qr` (Sanctum)
- `api/v1/users/{id}` (Sanctum)
- `api/v1/secure/users` (Sanctum + Signature)
- `api/v1/secure/users/qr` (Sanctum + Signature)
- `api/v1/secure/users/{id}` (Sanctum + Signature)
- `api/v1/app/users` (API Key) ⭐ **UNTUK APLIKASI LOCAL**
- `api/v1/app/users/qr` (API Key) ⭐ **UNTUK APLIKASI LOCAL**
- `api/v1/app/users/{id}` (API Key) ⭐ **UNTUK APLIKASI LOCAL**

### Check 2: API Key tersimpan
- ✅ API Key sudah di-copy dan disimpan dengan aman
- ✅ API Secret sudah di-copy dan disimpan dengan aman
- ✅ API Key ditest dan berfungsi

---

## Catatan Penting

### Keamanan API Key & Secret:

**DO **
- Simpan API Key dan Secret di password manager
- Gunakan environment variables di production
- Rotate API Key secara berkala (6-12 bulan)
- Revoke API Key jika bocor

**DON'T**
- Commit API Key/Secret ke Git
- Share API Key via email/chat tidak terenkripsi
- Hard-code API Key di source code
- Gunakan API Key yang sama untuk dev & production

---

## Langkah Selanjutnya

### Untuk Development:

1. **Baca dokumentasi:**
   - `README_API.md` - Overview
   - `PASAR_KOLABORAYA_API_QUICK_START.md` - Quick start guide
   - `PASAR_KOLABORAYA_API_IMPLEMENTATION.md` - Full documentation

2. **Gunakan contoh client:**
   - `examples/api-client-app.php` - Simple request dengan API Key ⭐ **UNTUK APLIKASI LOCAL**
   - `examples/api-client-app-class.php` - OOP class dengan API Key ⭐ **RECOMMENDED**
   - `examples/api-client-simple.php` - Simple request dengan Sanctum (untuk user)
   - `examples/api-client-secure.php` - Secure request dengan Sanctum + Signature

3. **Implementasi di aplikasi local:**
   ```php
   require_once 'examples/api-client-app-class.php';
   
   $client = new PasarKolaborayaAppApiClient(
       'http://yourdomain.com/api',
       'YOUR_API_KEY',
       'YOUR_API_SECRET'
   );
   
   $result = $client->getUserById(7);
   ```

### Untuk Production:

1. **Review checklist di:** `PASAR_KOLABORAYA_API_SUMMARY.md`
2. **Setup monitoring** untuk API usage
3. **Configure rate limiting** sesuai traffic
4. **Setup backup** untuk API Keys
5. **Document** internal API usage untuk tim

---

## Test Endpoints

### Test 1: Get User by ID (API Key)
```bash
curl -X GET \
  http://yourdomain.com/api/v1/app/users/7 \
  -H 'X-API-Key: YOUR_API_KEY' \
  -H 'X-API-Secret: YOUR_API_SECRET' \
  -H 'Accept: application/json'
```

### Test 2: Get Users List (API Key)
```bash
curl -X GET \
  'http://yourdomain.com/api/v1/app/users?per_page=5' \
  -H 'X-API-Key: YOUR_API_KEY' \
  -H 'X-API-Secret: YOUR_API_SECRET' \
  -H 'Accept: application/json'
```

### Test 3: Get User by QR (API Key)
```bash
curl -X POST \
  http://yourdomain.com/api/v1/app/users/qr \
  -H 'X-API-Key: YOUR_API_KEY' \
  -H 'X-API-Secret: YOUR_API_SECRET' \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -d '{"qr_code":"PK_7_1698765432_abc123"}'
```

---

## Troubleshooting

### Problem: "API Key and Secret required" error

**Solusi:**
```bash
# Pastikan header dikirim dengan benar:
# X-API-Key: YOUR_API_KEY
# X-API-Secret: YOUR_API_SECRET
```

### Problem: "Invalid or expired API key" error

**Solusi:**
```bash
# Generate API Key baru
php artisan api:generate-key --name="New Local App" --show-secret

# Pastikan API Key dan Secret sama persis
```

### Problem: Route not found

**Solusi:**
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Verify routes
php artisan route:list --path=api
```

---

## Support

Jika ada masalah:
1. Check logs: `storage/logs/laravel.log`
2. Baca troubleshooting di `PASAR_KOLABORAYA_API_IMPLEMENTATION.md`
3. Test dengan Postman atau cURL
4. Verify API Key dan Secret

---

##  Checklist Setup

- [ ] Step 1: Generate API Key 
- [ ] Step 1: Simpan API Key dan Secret dengan aman 
- [ ] Step 2: Test API (optional) 
- [ ] Verify routes terdaftar 
- [ ] Baca dokumentasi 
- [ ] Implementasi di aplikasi local 

---

**Setelah semua checklist , API siap digunakan!** 

---

**Created:** October 28, 2025  
**Last Updated:** October 28, 2025

