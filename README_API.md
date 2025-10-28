# 📡 Pasar Kolaboraya - API Documentation

> **API untuk akses data user dari local server**

---

## 📚 Dokumentasi

Untuk dokumentasi lengkap dan panduan implementasi, lihat:

1. **[Quick Start Guide](PASAR_KOLABORAYA_API_QUICK_START.md)** - Panduan cepat untuk memulai (⭐ Mulai di sini!)
2. **[Complete Implementation](PASAR_KOLABORAYA_API_IMPLEMENTATION.md)** - Dokumentasi lengkap dan detail

---

## ⚡ Quick Setup

```bash
# 1. Generate API Secret
php artisan tinker
# Di console: echo Str::random(64);
# Copy output ke .env sebagai API_SHARED_SECRET

# 2. Generate API Token
php artisan api:generate-token 1 --name="local-server-token" --show-secret

# 3. Test API
php examples/api-client-simple.php
```

---

## 🔗 API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/v1/users/qr` | POST | Get user by QR code |
| `/api/v1/users/{id}` | GET | Get user by ID |
| `/api/v1/users` | GET | Get paginated users list |

**Secure endpoints:** Ganti `/v1/` dengan `/v1/secure/` untuk signature verification.

---

## 🔐 Authentication

Semua request memerlukan:
```
Authorization: Bearer YOUR_SANCTUM_TOKEN
```

Untuk secure endpoints, tambahkan:
```
X-Timestamp: [unix_timestamp]
X-Signature: [hmac_sha256_signature]
```

---

## 💡 Contoh Penggunaan

### Menggunakan Client Class (Rekomendasi)

```php
require_once 'examples/api-client-class.php';

$client = new PasarKolaborayaApiClient(
    'http://yourdomain.com/api',
    'YOUR_TOKEN',
    'YOUR_SECRET', // Optional for secure
    true // Use secure endpoints
);

// Get user by ID
$result = $client->getUserById(1);

// Get user by QR
$result = $client->getUserByQr('PK_1_1234567890_abc123');

// Search users
$result = $client->searchUsers('john', 10);

// Get approved users
$result = $client->getApprovedUsers(20, 1);
```

### Menggunakan CURL

```bash
curl -X GET \
  http://yourdomain.com/api/v1/users/1 \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'
```

---

## 📁 Files & Examples

- `examples/api-client-simple.php` - Simple API client (Sanctum only)
- `examples/api-client-secure.php` - Secure API client (Sanctum + Signature)
- `examples/api-client-class.php` - Reusable client class ⭐ **Recommended**

---

## 🛡️ Security Features

✅ Laravel Sanctum Token Authentication  
✅ HMAC SHA256 Signature Verification (secure endpoints)  
✅ Timestamp Validation (2-minute window)  
✅ Rate Limiting (30-60 req/min)  
✅ Input Validation  
✅ Error Handling & Logging  

---

## 🚀 Performance Optimization

✅ Eager Loading (avoid N+1 queries)  
✅ Pagination (max 100 items/page)  
✅ Database Indexing  
✅ JSON Resources for consistent response  
✅ Query Filters & Search  

---

## 📊 Response Format

**Success:**
```json
{
    "status": "success",
    "message": "User data retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "profile": {...}
    }
}
```

**Error:**
```json
{
    "status": "error",
    "message": "Error message here"
}
```

**Paginated:**
```json
{
    "status": "success",
    "data": [...],
    "meta": {
        "current_page": 1,
        "total": 100,
        "per_page": 15
    },
    "links": {...}
}
```

---

## 🧪 Testing

```bash
# Generate test token
php artisan api:generate-token 1 --name="test"

# Test with Postman or cURL
curl -X GET http://yourdomain.com/api/v1/users \
  -H 'Authorization: Bearer TOKEN'

# Or use PHP examples
php examples/api-client-simple.php
```

---

## ⚙️ Configuration

**Environment Variables (.env):**
```env
API_SHARED_SECRET=your-64-char-secret-here
```

**Rate Limits:**
- Standard endpoints: 60 requests/minute
- Secure endpoints: 30 requests/minute

---

## 📞 Support

Untuk pertanyaan atau issue:
1. Check [Quick Start Guide](PASAR_KOLABORAYA_API_QUICK_START.md)
2. Check [Complete Documentation](PASAR_KOLABORAYA_API_IMPLEMENTATION.md)
3. Check logs: `storage/logs/laravel.log`

---

## 📝 Changelog

### Version 1.0 (October 28, 2025)
- ✅ Initial API implementation
- ✅ 3 main endpoints
- ✅ Sanctum authentication
- ✅ Signature verification
- ✅ Rate limiting
- ✅ Complete documentation
- ✅ Client examples

---

**Status:** ✅ Production Ready  
**Version:** 1.0  
**Last Updated:** October 28, 2025

