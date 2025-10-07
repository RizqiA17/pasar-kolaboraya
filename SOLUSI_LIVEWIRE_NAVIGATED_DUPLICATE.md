# Solusi: livewire:navigated Dipanggil 2 Kali

## Masalah
Event `livewire:navigated` dipanggil 2 kali pada tampilan ketika user tidak pernah reload halaman setelah login. Masalah ini tidak terjadi setelah reload dan berpindah-pindah halaman.

## Penyebab
Masalahnya adalah **script yang mengandung event listener `livewire:navigated` tidak menggunakan atribut `data-navigate-once`**. 

Tanpa `data-navigate-once`, script akan dieksekusi berulang kali setiap kali navigasi terjadi, yang menyebabkan:
1. Event listener ditambahkan berulang kali
2. Event `livewire:navigated` dipanggil 2 kali atau lebih
3. Memory leak dan performance issues

## Solusi
Tambahkan atribut `data-navigate-once` pada semua script yang mengandung event listener `livewire:navigated`.

### Sebelum (Masalah):
```html
<script>
    document.addEventListener('livewire:navigated', function() {
        // kode Anda
    });
</script>
```

### Sesudah (Solusi):
```html
<script data-navigate-once>
    document.addEventListener('livewire:navigated', function() {
        // kode Anda
    });
</script>
```

## File yang Sudah Diperbaiki

1. `resources/views/livewire/ecosystem/qr-scanner.blade.php`
2. `resources/views/livewire/ecosystem/dashboard.blade.php`
3. `resources/views/livewire/connections/qr-scanner.blade.php`
4. `resources/views/livewire/collective-action/qr-scanner.blade.php`
5. `resources/views/components/admin/layout.blade.php`
6. `resources/views/components/dark-mode-toggle.blade.php`
7. `resources/views/livewire/admin/surveys/results.blade.php`
8. `resources/views/livewire/dashboard/ecosystem-mapping.blade.php`
9. `resources/views/public-ecosystem-mapping.blade.php`

## Penjelasan `data-navigate-once`

Atribut `data-navigate-once` memastikan bahwa:
- Script hanya dieksekusi sekali selama siklus navigasi Livewire
- Event listener tidak ditambahkan berulang kali
- Mencegah duplicate event calls
- Meningkatkan performance dan mencegah memory leak

## Testing
Untuk memverifikasi solusi:

1. **Login tanpa reload halaman**
2. **Navigasi antar halaman beberapa kali**
3. **Check console log** - seharusnya hanya ada 1 event listener per komponen
4. **Event `livewire:navigated` hanya dipanggil sekali per navigasi**

## Catatan Penting
- `data-navigate-once` hanya berlaku untuk script yang mengandung event listener Livewire
- Script yang tidak mengandung event listener Livewire tidak perlu `data-navigate-once`
- Solusi ini mengatasi masalah tanpa mengubah logika aplikasi
- Kompatibel dengan semua versi Livewire
