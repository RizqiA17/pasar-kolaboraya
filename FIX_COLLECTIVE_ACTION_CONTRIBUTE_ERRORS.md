# Perbaikan Error pada Tampilan Contribute Aksi Kolektif

## Deskripsi
Memperbaiki error pada tampilan contribute aksi kolektif dengan mengikuti implementasi yang ada di dashboard dan memperbaiki variabel yang tidak terdefinisi.

## Error yang Ditemukan

### 1. Variabel `$contribution_type` Tidak Terdefinisi
- **Lokasi**: `resources/views/livewire/collective-action/contribute.blade.php`
- **Masalah**: View menggunakan `$contribution_type` yang tidak ada di component
- **Solusi**: Membuat computed property `getContributionTypeProperty()` di component

### 2. Variabel `$resourceTypes` Tidak Terdefinisi
- **Lokasi**: `resources/views/livewire/collective-action/contribute.blade.php`
- **Masalah**: View menggunakan `$resourceTypes` yang tidak ada di component
- **Solusi**: Menambahkan property `$resourceTypes` di component

### 3. Variabel `$contributionTypes` Tidak Terdefinisi
- **Lokasi**: `resources/views/livewire/collective-action/contribute.blade.php`
- **Masalah**: View menggunakan `$contributionTypes` yang tidak ada di component
- **Solusi**: Menggunakan `$this->contributionTypes` untuk mengakses property

### 4. Variabel `$contribution_id` Tidak Terdefinisi di PHP
- **Lokasi**: `resources/views/livewire/collective-action/contribute.blade.php`
- **Masalah**: PHP code menggunakan `$contribution_id` yang tidak ada di scope
- **Solusi**: Menggunakan `$this->contribution_id` untuk mengakses property

## Perubahan yang Dilakukan

### 1. File: `app/Livewire/CollectiveAction/Contribute.php`

**Menambahkan computed property untuk contribution type:**
```php
public function getContributionTypeProperty()
{
    if (!$this->contribution_id) {
        return null;
    }
    
    $contribution = Contribution::find($this->contribution_id);
    if (!$contribution) {
        return null;
    }
    
    $name = strtolower($contribution->name);
    
    if (str_contains($name, 'relawan') || str_contains($name, 'volunteer')) {
        return 'volunteer';
    } elseif (str_contains($name, 'dana') || str_contains($name, 'funding')) {
        return 'funding';
    } elseif (str_contains($name, 'keahlian') || str_contains($name, 'expertise')) {
        return 'expertise';
    } elseif (str_contains($name, 'sumber') || str_contains($name, 'resource')) {
        return 'resources';
    } elseif (str_contains($name, 'promosi') || str_contains($name, 'promotion')) {
        return 'promotion';
    }
    
    return 'other';
}
```

### 2. File: `resources/views/livewire/collective-action/contribute.blade.php`

**Mengganti semua referensi variabel yang tidak terdefinisi:**

1. **Help text berdasarkan jenis kontribusi:**
```blade
@if($this->contribution_type === 'volunteer')
    Jelaskan keahlian, waktu yang tersedia, dan jenis bantuan yang dapat Anda berikan.
@elseif($this->contribution_type === 'funding')
    Jelaskan tujuan penggunaan dana dan apakah ada syarat khusus untuk penggunaannya.
@elseif($this->contribution_type === 'expertise')
    Jelaskan keahlian spesifik, pengalaman, dan bagaimana Anda dapat membantu.
@elseif($this->contribution_type === 'resources')
    Jelaskan jenis sumber daya, fasilitas, atau peralatan yang dapat Anda sediakan.
@elseif($this->contribution_type === 'promotion')
    Jelaskan platform promosi yang Anda miliki dan jangkauan audiens.
@else
    Jelaskan secara detail kontribusi yang ingin Anda berikan.
@endif
```

2. **Additional details untuk jenis kontribusi:**
```blade
@if($this->contribution_type === 'volunteer')
    <!-- Detail relawan -->
@endif
```

3. **Resource types untuk required resources:**
```blade
{{ $this->resourceTypes[$resource] ?? $resource }}
```

4. **Contribution types untuk select:**
```blade
@foreach($this->contributionTypes as $id => $name)
    <option value="{{ $id }}">{{ $name }}</option>
@endforeach
```

5. **PHP code untuk selected contribution:**
```php
$selectedContribution = \App\Models\Contribution::find($this->contribution_id);
```

## Logika Computed Property

### `getContributionTypeProperty()`
Computed property ini menentukan jenis kontribusi berdasarkan nama contribution yang dipilih:

- **volunteer**: Jika nama mengandung 'relawan' atau 'volunteer'
- **funding**: Jika nama mengandung 'dana' atau 'funding'
- **expertise**: Jika nama mengandung 'keahlian' atau 'expertise'
- **resources**: Jika nama mengandung 'sumber' atau 'resource'
- **promotion**: Jika nama mengandung 'promosi' atau 'promotion'
- **other**: Untuk jenis lainnya

## Konsistensi dengan Dashboard

Implementasi ini sekarang konsisten dengan dashboard aksi kolektif yang menggunakan:
- `$this->contributionTypes` untuk mengakses jenis kontribusi
- `$this->contribution_id` untuk mengakses ID kontribusi yang dipilih
- Computed property untuk menentukan jenis kontribusi

## Testing

Untuk menguji perbaikan ini:

1. **Akses halaman contribute aksi kolektif**
2. **Pilih jenis kontribusi** - pastikan help text muncul sesuai jenis
3. **Pilih jenis "Lainnya"** - pastikan field custom type muncul
4. **Pilih jenis "Dana"** - pastikan field amount muncul
5. **Isi form dan submit** - pastikan tidak ada error

## Files Modified
1. `app/Livewire/CollectiveAction/Contribute.php` - Menambahkan computed property
2. `resources/views/livewire/collective-action/contribute.blade.php` - Memperbaiki referensi variabel

## Status
✅ **SELESAI** - Semua error telah diperbaiki dan implementasi konsisten dengan dashboard.
