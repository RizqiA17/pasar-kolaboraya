# Pasar Kolaboraya Routes - Export Feature

## 📍 Export Feature Routes

Berikut adalah daftar routes yang ditambahkan untuk fitur export data user Pasar Kolaboraya:

### 1. Export CSV
```
Method: GET|HEAD
URI: admin/pasar-kolaboraya/{pasarKolaboraya}/export-csv
Name: admin.pasar-kolaboraya.export-csv
Controller: App\Http\Controllers\Admin\PasarKolaborayaExportController@exportCsv
Middleware: web, auth, admin
```

**Deskripsi**: Download data user dalam format CSV (Excel compatible)

**Parameters**:
- `{pasarKolaboraya}`: ID atau model instance dari Pasar Kolaboraya

**Response**:
- Type: `text/csv; charset=UTF-8`
- Disposition: `attachment`
- Filename: `pasar_kolaboraya_users_{id}_{timestamp}.csv`

**Authorization**: Super Admin only

---

### 2. Export SQL
```
Method: GET|HEAD
URI: admin/pasar-kolaboraya/{pasarKolaboraya}/export-sql
Name: admin.pasar-kolaboraya.export-sql
Controller: App\Http\Controllers\Admin\PasarKolaborayaExportController@exportSql
Middleware: web, auth, admin
```

**Deskripsi**: Download data user dalam format SQL untuk import ke database

**Parameters**:
- `{pasarKolaboraya}`: ID atau model instance dari Pasar Kolaboraya

**Response**:
- Type: `application/sql; charset=UTF-8`
- Disposition: `attachment`
- Filename: `pasar_kolaboraya_users_{id}_{timestamp}.sql`

**Authorization**: Super Admin only

---

## 🔗 Related Routes

### Existing Pasar Kolaboraya Routes

```
GET admin/pasar-kolaboraya
    → admin.pasar-kolaboraya.manage
    → View list semua Pasar Kolaboraya
    
GET admin/pasar-kolaboraya/create
    → admin.pasar-kolaboraya.create
    → Form create Pasar Kolaboraya baru
    
GET admin/pasar-kolaboraya/{pasarKolaboraya}/users
    → admin.pasar-kolaboraya.users
    → Manage users dalam Pasar Kolaboraya
    
GET admin/pasar-kolaboraya/{pasarKolaboraya}/qr-scanner
    → admin.pasar-kolaboraya.qr-scanner
    → QR Scanner untuk Pasar Kolaboraya
```

---

## 📝 Usage Examples

### Via Browser (Recommended)
```
1. Login sebagai Super Admin
2. Navigate to: http://your-app.com/admin/pasar-kolaboraya
3. Click "Export CSV" or "Export SQL" button pada card Pasar Kolaboraya
4. File akan otomatis terdownload
```

### Via cURL (For Testing)
```bash
# Export CSV
curl -X GET "http://your-app.com/admin/pasar-kolaboraya/1/export-csv" \
  -H "Cookie: your-session-cookie" \
  -o "pasar_export.csv"

# Export SQL
curl -X GET "http://your-app.com/admin/pasar-kolaboraya/1/export-sql" \
  -H "Cookie: your-session-cookie" \
  -o "pasar_export.sql"
```

### Via Laravel Blade
```blade
<!-- Export CSV Link -->
<a href="{{ route('admin.pasar-kolaboraya.export-csv', $pasarKolaboraya) }}">
    Export CSV
</a>

<!-- Export SQL Link -->
<a href="{{ route('admin.pasar-kolaboraya.export-sql', $pasarKolaboraya) }}">
    Export SQL
</a>
```

### Via Controller/Service
```php
use App\Models\PasarKolaboraya;
use Illuminate\Support\Facades\Route;

// Get export URL
$pasarKolaboraya = PasarKolaboraya::find(1);
$csvUrl = route('admin.pasar-kolaboraya.export-csv', $pasarKolaboraya);
$sqlUrl = route('admin.pasar-kolaboraya.export-sql', $pasarKolaboraya);

// Redirect to export
return redirect()->route('admin.pasar-kolaboraya.export-csv', $pasarKolaboraya);
```

