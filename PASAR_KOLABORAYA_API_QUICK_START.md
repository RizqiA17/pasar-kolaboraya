# 🚀 Pasar Kolaboraya API - Quick Start Guide

Panduan cepat untuk memulai menggunakan API Pasar Kolaboraya.

---

## ⚡ Setup Cepat (5 Menit)

### **Step 1: Generate API Shared Secret**

```bash
# Buka terminal di project root
cd /path/to/pasar-kolaboraya

# Generate secret key
php artisan tinker
```

Di tinker console:
```php
echo Str::random(64);
exit
```

Copy output string, kemudian tambahkan ke `.env`:
```env
API_SHARED_SECRET=your_generated_secret_here
```

### **Step 2: Generate API Token**

```bash
# Gunakan command yang sudah disediakan
php artisan api:generate-token 1 --name="local-server-token" --show-secret

# Atau manual via tinker
php artisan tinker
```

Di tinker console:
```php
$user = User::find(1); // Ganti 1 dengan user ID yang Anda inginkan
$token = $user->createToken('local-server-token')->plainTextToken;
echo $token;
exit
```

**⚠️ PENTING:** Simpan token ini dengan aman! Token hanya ditampilkan sekali.

### **Step 3: Test API**

Gunakan salah satu file contoh di folder `examples/`:

```bash
# Copy contoh file
cp examples/api-client-simple.php test-api.php

# Edit file, ganti:
# - YOUR_TOKEN_HERE dengan token dari Step 2
# - yourdomain.com dengan domain Anda

# Jalankan
php test-api.php
```

---

## 📍 Endpoint URLs

### **Base URL:**
```
http://yourdomain.com/api/v1          # Standard endpoints
http://yourdomain.com/api/v1/secure   # Secure endpoints
```

### **Available Endpoints:**

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/users/qr` | Get user by QR code |
| GET | `/users/{id}` | Get user by ID |
| GET | `/users` | Get paginated users |

---

## 🔑 Autentikasi

Semua request harus menyertakan Bearer Token di header:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Untuk secure endpoints**, tambahkan:
```
X-Timestamp: 1698765432
X-Signature: generated_hmac_signature
```

---

## 💻 Contoh Request

### **1. Menggunakan CURL:**

```bash
# Get user by ID
curl -X GET \
  http://yourdomain.com/api/v1/users/1 \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'

# Get user by QR code
curl -X POST \
  http://yourdomain.com/api/v1/users/qr \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -d '{"qr_code":"PK_1_1698765432_abc123"}'

# Get paginated users
curl -X GET \
  'http://yourdomain.com/api/v1/users?per_page=10&page=1' \
  -H 'Authorization: Bearer YOUR_TOKEN' \
  -H 'Accept: application/json'
```

### **2. Menggunakan PHP:**

**Simple (tanpa signature):**
```php
<?php
$token = 'YOUR_TOKEN_HERE';
$userId = 1;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "http://yourdomain.com/api/v1/users/{$userId}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
    ],
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
print_r($data);
```

**Secure (dengan signature):**
```php
<?php
$token = 'YOUR_TOKEN_HERE';
$secret = 'YOUR_SHARED_SECRET_HERE';
$userId = 1;

$timestamp = time();
$body = ''; // Empty untuk GET request
$signature = hash_hmac('sha256', $timestamp . $body, $secret);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "http://yourdomain.com/api/v1/secure/users/{$userId}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
        'X-Timestamp: ' . $timestamp,
        'X-Signature: ' . $signature,
    ],
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
print_r($data);
```

### **3. Menggunakan Class (Rekomendasi):**

```php
<?php
require_once 'examples/api-client-class.php';

// Initialize client
$client = new PasarKolaborayaApiClient(
    'http://yourdomain.com/api',
    'YOUR_TOKEN_HERE',
    'YOUR_SHARED_SECRET_HERE',  // Optional
    true  // Use secure endpoints
);

// Get user by ID
$result = $client->getUserById(1);
if ($result['success']) {
    echo "User: " . $result['data']['data']['name'];
} else {
    echo "Error: " . $result['error'];
}

// Search users
$result = $client->searchUsers('john', 10);
if ($result['success']) {
    foreach ($result['data']['data'] as $user) {
        echo $user['name'] . "\n";
    }
}

// Get approved users
$result = $client->getApprovedUsers(20, 1);
print_r($result['data']);
```

---

## 📊 Response Format

### **Success Response:**
```json
{
    "status": "success",
    "message": "User data retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "profile": {
            "organization": "PT Example",
            "phone": "08123456789",
            "interests": [...],
            "skills": [...]
        }
    }
}
```

### **Error Response:**
```json
{
    "status": "error",
    "message": "User not found"
}
```

### **Validation Error:**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "qr_code": ["QR code is required"]
    }
}
```

---

## 🔧 Query Parameters

### **GET /users:**

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `per_page` | integer | Items per page (1-100) | `per_page=20` |
| `page` | integer | Page number | `page=2` |
| `approval_status` | string | Filter by status | `approval_status=approved` |
| `user_type` | string | Filter by type | `user_type=partisipan` |
| `is_ecosystem_builder` | boolean | Filter builders | `is_ecosystem_builder=true` |
| `search` | string | Search query | `search=john` |

**Example:**
```
GET /api/v1/users?per_page=20&page=1&approval_status=approved&search=john
```

---

## ⚠️ Common Issues & Solutions

### **1. "Unauthenticated" Error**
- **Problem:** Token tidak valid atau tidak dikirim
- **Solution:** Pastikan header `Authorization: Bearer TOKEN` benar

### **2. "Invalid signature" Error**
- **Problem:** Signature tidak cocok
- **Solution:** 
  - Pastikan `API_SHARED_SECRET` sama di server dan client
  - Pastikan timestamp fresh (< 2 menit)
  - Pastikan body di-hash persis sama

### **3. "Expired timestamp" Error**
- **Problem:** Timestamp sudah lewat 2 menit
- **Solution:** Generate timestamp baru menggunakan `time()`

### **4. 429 Too Many Requests**
- **Problem:** Rate limit exceeded
- **Solution:** Tunggu 1 menit atau adjust rate limit

---

## 📝 Checklist Sebelum Production

- [ ] Generate dan simpan `API_SHARED_SECRET` dengan aman
- [ ] Generate API token untuk local server
- [ ] Test semua 3 endpoints
- [ ] Test error handling
- [ ] Setup logging dan monitoring
- [ ] Configure CORS jika diperlukan
- [ ] Setup rate limiting sesuai kebutuhan
- [ ] Backup token dan secret dengan aman
- [ ] Dokumentasikan API untuk tim

---

## 📚 Files & Resources

### **Files Contoh:**
- `examples/api-client-simple.php` - Contoh simple request
- `examples/api-client-secure.php` - Contoh secure request
- `examples/api-client-class.php` - Reusable client class

### **Command:**
- `php artisan api:generate-token {user_id}` - Generate token

### **Dokumentasi Lengkap:**
- `PASAR_KOLABORAYA_API_IMPLEMENTATION.md` - Dokumentasi lengkap

---

## 🆘 Need Help?

Jika ada pertanyaan atau issue:
1. Check dokumentasi lengkap di `PASAR_KOLABORAYA_API_IMPLEMENTATION.md`
2. Check logs di `storage/logs/laravel.log`
3. Test dengan Postman atau cURL
4. Verifikasi token dan secret key

---

**Happy Coding! 🚀**

Last Updated: October 28, 2025

