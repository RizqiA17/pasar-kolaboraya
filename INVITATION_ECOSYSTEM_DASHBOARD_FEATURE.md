# Fitur Undang Ekosistem pada Dashboard Aksi Kolektif

## 🎯 **Deskripsi Fitur**

Fitur ini memungkinkan admin aksi kolektif untuk mengundang ekosistem lain untuk bergabung dalam aksi kolektif langsung dari dashboard aksi kolektif. Ini adalah penambahan dari fitur undangan yang sebelumnya hanya tersedia saat pembuatan aksi kolektif.

## 📋 **Fitur yang Diimplementasikan**

### **1. Form Invitation Terintegrasi**
- **Lokasi**: Dashboard Aksi Kolektif (section admin-only)
- **Akses**: Hanya admin aksi kolektif yang dapat mengundang ekosistem
- **Fitur**:
  - Dropdown pemilihan ekosistem yang belum diundang
  - Field pesan undangan personal (minimal 20 karakter)
  - Validasi form dengan error handling
  - Toggle form untuk show/hide interface

### **2. Smart Ecosystem Filtering**
- **Filter Otomatis**: Sistem secara otomatis menyaring ekosistem yang dapat diundang
- **Excluded Ecosystems**:
  - Ekosistem yang sudah pernah diundang (pending/accepted/declined)
  - Ekosistem milik user yang sedang mengundang
  - Ekosistem yang tidak aktif
- **Dynamic Loading**: Daftar ekosistem terupdate secara real-time

### **3. Status Invitation Tracking**
- **Real-time Status**: Menampilkan status semua undangan yang pernah dikirim
- **Status Indicators**: 
  - 🟡 Pending (Menunggu Respons)
  - 🟢 Accepted (Diterima)  
  - 🔴 Declined (Ditolak)
- **Invitation Details**: Informasi lengkap tentang siapa yang mengundang

## 🛠️ **Implementasi Teknis**

### **Backend Components**

#### **Dashboard Controller Updates** (`app/Livewire/CollectiveAction/Dashboard.php`)
**New Properties:**
```php
public $show_invitation_form = false;
public $selected_ecosystem_id = '';
public $invitation_message = '';
public $available_ecosystems = [];
```

**New Methods:**
- `loadAvailableEcosystems()` - Load ekosistem yang dapat diundang
- `toggleInvitationForm()` - Toggle form invitation
- `sendInvitation()` - Kirim undangan ke ekosistem

**Enhanced Render:**
- `$pendingInvitations` - Undangan yang pending
- `$allInvitations` - Semua undangan dengan status

#### **Validation Rules**
```php
'selected_ecosystem_id' => 'required|exists:ecosystems,id',
'invitation_message' => 'required|string|min:20|max:500',
```

### **Frontend Components**

#### **Dashboard View Updates** (`resources/views/livewire/collective-action/dashboard.blade.php`)
**New Section: "Undang Ekosistem Lain"**
- Positioned after Status Management section
- Admin-only visibility
- Responsive design dengan dark mode support

**Form Elements:**
- Dropdown select dengan daftar ekosistem
- Textarea untuk pesan undangan
- Action buttons (Kirim/Batal)
- Error message display

**Status Display:**
- List semua undangan yang pernah dikirim
- Color-coded status indicators
- Ecosystem information dengan organization details

## 🔒 **Security & Permissions**

### **Access Control**
- **Permission Check**: `$collectiveAction->canUserManage(Auth::user())`
- **Role-based**: Hanya admin aksi kolektif dan creator
- **Double Validation**: Server-side dan client-side validation

### **Data Protection**
- **Input Sanitization**: Semua input di-sanitize
- **SQL Injection Prevention**: Menggunakan Eloquent ORM
- **XSS Protection**: Blade template escaping

## 📊 **User Experience Flow**

