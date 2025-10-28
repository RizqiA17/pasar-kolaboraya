# 📡 Pasar Kolaboraya - API Documentation Hub

> **Sistem API untuk akses data user dari local server**

---

## 🎯 Mulai Dari Sini

### **LANGKAH PERTAMA - WAJIB!** ⭐
👉 **[SETUP_API_INSTRUCTIONS.md](SETUP_API_INSTRUCTIONS.md)** - Setup wajib sebelum pakai API

### **LANGKAH KEDUA - Panduan Cepat** ⚡
👉 **[PASAR_KOLABORAYA_API_QUICK_START.md](PASAR_KOLABORAYA_API_QUICK_START.md)** - Quick start 5 menit

### **LENGKAP - Dokumentasi Detail** 📚
👉 **[PASAR_KOLABORAYA_API_IMPLEMENTATION.md](PASAR_KOLABORAYA_API_IMPLEMENTATION.md)** - Full documentation

### **SUMMARY - Ringkasan Implementasi** 📊
👉 **[PASAR_KOLABORAYA_API_SUMMARY.md](PASAR_KOLABORAYA_API_SUMMARY.md)** - Summary & checklist

---

## 🚀 Quick Navigation

| Dokumentasi | Deskripsi | Kapan Digunakan |
|-------------|-----------|-----------------|
| **[SETUP_API_INSTRUCTIONS.md](SETUP_API_INSTRUCTIONS.md)** | Setup API (WAJIB) | ⭐ Baca pertama kali |
| **[PASAR_KOLABORAYA_API_QUICK_START.md](PASAR_KOLABORAYA_API_QUICK_START.md)** | Quick start guide | Untuk mulai cepat |
| **[PASAR_KOLABORAYA_API_IMPLEMENTATION.md](PASAR_KOLABORAYA_API_IMPLEMENTATION.md)** | Dokumentasi lengkap | Untuk reference detail |
| **[PASAR_KOLABORAYA_API_SUMMARY.md](PASAR_KOLABORAYA_API_SUMMARY.md)** | Summary & checklist | Untuk review & checklist |
| **[README_API.md](README_API.md)** | API overview | Quick reference |

---

## 📦 File Contoh

| File | Tipe | Deskripsi |
|------|------|-----------|
| `examples/api-client-simple.php` | Simple | Request tanpa signature |
| `examples/api-client-secure.php` | Secure | Request dengan signature |
| `examples/api-client-class.php` | OOP | **⭐ Reusable class (Recommended)** |

---

## 🔗 API Endpoints

### Base URLs:
- **Standard:** `http://yourdomain.com/api/v1`
- **Secure:** `http://yourdomain.com/api/v1/secure`

### Endpoints Available:

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/users/qr` | Get user by QR code |
| GET | `/users/{id}` | Get user by ID |
| GET | `/users` | Get paginated users |

**Total:** 3 endpoints × 2 versions (standard + secure) = **6 routes**

---

## ⚡ Quick Start

```bash
# 1. Setup (WAJIB - hanya sekali)
php artisan tinker
echo Str::random(64);  # Copy output ke .env sebagai API_SHARED_SECRET
exit

# 2. Generate Token
php artisan api:generate-token 1 --name="local-server" --show-secret

# 3. Test API
php examples/api-client-simple.php
```

---

## 💻 Contoh Penggunaan

### Menggunakan Class (Recommended)

```php
require_once 'examples/api-client-class.php';

$client = new PasarKolaborayaApiClient(
    'http://yourdomain.com/api',
    'YOUR_TOKEN_HERE',
    'YOUR_SECRET_HERE',
    true  // use secure endpoints
);

// Get user by ID
$result = $client->getUserById(1);
if ($result['success']) {
    echo "User: " . $result['data']['data']['name'];
}

// Search users
$result = $client->searchUsers('john', 10);

// Get approved users
$result = $client->getApprovedUsers(20, 1);
```

### Menggunakan cURL

```bash
curl -X GET \
  http://yourdomain.com/api/v1/users/1 \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'
