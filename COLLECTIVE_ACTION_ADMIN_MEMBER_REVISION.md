# Revisi Sistem Aksi Kolektif - Admin dan Anggota Otomatis

## 🎯 Perubahan Utama

Sistem aksi kolektif telah direvisi untuk memberikan peran admin kepada ecosystem builders dan keanggotaan otomatis kepada anggota ekosistem yang bergabung.

## 📋 Perubahan yang Dilakukan

### 1. **Ecosystem Builders Menjadi Admin**
- Ecosystem builders yang diundang ke aksi kolektif secara otomatis menjadi **admin**
- Admin memiliki hak untuk mengelola aksi kolektif
- Admin dapat mengelola anggota dan kontribusi

### 2. **Anggota Ekosistem Menjadi Anggota Otomatis**
- Ketika ecosystem builder menerima undangan, **semua anggota ekosistem** secara otomatis menjadi anggota aksi kolektif
- Anggota ekosistem tidak perlu mendaftar secara terpisah
- Mereka langsung dapat berpartisipasi dalam aksi kolektif

## 🛠️ Implementasi Teknis

### Database Changes

#### 1. **Updated Table: `collective_action_ecosystem_invitations`**
```sql
-- Added new column
ALTER TABLE collective_action_ecosystem_invitations 
ADD COLUMN role ENUM('admin', 'member') DEFAULT 'admin';
```

#### 2. **New Table: `collective_action_members`**
```sql
CREATE TABLE collective_action_members (
    id BIGINT PRIMARY KEY,
    collective_action_id BIGINT,
    user_id BIGINT,
    ecosystem_id BIGINT,
    role ENUM('admin', 'member') DEFAULT 'member',
    status ENUM('active', 'inactive') DEFAULT 'active',
    joined_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (collective_action_id) REFERENCES collective_actions(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (ecosystem_id) REFERENCES ecosystems(id),
    
    UNIQUE KEY ca_members_unique (collective_action_id, user_id)
);
```

### Model Updates

#### 1. **CollectiveAction Model**
**New Methods:**
- `members()` - Get all members
- `adminMembers()` - Get admin members only
- `regularMembers()` - Get regular members only
- `activeMembers()` - Get active members only
- `isUserAdmin(User $user)` - Check if user is admin
- `isUserMember(User $user)` - Check if user is member
- `canUserManage(User $user)` - Check if user can manage
- `addEcosystemMembers(Ecosystem $ecosystem, string $role)` - Add ecosystem members
- `removeEcosystemMembers(Ecosystem $ecosystem)` - Remove ecosystem members

#### 2. **CollectiveActionEcosystemInvitation Model**
**New Fields:**
- `role` - Admin or member role

**New Methods:**
- `isAdminInvitation()` - Check if admin invitation
- `isMemberInvitation()` - Check if member invitation
- `getRoleLabelAttribute()` - Get role label

#### 3. **New Model: CollectiveActionMember**
**Features:**
- Manages individual member relationships
- Tracks role, status, and join date
- Relationships to CollectiveAction, User, and Ecosystem

#### 4. **User Model**
**New Methods:**
- `collectiveActionMemberships()` - Get user's collective action memberships
- `adminCollectiveActions()` - Get actions where user is admin
- `memberCollectiveActions()` - Get actions where user is member
- `isAdminOfCollectiveAction(CollectiveAction $action)` - Check admin status
- `isMemberOfCollectiveAction(CollectiveAction $action)` - Check member status

### Component Updates

#### 1. **Create.php**
- Updated to set `role = 'admin'` for ecosystem builder invitations

#### 2. **RespondInvitation.php**
- When accepting invitation:
  - Ecosystem builder becomes admin
  - All ecosystem members become regular members
  - Automatic membership assignment

#### 3. **Contribute.php**
- Updated logic to prevent members from contributing separately
- Members are already part of the action

#### 4. **New: MemberManagement.php**
- Admin interface to manage collective action members
- View admin and regular members
- Remove members or change their status
- Protect creator from removal

## 🔄 Flow Baru

### 1. **Pembuatan Aksi Kolektif**
1. Ecosystem builder membuat aksi kolektif
2. Mengundang ecosystem builders lain dengan role `admin`
3. Undangan dikirim ke ecosystem builders

### 2. **Respons Undangan**
1. Ecosystem builder menerima undangan
2. Jika diterima:
   - Ecosystem builder menjadi **admin** aksi kolektif
   - Semua anggota ekosistem menjadi **anggota** aksi kolektif
3. Jika ditolak:
   - Tidak ada perubahan

### 3. **Manajemen Anggota**
1. Admin dapat mengelola anggota melalui interface khusus
2. Dapat mengaktifkan/menonaktifkan anggota
3. Dapat menghapus anggota (kecuali pembuat aksi)
4. Pembuat aksi tidak dapat dihapus atau dinonaktifkan

### 4. **Kontribusi**
1. Anggota tidak perlu berkontribusi secara terpisah
2. Mereka sudah menjadi bagian dari aksi kolektif
3. User biasa (non-anggota) masih dapat berkontribusi

## 🎨 UI Components

### 1. **Member Management Interface**
- Dashboard untuk mengelola anggota
- Tampilan admin dan anggota terpisah
- Statistik jumlah admin dan anggota
- Aksi untuk mengelola status anggota

### 2. **Updated Contribution Interface**
- Menampilkan status keanggotaan
- Mencegah anggota berkontribusi ganda
- Informasi yang lebih jelas tentang peran

## 🔐 Security & Permissions

### 1. **Admin Permissions**
- Mengelola anggota aksi kolektif
- Mengubah status anggota
- Menghapus anggota (kecuali pembuat)
- Mengelola kontribusi

### 2. **Member Permissions**
- Berpartisipasi dalam aksi kolektif
- Melihat detail aksi kolektif
- Tidak dapat mengelola anggota

### 3. **Creator Protection**
- Pembuat aksi kolektif tidak dapat dihapus
- Pembuat selalu memiliki akses admin
- Status pembuat tidak dapat diubah

## 📊 Benefits

### 1. **Untuk Ecosystem Builders**
- Langsung menjadi admin tanpa proses tambahan
- Dapat mengelola aksi kolektif dengan mudah
- Kontrol penuh atas ekosistem mereka

### 2. **Untuk Anggota Ekosistem**
- Otomatis menjadi anggota aksi kolektif
- Tidak perlu mendaftar secara terpisah
- Langsung dapat berpartisipasi

### 3. **Untuk Sistem**
- Struktur yang lebih jelas antara admin dan anggota
- Manajemen yang lebih efisien
- Kontrol akses yang lebih baik

## 🚀 Next Steps

1. **Testing**: Test semua flow baru
2. **Documentation**: Update dokumentasi user
3. **Training**: Training untuk admin tentang fitur baru
4. **Monitoring**: Monitor penggunaan dan feedback

## 📝 Migration Notes

- Migration otomatis menambahkan kolom `role` dengan default `admin`
- Data existing tetap kompatibel
- Tidak ada data yang hilang dalam proses migrasi
