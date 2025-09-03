# Admin System Documentation

## Overview
Sistem admin telah berhasil dibuat untuk mengelola semua data dalam aplikasi Pasar Kolaboraya. Hanya user dengan role `super_admin` yang dapat mengakses halaman admin.

## Features

### 1. Role System
- **User**: Role default untuk pengguna biasa
- **Admin**: Role admin dengan akses terbatas
- **Super Admin**: Role dengan akses penuh ke semua fitur admin

### 2. Admin Dashboard
- Statistik lengkap sistem (users, collaborations, events, connections, dll)
- Recent activity (users, collaborations, events)
- Quick access ke semua fitur manajemen

### 3. User Management
- View semua users dengan filter berdasarkan role
- Edit user information dan role
- Delete users (dengan proteksi untuk super admin terakhir)
- Search users berdasarkan nama atau email

### 4. Collaboration Management
- View semua collaborations
- Filter berdasarkan status (active, completed, paused)
- View detail collaboration dengan members dan todos
- Delete collaborations

### 5. Event Management
- View semua events
- Filter berdasarkan status
- View detail events dengan participants
- Delete events

### 6. Connection Management
- View semua user connections
- Filter berdasarkan status (pending, accepted, declined)
- Delete connections

### 7. Master Data Management
- **Interests**: CRUD operations untuk interests
- **Skills**: CRUD operations untuk skills
- **Contributions**: CRUD operations untuk contributions
- **Event Categories**: CRUD operations untuk event categories

## Access Information

### Super Admin Account
- **Email**: admin@pasar-kolaboraya.com
- **Password**: admin123
- **URL**: `/admin`

### Security Features
- Middleware `super.admin` untuk proteksi akses
- Hanya super admin yang bisa mengakses halaman admin
- Proteksi untuk mencegah penghapusan super admin terakhir
- CSRF protection pada semua form

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AdminController.php
│   └── Middleware/
│       └── SuperAdminMiddleware.php
├── Models/
│   └── User.php (updated with role methods)

resources/views/admin/
├── layout.blade.php
├── dashboard.blade.php
├── users/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
├── collaborations/
│   ├── index.blade.php
│   └── show.blade.php
├── events/
│   └── index.blade.php
├── connections/
│   └── index.blade.php
└── interests/
    └── index.blade.php

routes/
└── web.php (updated with admin routes)

database/
├── migrations/
│   └── 2025_09_03_025505_add_role_to_users_table.php
└── seeders/
    └── SuperAdminSeeder.php
```

## Routes

### Admin Routes (Protected by super.admin middleware)
- `GET /admin` - Admin dashboard
- `GET /admin/users` - Users management
- `GET /admin/users/{user}` - View user details
- `GET /admin/users/{user}/edit` - Edit user form
- `PUT /admin/users/{user}` - Update user
- `DELETE /admin/users/{user}` - Delete user
- `GET /admin/collaborations` - Collaborations management
- `GET /admin/collaborations/{collaboration}` - View collaboration details
- `DELETE /admin/collaborations/{collaboration}` - Delete collaboration
- `GET /admin/events` - Events management
- `GET /admin/events/{event}` - View event details
- `DELETE /admin/events/{event}` - Delete event
- `GET /admin/connections` - Connections management
- `DELETE /admin/connections/{connection}` - Delete connection
- `GET /admin/interests` - Interests management
- `POST /admin/interests` - Create interest
- `PUT /admin/interests/{interest}` - Update interest
- `DELETE /admin/interests/{interest}` - Delete interest
- Similar routes for skills, contributions, and event categories

## Usage Instructions

1. **Login sebagai Super Admin**:
   - Buka aplikasi dan login dengan email: `admin@pasar-kolaboraya.com`
   - Password: `admin123`

2. **Akses Admin Panel**:
   - Setelah login, akses URL: `/admin`
   - Atau klik link "Admin Panel" jika tersedia

3. **Navigasi**:
   - Gunakan sidebar untuk navigasi antar fitur
   - Dashboard menampilkan overview sistem
   - Setiap section memiliki search dan filter

4. **Manajemen Data**:
   - Users: Edit role, view details, delete users
   - Collaborations: View details, delete collaborations
   - Events: View details, delete events
   - Connections: View dan delete connections
   - Master Data: CRUD operations untuk interests, skills, dll

## Security Notes

- Semua route admin dilindungi oleh middleware `super.admin`
- Hanya user dengan role `super_admin` yang bisa mengakses
- Super admin terakhir tidak bisa dihapus
- Semua form menggunakan CSRF protection
- Password super admin default harus diubah di production

## Customization

Untuk menambahkan fitur admin baru:

1. Tambahkan method di `AdminController`
2. Tambahkan route di `routes/web.php`
3. Buat view di `resources/views/admin/`
4. Update sidebar navigation di `resources/views/admin/layout.blade.php`

## Production Deployment

1. Ubah password super admin default
2. Hapus atau comment seeder untuk super admin
3. Pastikan middleware `super.admin` terdaftar dengan benar
4. Test semua fitur admin sebelum go-live