```

---

## 🔐 Authentication

**Semua request memerlukan:**
```
Authorization: Bearer YOUR_SANCTUM_TOKEN
```

**Untuk secure endpoints, tambahkan:**
```
X-Timestamp: [unix_timestamp]
X-Signature: [hmac_sha256_signature]
```

---

## 🛡️ Security Features

- ✅ Laravel Sanctum (Token-based auth)
- ✅ HMAC SHA256 Signature Verification
- ✅ Timestamp Validation (2-min window)
- ✅ Rate Limiting (30-60 req/min)
- ✅ Input Validation
- ✅ Error Handling & Logging

---

## ⚡ Performance Features

- ✅ Eager Loading (no N+1 queries)
- ✅ Pagination (max 100/page)
- ✅ Query Filters & Search
- ✅ JSON Resources
- ✅ Database Indexing

---

## 📊 Quick Stats

| Metric | Value |
|--------|-------|
| Total Endpoints | 6 (3 standard + 3 secure) |
| API Version | v1 |
| Rate Limit (Standard) | 60 req/min |
| Rate Limit (Secure) | 30 req/min |
| Max Items per Page | 100 |
| Default Items per Page | 15 |
| Auth Method | Sanctum Bearer Token |
| Signature Algorithm | HMAC SHA256 |

---

## 🧪 Testing

```bash
# List all API routes
php artisan route:list --path=api

# Test endpoint
curl -X GET \
  http://yourdomain.com/api/v1/users \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'

# Or use PHP example
php examples/api-client-simple.php
```

---

## 🆘 Common Issues

### "Unauthenticated" (401)
- Token tidak valid
- Header Authorization salah format
- **Solusi:** Generate token baru

### "Invalid signature" (403)
- Secret key tidak match
- Timestamp expired
- **Solusi:** Check API_SHARED_SECRET dan regenerate signature

### "Too Many Requests" (429)
- Rate limit exceeded
- **Solusi:** Wait 1 minute

### Route Not Found (404)
- API routes belum registered
- **Solusi:** `php artisan route:clear`

---

## 📞 Support

**Jika ada masalah:**
1. Baca [SETUP_API_INSTRUCTIONS.md](SETUP_API_INSTRUCTIONS.md)
2. Baca [PASAR_KOLABORAYA_API_IMPLEMENTATION.md](PASAR_KOLABORAYA_API_IMPLEMENTATION.md)
3. Check logs: `storage/logs/laravel.log`
4. Test dengan Postman atau cURL

---

## 📋 Checklist

### Setup (Wajib):
- [ ] Generate API_SHARED_SECRET
- [ ] Tambahkan ke .env
- [ ] Generate API Token
- [ ] Test API

### Development:
- [ ] Baca dokumentasi
- [ ] Implementasi client
- [ ] Test semua endpoints
- [ ] Handle errors

### Production:
- [ ] Review security checklist
- [ ] Setup monitoring
- [ ] Configure rate limiting
- [ ] Backup tokens & secrets

---

## 🎯 Roadmap

**Versi Saat Ini: 1.0** ✅
- [x] 3 main endpoints (user data)
- [x] Standard & secure versions
- [x] Complete documentation
- [x] Client examples
- [x] Security features

**Versi Future:**
- [ ] More CRUD endpoints
- [ ] Webhook support
- [ ] GraphQL support
- [ ] Real-time notifications
- [ ] Batch operations

---

## 📚 Additional Resources

### Official Laravel Documentation:
- [Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)
- [API Resources](https://laravel.com/docs/11.x/eloquent-resources)
- [Rate Limiting](https://laravel.com/docs/11.x/routing#rate-limiting)

### Project Documentation:
- Full implementation details
- Troubleshooting guides
- Best practices
- Security guidelines

---

## ✅ Status

**Implementation Status:** ✅ COMPLETE  
**Production Ready:** ✅ YES  
**Version:** 1.0  
**Last Updated:** October 28, 2025  

---

## 🎉 Summary

API Pasar Kolaboraya telah berhasil diimplementasikan dengan:

✅ **3 Endpoint Utama** untuk get user data  
✅ **Keamanan Berlapis** (Sanctum + Signature)  
✅ **Performance Optimization** (Eager loading, pagination)  
✅ **Dokumentasi Lengkap** (4 dokumen + 3 contoh)  
✅ **Production Ready** (Security, error handling, logging)  

**Siap digunakan!** 🚀

---

**📖 Mulai dari:** [SETUP_API_INSTRUCTIONS.md](SETUP_API_INSTRUCTIONS.md) ⭐