### **For Admin/Creator:**
1. **Access Dashboard** → Masuk ke dashboard aksi kolektif
2. **View Invitation Section** → Lihat section "Undang Ekosistem Lain"
3. **Click "Undang Ekosistem"** → Form invitation muncul
4. **Select Ecosystem** → Pilih dari dropdown ekosistem tersedia
5. **Write Message** → Tulis pesan personal (min 20 karakter)
6. **Send Invitation** → Kirim undangan
7. **View Status** → Monitor status undangan dalam real-time

### **For Invited Ecosystem:**
1. **Receive Notification** → Notifikasi di ecosystem dashboard
2. **Review Invitation** → Baca detail undangan dan pesan
3. **Respond** → Accept/Decline undangan
4. **Join Action** → Jika accept, anggota ekosistem otomatis join

## 🔄 **Integration dengan Sistem Existing**

### **Model Relationships**
- **CollectiveAction**: Menggunakan existing invitation methods
- **CollectiveActionEcosystemInvitation**: Model invitation existing
- **User**: Menggunakan `acceptedEcosystems` relationship
- **Ecosystem**: Integration dengan ecosystem data

### **Notification System**
- **Compatible**: Dengan sistem notifikasi existing
- **Email Support**: Menggunakan email template existing
- **Dashboard Integration**: Terintegrasi dengan ecosystem dashboard

## 📈 **Benefits**

### **For Users:**
- **Flexibility**: Dapat mengundang ekosistem setelah aksi kolektif dibuat
- **Real-time Management**: Monitor dan kelola undangan secara real-time
- **Better UX**: Interface yang intuitif dan mudah digunakan
- **Smart Filtering**: Tidak perlu khawatir undang ekosistem yang sama

### **For System:**
- **Scalable**: Mudah untuk ditambahkan fitur baru
- **Maintainable**: Code terstruktur dan mudah di-maintain
- **Performance**: Efficient query dengan proper relationships
- **Secure**: Implementing security best practices

## 🚀 **Usage Examples**

### **Scenario 1: Post-Creation Invitation**
- Admin membuat aksi kolektif dengan 2 ekosistem
- Setelah aksi dimulai, admin ingin mengundang 1 ekosistem lagi
- Admin masuk dashboard → klik "Undang Ekosistem" → pilih ekosistem → kirim

### **Scenario 2: Replacement Invitation** 
- Salah satu ekosistem decline undangan
- Admin ingin mengundang ekosistem pengganti
- Dashboard menampilkan ekosistem available yang belum diundang

### **Scenario 3: Monitoring Invitations**
- Admin ingin melihat status semua undangan
- Dashboard menampilkan list lengkap dengan status color-coded
- Admin dapat track progress invitation acceptance

## 🔧 **Technical Notes**

### **Database Usage**
- **No New Tables**: Menggunakan table `collective_action_ecosystem_invitations` existing
- **Efficient Queries**: Menggunakan relationship dan eager loading
- **Data Integrity**: Foreign key constraints terjaga

### **Performance Considerations**
- **Lazy Loading**: Available ecosystems di-load saat dibutuhkan
- **Cache-Friendly**: Compatible dengan view caching
- **Optimized Queries**: Minimal database hits

### **Browser Compatibility**
- **Modern Browsers**: Support untuk semua browser modern
- **Responsive**: Mobile-friendly design
- **Progressive Enhancement**: Graceful degradation untuk browser lama

---

## 📝 **Conclusion**

Fitur "Undang Ekosistem pada Dashboard" berhasil diimplementasikan dengan:
- ✅ Interface yang user-friendly dan intuitive
- ✅ Security dan permission control yang proper
- ✅ Integration seamless dengan sistem existing
- ✅ Real-time status monitoring
- ✅ Smart filtering dan validation
- ✅ Responsive design dengan dark mode support

Fitur ini meningkatkan fleksibilitas dan usability sistem aksi kolektif dengan memungkinkan admin untuk mengelola undangan ekosistem secara dynamic setelah aksi kolektif dibuat.
