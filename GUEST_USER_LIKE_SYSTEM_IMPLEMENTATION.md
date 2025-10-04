# Sistem Like untuk User Tamu dan Undangan - Implementasi Lengkap

## 🎯 **Overview**

Sistem like telah diimplementasikan untuk memungkinkan user dengan jenis **tamu** dan **undangan** (komunitas) mengakses aksi kolektif dan ekosistem dengan fitur like saja. User jenis ini tidak dapat bergabung, hanya dapat melihat dashboard dan melakukan like.

## 🗄️ **Database Schema**

### **Tabel `collective_action_likes`**
```sql
- id (primary key)
- user_id (foreign key to users)
- collective_action_id (foreign key to collective_actions)
- timestamps
- UNIQUE KEY (user_id, collective_action_id)
```

### **Tabel `ecosystem_likes`**
```sql
- id (primary key)
- user_id (foreign key to users)
- ecosystem_id (foreign key to ecosystems)
- timestamps
- UNIQUE KEY (user_id, ecosystem_id)
```

## 🏗️ **Model Updates**

### **1. User Model** (`app/Models/User.php`)
**New Methods:**
- `isGuestOrInvitation()` - Check if user is tamu or komunitas
- `canLike()` - Check if user can like content (all approved users)
- `collectiveActionLikes()` - Get user's collective action likes
- `ecosystemLikes()` - Get user's ecosystem likes

### **2. CollectiveAction Model** (`app/Models/CollectiveAction.php`)
**New Methods:**
- `likes()` - Get all likes for this collective action
- `likedBy()` - Get users who liked this collective action
- `isLikedBy(User $user)` - Check if user has liked this collective action
- `getLikeCountAttribute()` - Get like count

### **3. Ecosystem Model** (`app/Models/Ecosystem.php`)
**New Methods:**
- `likes()` - Get all likes for this ecosystem
- `likedBy()` - Get users who liked this ecosystem
- `isLikedBy(User $user)` - Check if user has liked this ecosystem
- `getLikeCountAttribute()` - Get like count

### **4. New Models**
- `CollectiveActionLike` - Model for collective action likes
- `EcosystemLike` - Model for ecosystem likes

## 🎮 **Controller**

### **LikeController** (`app/Http/Controllers/LikeController.php`)
**Methods:**
- `toggleCollectiveActionLike(CollectiveAction $collectiveAction)` - Toggle like for collective action
- `toggleEcosystemLike(Ecosystem $ecosystem)` - Toggle like for ecosystem
- `getCollectiveActionLikeStatus(CollectiveAction $collectiveAction)` - Get like status
- `getEcosystemLikeStatus(Ecosystem $ecosystem)` - Get like status

## 🛣️ **Routes**

```php
// Like functionality routes (accessible to all approved users)
Route::middleware(['check.user.approval'])->group(function () {
    // Collective Action Like routes
    Route::post('collective-actions/{collectiveAction}/like', [LikeController::class, 'toggleCollectiveActionLike'])->name('collective-action.like');
    Route::get('collective-actions/{collectiveAction}/like-status', [LikeController::class, 'getCollectiveActionLikeStatus'])->name('collective-action.like-status');
    
    // Ecosystem Like routes
    Route::post('ecosystem/{ecosystem}/like', [LikeController::class, 'toggleEcosystemLike'])->name('ecosystem.like');
    Route::get('ecosystem/{ecosystem}/like-status', [LikeController::class, 'getEcosystemLikeStatus'])->name('ecosystem.like-status');
});
```

## 🎨 **View Updates**

### **1. Collective Action Dashboard** (`resources/views/livewire/collective-action/dashboard.blade.php`)
- **User Tamu/Undangan**: Hanya menampilkan tombol like
- **User Partisipan**: Menampilkan tombol bergabung, berkontribusi, dan like

