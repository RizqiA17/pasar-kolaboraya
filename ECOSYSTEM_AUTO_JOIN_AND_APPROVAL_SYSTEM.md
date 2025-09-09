# Ecosystem Auto-Join dan Sistem Persetujuan Aksi Kolektif

## Fitur yang Diimplementasikan

### 1. Pengaturan Auto-Join Ekosistem
- **Tujuan**: Mengatur apakah anggota ekosistem otomatis bergabung ke aksi kolektif saat ekosistem diundang
- **Field Database**: `auto_join_collective_actions` (boolean) di tabel `ecosystems`
- **Default**: `false` (memerlukan persetujuan)

### 2. Sistem Persetujuan untuk User Non-Ekosistem
- **Tujuan**: Memungkinkan user yang bukan anggota ekosistem untuk bergabung ke aksi kolektif dengan persetujuan admin
- **Status Baru**: `pending_approval`, `rejected` di tabel `collective_action_users`
- **Field Tambahan**: `approval_requested_at`, `approved_at`, `approved_by`, `admin_notes`

## Struktur Database

### Tabel Ecosystems
```sql
ALTER TABLE ecosystems ADD COLUMN auto_join_collective_actions BOOLEAN DEFAULT false;
```

### Tabel Collective Action Users
```sql
-- Status diperluas untuk mencakup approval
ENUM('active', 'inactive', 'pending', 'pending_approval', 'rejected')

-- Field approval baru
approval_requested_at TIMESTAMP NULL
approved_at TIMESTAMP NULL  
approved_by FOREIGN KEY users(id) NULL
admin_notes TEXT NULL
```

## Logika Sistem

### Auto-Join Berdasarkan Pengaturan Ekosistem
1. **Jika `auto_join_collective_actions = true`**:
   - Anggota ekosistem langsung mendapat status `active`
   - `joined_at` diisi saat bergabung
   
2. **Jika `auto_join_collective_actions = false`**:
   - Anggota ekosistem mendapat status `pending_approval`
   - `approval_requested_at` diisi saat bergabung
   - Memerlukan persetujuan admin aksi kolektif

### Bergabung untuk Non-Anggota Ekosistem
1. **User yang bukan anggota ekosistem**:
   - Selalu mendapat status `pending_approval`
   - Memerlukan persetujuan admin aksi kolektif
   - `approval_requested_at` diisi saat bergabung

2. **User yang anggota ekosistem**:
   - Status bergantung pada pengaturan `auto_join_collective_actions` ekosistem
   - Mengikuti aturan auto-join yang telah ditetapkan

## Komponen yang Dibuat/Diperbarui

### 1. Models
- **Ecosystem.php**: Tambah field `auto_join_collective_actions` dan metode terkait
- **CollectiveAction.php**: 
  - Metode `addEcosystemMembers()` diperbarui untuk menangani auto-join
  - Metode `addUser()` diperbarui untuk approval system
  - Metode baru: `approveUser()`, `rejectUser()`, `pendingApprovalUsers()`

### 2. Livewire Components
- **Ecosystem/Settings.php**: Mengelola pengaturan ekosistem
- **CollectiveAction/UserApprovals.php**: Mengelola persetujuan user
- **CollectiveAction/Join.php**: Diperbarui untuk approval system

### 3. Views
- **ecosystem/settings.blade.php**: UI pengaturan ekosistem
- **collective-action/user-approvals.blade.php**: UI persetujuan anggota
- **ecosystem/create.blade.php**: Tambah setting auto-join
- **auth/ecosystem-setup.blade.php**: Tambah setting auto-join
- **collective-action/member-management.blade.php**: Tambah link approval

### 4. Routes
```php
// Ecosystem settings
Route::get('ecosystem/{ecosystem}/settings', Settings::class)->name('ecosystem.settings');

// User approvals
Route::get('collective-actions/{collectiveAction}/approvals', UserApprovals::class)->name('collective-action.user-approvals');
```

## Flow Penggunaan

### Untuk Pemilik Ekosistem:
1. Masuk ke dashboard ekosistem
2. Klik tombol "Pengaturan" 
3. Aktifkan/nonaktifkan "Anggota Otomatis Bergabung ke Aksi Kolektif"
4. Simpan pengaturan

### Untuk Admin Aksi Kolektif:
1. Masuk ke member management aksi kolektif
2. Klik "Persetujuan Anggota" (jika ada pending approvals)
3. Review permintaan bergabung
4. Setujui atau tolak dengan catatan admin

### Untuk User yang Ingin Bergabung:
1. Klik "Bergabung" di halaman aksi kolektif
2. Isi form bergabung dengan alasan
3. **Jika anggota ekosistem dengan auto-join**: Langsung bergabung
4. **Jika bukan anggota ekosistem atau auto-join dinonaktifkan**: Menunggu persetujuan admin

## Status dan Indikator

### Status User di Aksi Kolektif:
- `active`: Anggota aktif
- `pending_approval`: Menunggu persetujuan
- `rejected`: Ditolak admin
- `inactive`: Dinonaktifkan

### Indikator Visual:
- Badge notification di tombol "Persetujuan Anggota" menunjukkan jumlah pending
- Pesan berbeda saat bergabung tergantung status
- Flash messages untuk konfirmasi approval/rejection

## Keamanan dan Validasi

### Otorisasi:
- Hanya pemilik ekosistem yang dapat mengubah pengaturan
- Hanya admin aksi kolektif yang dapat approve/reject
- Validasi status saat melakukan approval

### Validasi Data:
- Boolean validation untuk auto_join_collective_actions
- Text validation untuk admin_notes
- Status enum validation untuk collective action users

## Testing Scenarios

1. **Buat ekosistem dengan auto-join enabled**
2. **Buat ekosistem dengan auto-join disabled** 
3. **User ekosistem bergabung ke aksi kolektif** (keduanya)
4. **User non-ekosistem bergabung ke aksi kolektif**
5. **Admin approve/reject user**
6. **Ubah pengaturan auto-join di ekosistem**
7. **Undang ekosistem ke aksi kolektif** (test auto-join)
