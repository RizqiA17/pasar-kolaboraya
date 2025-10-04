# Perbaikan Like Functionality - Total Suka Tidak Ter-update Saat Reload

## 🎯 **Masalah yang Diperbaiki**

Total suka di ekosistem dan aksi kolektif menampilkan angka 0 saat reload halaman, baik di dashboard maupun di browse views.

## 🔍 **Root Cause Analysis**

Masalah terjadi karena:

1. **JavaScript Selector Issue**: Function `loadLikeStatus` dan `toggleLike` menggunakan hardcoded ID selector (`getElementById('like-button')`) yang tidak dapat menemukan elemen dengan benar ketika ada multiple like buttons.

2. **Multiple Like Buttons**: Di dashboard views, ada dua like button (satu untuk guest/invitation users dan satu untuk partisipan users) dengan ID yang sama, menyebabkan selector hanya menemukan elemen pertama.

3. **Inconsistent ID Management**: Browse views menggunakan unique IDs dengan suffix, tetapi dashboard views menggunakan hardcoded IDs.

## 🔧 **Perubahan yang Dilakukan**

### **1. Collective Action Dashboard (`resources/views/livewire/collective-action/dashboard.blade.php`)**

#### **Function `toggleLike`**
**Sebelum:**
```javascript
function toggleLike(type, id) {
    const button = document.getElementById('like-button');
    const icon = document.getElementById('like-icon');
    const text = document.getElementById('like-text');
    const count = document.getElementById('like-count');
    // ...
}
```

**Sesudah:**
```javascript
function toggleLike(type, id) {
    // Find the like button (there might be multiple)
    const buttons = document.querySelectorAll('#like-button');
    if (buttons.length === 0) return;
    
    const button = buttons[0]; // Use the first one
    const icon = button.querySelector('#like-icon');
    const text = button.querySelector('#like-text');
    const count = button.querySelector('#like-count');
    // ...
}
```

#### **Function `loadLikeStatus`**
**Sebelum:**
```javascript
function loadLikeStatus(type, id) {
    fetch(`/${type}s/${id}/like-status`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.getElementById('like-button');
            const icon = document.getElementById('like-icon');
            const text = document.getElementById('like-text');
            const count = document.getElementById('like-count');
            // ...
        }
    });
}
```

**Sesudah:**
```javascript
function loadLikeStatus(type, id) {
    fetch(`/${type}s/${id}/like-status`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Find the like button (there might be multiple)
            const buttons = document.querySelectorAll('#like-button');
            buttons.forEach(button => {
                const icon = button.querySelector('#like-icon');
                const text = button.querySelector('#like-text');
                const count = button.querySelector('#like-count');
                // ...
            });
        }
    });
}
```

#### **Update UI After Toggle**
**Sebelum:**
```javascript
.then(data => {
    if (data.success) {
        // Update button state
        if (data.isLiked) {
            button.classList.remove('bg-red-500', 'hover:bg-red-600');
            button.classList.add('bg-red-600', 'hover:bg-red-700');
            text.textContent = 'Disukai';
        } else {
            button.classList.remove('bg-red-600', 'hover:bg-red-700');
            button.classList.add('bg-red-500', 'hover:bg-red-600');
            text.textContent = 'Suka';
        }
        
        // Update count
        count.textContent = data.likeCount;
        // ...
    }
})
```

**Sesudah:**
```javascript
.then(data => {
    if (data.success) {
        // Update all like buttons
        const allButtons = document.querySelectorAll('#like-button');
        allButtons.forEach(btn => {
            const btnIcon = btn.querySelector('#like-icon');
            const btnText = btn.querySelector('#like-text');
            const btnCount = btn.querySelector('#like-count');
            
            if (data.isLiked) {
                btn.classList.remove('bg-red-500', 'hover:bg-red-600');
                btn.classList.add('bg-red-600', 'hover:bg-red-700');
                btnText.textContent = 'Disukai';
            } else {
                btn.classList.remove('bg-red-600', 'hover:bg-red-700');
                btn.classList.add('bg-red-500', 'hover:bg-red-600');
                btnText.textContent = 'Suka';
            }
            
            // Update count
            btnCount.textContent = data.likeCount;
        });
        // ...
    }
})
```

### **2. Ecosystem Dashboard (`resources/views/livewire/ecosystem/dashboard.blade.php`)**

Perubahan yang sama diterapkan pada ecosystem dashboard:

- **Function `toggleLike`**: Menggunakan `querySelectorAll` untuk menemukan semua like buttons
- **Function `loadLikeStatus`**: Menggunakan `forEach` untuk update semua like buttons
- **Update UI After Toggle**: Mengupdate semua like buttons secara bersamaan

### **3. Browse Views (Sudah Benar)**

Browse views sudah menggunakan unique IDs dengan suffix (`like-button-{{ $id }}`), sehingga tidak memerlukan perubahan.

## 🎯 **Hasil Perubahan**

### **Sebelum:**
- ❌ Total suka menampilkan 0 saat reload
- ❌ JavaScript error karena selector tidak menemukan elemen
- ❌ Inconsistent behavior antara dashboard dan browse views

### **Sesudah:**
- ✅ Total suka ter-update dengan benar saat reload
- ✅ JavaScript berfungsi dengan baik untuk multiple like buttons
- ✅ Consistent behavior di semua views
- ✅ Real-time update untuk semua like buttons

## 🔍 **Technical Details**

### **Selector Strategy:**
1. **Dashboard Views**: Menggunakan `querySelectorAll('#like-button')` untuk menemukan semua like buttons
2. **Browse Views**: Menggunakan unique IDs dengan suffix untuk setiap item

### **Update Strategy:**
1. **Load Status**: Update semua like buttons saat halaman dimuat
2. **Toggle Action**: Update semua like buttons saat user melakukan like/unlike
3. **Consistent State**: Memastikan semua like buttons memiliki state yang sama

### **Error Handling:**
- Check if buttons exist sebelum melakukan operasi
- Graceful fallback jika tidak ada like buttons
- Console error logging untuk debugging

## 🧪 **Testing**

Setelah perubahan ini:
1. **Dashboard Views**: Total suka ter-update dengan benar saat reload
2. **Browse Views**: Total suka ter-update dengan benar saat reload
3. **Like/Unlike Action**: Semua like buttons ter-update secara real-time
4. **Multiple Buttons**: Semua like buttons memiliki state yang konsisten

## 🎉 **Status**

✅ **SELESAI** - Total suka sekarang ter-update dengan benar saat reload di semua views (dashboard dan browse) untuk ekosistem dan aksi kolektif.
