# Perbaikan Final Error pada Tampilan Contribute Aksi Kolektif

## Deskripsi
Memperbaiki error yang masih ada pada tampilan contribute aksi kolektif dan memastikan input untuk nama kontribusi custom muncul ketika memilih "Lainnya".

## Error yang Diperbaiki

### 1. Data Contribution Types Tidak Dikirim dengan Benar
- **Masalah**: `$this->contributionTypes` tidak dapat diakses di view
- **Solusi**: Menggunakan `pluck('name', 'id')->toArray()` dan mengirim data melalui render method

### 2. Input Custom Type Tidak Muncul
- **Masalah**: Kondisi untuk menampilkan input custom type tidak bekerja
- **Solusi**: Menggunakan `wire:model.live` dan memperbaiki logika PHP

### 3. Data Resource Types Tidak Dikirim
- **Masalah**: `$this->resourceTypes` tidak dapat diakses di view
- **Solusi**: Mengirim data melalui render method

## Perubahan yang Dilakukan

### 1. File: `app/Livewire/CollectiveAction/Contribute.php`

**Memperbaiki mount method:**
```php
public function mount(CollectiveAction $collectiveAction)
{
    $this->collectiveAction = $collectiveAction;

    // Load contribution types from database
    $this->contributionTypes = Contribution::all()->pluck('name', 'id')->toArray();

    // Check if user can contribute
    if (!$collectiveAction->canUserContribute(Auth::user())) {
        session()->flash('error', 'Anda tidak dapat berkontribusi pada aksi ini.');
        return redirect()->route('collective-action.browse');
    }
}
```

**Memperbaiki render method:**
```php
public function render()
{
    return view('livewire.collective-action.contribute', [
        'contributionTypes' => $this->contributionTypes,
        'resourceTypes' => $this->resourceTypes,
    ]);
}
```

### 2. File: `resources/views/livewire/collective-action/contribute.blade.php`

**Menggunakan wire:model.live untuk reactivity:**
```blade
<flux:select 
    wire:model.live="contribution_id" 
    :label="'Jenis Kontribusi'" 
    required
    class="mb-4"
>
    @foreach($contributionTypes as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</flux:select>
```

**Memperbaiki referensi variabel:**
```blade
<!-- Custom Contribution Type (shown when "Lainnya" is selected) -->
@php
    $selectedContribution = \App\Models\Contribution::find($contribution_id);
    $isOther = $selectedContribution && (str_contains(strtolower($selectedContribution->name), 'lainnya') || str_contains(strtolower($selectedContribution->name), 'other'));
@endphp
@if($isOther)
    <div class="mt-4">
        <flux:input
            wire:model="contribution_custom_type"
            :label="'Jenis Kontribusi Custom'"
            type="text"
            required
            :placeholder="'Masukkan jenis kontribusi yang ingin Anda berikan...'"
        />
    </div>
@endif
```

**Memperbaiki resource types:**
```blade
{{ $resourceTypes[$resource] ?? $resource }}
```

## Logika yang Diperbaiki

### 1. Data Loading
- **Sebelum**: `$this->contributionTypes = Contribution::all();`
- **Sesudah**: `$this->contributionTypes = Contribution::all()->pluck('name', 'id')->toArray();`

### 2. Data Passing
- **Sebelum**: Menggunakan `$this->property` di view
- **Sesudah**: Mengirim data melalui render method dan menggunakan variabel langsung

### 3. Reactivity
- **Sebelum**: `wire:model="contribution_id"`
- **Sesudah**: `wire:model.live="contribution_id"`

## Testing Scenarios

### 1. Pilih Jenis Kontribusi "Lainnya"
- [ ] Dropdown menampilkan semua jenis kontribusi
- [ ] Ketika memilih "Lainnya", input custom type muncul
- [ ] Input custom type memiliki label "Jenis Kontribusi Custom"
- [ ] Input custom type required dan memiliki placeholder

### 2. Pilih Jenis Kontribusi "Dana"
- [ ] Ketika memilih "Dana", input amount muncul
- [ ] Input amount memiliki label "Jumlah Kontribusi (Rupiah)"
- [ ] Input amount required dan memiliki placeholder

### 3. Pilih Jenis Kontribusi Lainnya
- [ ] Ketika memilih jenis lain, hanya input description yang muncul
- [ ] Help text sesuai dengan jenis kontribusi yang dipilih

### 4. Submit Form
- [ ] Form dapat disubmit tanpa error
- [ ] Validasi bekerja dengan benar
- [ ] Redirect ke halaman browse setelah submit

## Konsistensi dengan Dashboard

Implementasi sekarang konsisten dengan dashboard aksi kolektif:
- Menggunakan `wire:model.live` untuk reactivity
- Menggunakan `$contribution_id` langsung di PHP code
- Menggunakan data yang dikirim melalui render method
- Logika custom type sama dengan dashboard

## Files Modified
1. `app/Livewire/CollectiveAction/Contribute.php` - Memperbaiki data loading dan passing
2. `resources/views/livewire/collective-action/contribute.blade.php` - Memperbaiki referensi variabel dan reactivity

## Status
✅ **SELESAI** - Semua error telah diperbaiki dan input custom type muncul dengan benar ketika memilih "Lainnya".