### **2. Ecosystem Dashboard** (`resources/views/livewire/ecosystem/dashboard.blade.php`)
- **User Tamu/Undangan**: Hanya menampilkan tombol like
- **User Partisipan**: Menampilkan tombol bergabung dan like

### **3. Browse Pages**
- **Collective Action Browse**: Tombol like untuk semua user, tombol bergabung hanya untuk partisipan
- **Ecosystem Browse**: Tombol like untuk semua user, tombol bergabung hanya untuk partisipan

## 🔧 **JavaScript Functionality**

### **Like Functions**
- `toggleLike(type, id, elementId)` - Toggle like status
- `loadLikeStatus(type, id, elementId)` - Load initial like status
- `showNotification(message, type)` - Show success/error notifications

### **Features**
- Real-time like/unlike functionality
- Like count updates
- Visual feedback (button state changes)
- Error handling and notifications
- Auto-load like status on page load

## 📋 **User Experience**

### **Untuk User Tamu dan Undangan:**
1. **Akses Terbatas**: Hanya dapat melihat dashboard dan melakukan like
2. **Tidak Ada Tombol Bergabung**: Tombol bergabung disembunyikan
3. **Fitur Like**: Dapat menyukai aksi kolektif dan ekosistem
4. **Dashboard Access**: Dapat melihat detail aksi kolektif dan ekosistem

### **Untuk User Partisipan:**
1. **Akses Penuh**: Dapat bergabung, berkontribusi, dan like
2. **Semua Tombol Tersedia**: Bergabung, berkontribusi, dan like
3. **Fitur Lengkap**: Semua fitur aksi kolektif dan ekosistem

## 🧪 **Testing**

### **Test Seeder** (`database/seeders/LikeTestSeeder.php`)
- Membuat user dengan berbagai tipe (partisipan, tamu, komunitas)
- Test method `canLike()` dan `isGuestOrInvitation()`
- Verifikasi functionality berjalan dengan benar

### **Test Results**
```
Partisipan can like: Yes
Tamu can like: Yes
Komunitas can like: Yes
Partisipan is guest or invitation: No
Tamu is guest or invitation: Yes
Komunitas is guest or invitation: Yes
```

## 🎯 **Key Features**

1. **Separate Like Tables**: Tabel terpisah untuk like aksi kolektif dan ekosistem
2. **User Type Detection**: Otomatis mendeteksi tipe user dan menampilkan UI yang sesuai
3. **Real-time Updates**: Like count dan status update secara real-time
4. **Responsive Design**: Tombol like responsive untuk semua ukuran layar
5. **Error Handling**: Notifikasi error dan success yang informatif
6. **Security**: Hanya user yang approved yang dapat melakukan like

## 📊 **Data Storage**

### **Like Data Structure**
```json
{
    "user_id": 1,
    "collective_action_id": 5,
    "created_at": "2025-01-04 15:45:00",
    "updated_at": "2025-01-04 15:45:00"
}
```

### **API Response Format**
```json
{
    "success": true,
    "isLiked": true,
    "likeCount": 15,
    "message": "Berhasil menyukai aksi kolektif!"
}
```

## 🚀 **Implementation Status**

✅ **Completed:**
- Database tables created
- Models updated with relationships
- Controller implemented
- Routes configured
- Views updated for all user types
- JavaScript functionality added
- Testing completed

## 📝 **Usage Instructions**

1. **User Tamu/Undangan**:
   - Login dengan akun tamu atau komunitas
   - Buka halaman aksi kolektif atau ekosistem
   - Klik tombol "Suka" untuk menyukai
   - Tombol bergabung tidak akan muncul

2. **User Partisipan**:
   - Login dengan akun partisipan
   - Buka halaman aksi kolektif atau ekosistem
   - Dapat menggunakan semua fitur termasuk like
   - Tombol bergabung dan berkontribusi tersedia

Sistem like telah berhasil diimplementasikan dan siap digunakan! 🎉