---

## 🔒 Security & Authorization

### Middleware Stack
1. **web**: Session, CSRF protection, cookie encryption
2. **auth**: Require authenticated user
3. **admin**: Check user role (dalam route group)

### Controller Authorization
```php
$user = Auth::user();
if (!$user || !$user->isSuperAdmin()) {
    abort(403, 'Unauthorized access');
}
```

### Role Requirements
- **Super Admin** (`role = 'super_admin'`): ✅ Full access
- **Admin** (`role = 'admin'`): ❌ No access (Super Admin only)
- **Regular User**: ❌ No access

---

## ⚡ Performance Considerations

### Streaming Response
Routes menggunakan `StreamedResponse` untuk menghindari memory overload:
- Data tidak dimuat sepenuhnya ke memory
- Response dikirim secara incremental
- Suitable untuk large datasets

### Chunking
Query database menggunakan chunking (100 records per batch):
- Mengurangi memory usage
- Menghindari timeout untuk large datasets
- Optimized query performance

### Query Optimization
- Selective column selection (hanya kolom yang diperlukan)
- Filter by status ('accepted' only)
- No N+1 query problems (efficient eager loading)

---

## 📊 Expected Response Times

| Dataset Size | CSV Export | SQL Export |
|--------------|------------|------------|
| < 100 users  | ~1 sec     | ~1.5 sec   |
| 100-1K users | ~5 sec     | ~8 sec     |
| 1K-10K users | ~30 sec    | ~45 sec    |
| > 10K users  | Consider queue/background processing |

**Note**: Times vary based on server specs and network speed

---

## 🐛 Error Handling

### Possible Errors

**403 Forbidden**
```json
{
  "message": "Unauthorized access"
}
```
**Solution**: Ensure logged in as Super Admin

**404 Not Found**
```json
{
  "message": "No query results for model [PasarKolaboraya]"
}
```
**Solution**: Check Pasar Kolaboraya ID exists

**500 Internal Server Error**
```
Check storage/logs/laravel.log for details
```
**Common causes**:
- Memory limit exceeded
- Max execution time exceeded
- Database connection issues

---

## ✅ Testing Routes

### Manual Testing
```bash
# 1. Check routes registered
php artisan route:list | grep export

# 2. Test in browser (as Super Admin)
Visit: http://your-app.com/admin/pasar-kolaboraya
Click export buttons

# 3. Verify file downloads
Check Downloads folder for CSV/SQL files
```

### Automated Testing (Example)
```php
// tests/Feature/PasarKolaborayaExportTest.php

public function test_super_admin_can_export_csv()
{
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $pasar = PasarKolaboraya::factory()->create();
    
    $response = $this->actingAs($superAdmin)
        ->get(route('admin.pasar-kolaboraya.export-csv', $pasar));
    
    $response->assertOk();
    $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
}

public function test_regular_user_cannot_export()
{
    $user = User::factory()->create(['role' => 'user']);
    $pasar = PasarKolaboraya::factory()->create();
    
    $response = $this->actingAs($user)
        ->get(route('admin.pasar-kolaboraya.export-csv', $pasar));
    
    $response->assertForbidden();
}
```

---

## 📚 Related Documentation

- [Full Feature Documentation](./PASAR_KOLABORAYA_EXPORT_FEATURE.md)
- [Quick Start Guide](./PASAR_KOLABORAYA_EXPORT_QUICK_START.md)
- [Implementation Summary](./PASAR_KOLABORAYA_EXPORT_IMPLEMENTATION_SUMMARY.md)

---

**Last Updated**: 28 Oktober 2025  
**Feature Version**: 1.0.0

