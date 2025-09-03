# Form Middleware Implementation

## Overview
Implementasi middleware untuk form yang menangani fitur yang dinonaktifkan oleh super admin. Sistem ini memberikan feedback visual dan fungsional yang jelas kepada pengguna ketika fitur-fitur tertentu dinonaktifkan.

## Fitur yang Diimplementasikan

### 1. Middleware CheckFormFeatureAccess
- **Lokasi**: `app/Http/Middleware/CheckFormFeatureAccess.php`
- **Fungsi**: Memeriksa akses fitur untuk form submissions
- **Fitur**:
  - Super admin bypass - selalu bisa mengakses semua fitur
  - Response JSON untuk AJAX requests
  - Error handling yang konsisten

### 2. Form Disabled States
- **Kolaborasi Forms**: `resources/views/livewire/collaborations/new-collaboration.blade.php`
- **Event Forms**: `resources/views/livewire/events/create-event.blade.php`
- **Collaboration Manager**: `resources/views/livewire/collaborations/collaboration-manager.blade.php`

### 3. Visual Feedback Components
- **Disabled Feature Tooltip**: `resources/views/components/disabled-feature-tooltip.blade.php`
- **Disabled Overlay**: Overlay dengan pesan informatif
- **Button States**: Button disabled dengan styling yang berbeda

## Implementasi Teknis

### 1. PHP Logic untuk Form Disabled
```php
@php
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
    $isFormDisabled = !$collaborationsEnabled && !$isSuperAdmin;
@endphp
```

### 2. Conditional Rendering
```blade
@if($isFormDisabled)
    <!-- Disabled Message -->
    <div class="mb-6 p-6 bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl shadow-lg">
        <!-- Warning message content -->
    </div>
@endif
```

### 3. Form Disabled State
```blade
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 relative {{ $isFormDisabled ? 'opacity-60 pointer-events-none' : '' }}">
    @if($isFormDisabled)
        <!-- Disabled Overlay -->
        <div class="absolute inset-0 bg-gray-100/80 rounded-2xl flex items-center justify-center z-10">
            <!-- Disabled content -->
        </div>
    @endif
    <!-- Form content -->
</div>
```

### 4. Button Disabled State
```blade
<button type="submit" 
        @if($isFormDisabled) disabled @endif
        class="flex-1 font-semibold py-4 px-8 rounded-xl shadow-lg transition-all duration-200 flex items-center justify-center gap-3 {{ $isFormDisabled ? 'bg-gray-400 text-gray-200 cursor-not-allowed' : 'cursor-pointer bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white hover:shadow-xl transform hover:-translate-y-0.5' }}">
    {{ $isFormDisabled ? 'Fitur Dinonaktifkan' : 'Buat Kolaborasi' }}
</button>
```

### 5. Tooltip Component
```blade
<x-disabled-feature-tooltip message="Fitur kolaborasi sedang dinonaktifkan oleh administrator" position="top" size="sm">
    <button disabled class="bg-gray-400 text-gray-200 cursor-not-allowed">
        Fitur Dinonaktifkan
    </button>
</x-disabled-feature-tooltip>
```

## Livewire Component Updates

### 1. NewCollaboration Component
- Added SystemSetting import
- Feature check in `create()` method
- Error message for disabled features

### 2. CreateEvent Component
- Added SystemSetting import
- Feature check in `save()` method
- Error message for disabled features

### 3. CollaborationManager Component
- Added SystemSetting import
- Feature check in `createCollaboration()` and `inviteUsers()` methods
- Error message for disabled features

## Middleware Registration

### Bootstrap Configuration
```php
// bootstrap/app.php
$middleware->alias([
    'check.form.feature.access' => \App\Http\Middleware\CheckFormFeatureAccess::class,
]);
```

## Fitur yang Didukung

### 1. Kolaborasi
- **Setting**: `collaborations_enabled`
- **Forms**: New collaboration, collaboration manager
- **Actions**: Create, invite users

### 2. Aksi Pengguna (Events)
- **Setting**: `user_actions_enabled`
- **Forms**: Create event
- **Actions**: Create events

### 3. Koneksi
- **Setting**: `connections_enabled`
- **Forms**: Connection forms
- **Actions**: Create connections

## User Experience

### 1. Visual Feedback
- **Disabled Overlay**: Semi-transparent overlay dengan pesan
- **Button States**: Button disabled dengan styling berbeda
- **Tooltips**: Informasi hover untuk button disabled
- **Warning Messages**: Pesan peringatan yang jelas

### 2. Accessibility
- **Screen Reader**: Button disabled dengan proper attributes
- **Keyboard Navigation**: Disabled elements tidak dapat diakses
- **Color Contrast**: Styling yang memenuhi standar aksesibilitas

### 3. Responsive Design
- **Mobile**: Tooltip dan overlay responsive
- **Desktop**: Hover states dan tooltips
- **Tablet**: Touch-friendly disabled states

## Error Handling

### 1. Server-side Validation
```php
if (!SystemSetting::isCollaborationsEnabled() && !auth()->user()->isSuperAdmin()) {
    session()->flash('error', 'Fitur kolaborasi sedang dinonaktifkan oleh administrator.');
    return;
}
```

### 2. Client-side Feedback
- Form disabled state
- Button disabled state
- Visual indicators
- Tooltip messages

## Testing

### 1. Feature Disabled
- Form tidak dapat di-submit
- Button disabled
- Overlay muncul
- Error message ditampilkan

### 2. Super Admin Access
- Super admin tetap bisa mengakses semua fitur
- Bypass middleware untuk super admin
- Normal functionality untuk super admin

### 3. Feature Enabled
- Form berfungsi normal
- Button enabled
- Tidak ada overlay
- Normal user experience

## Maintenance

### 1. Adding New Features
1. Add new setting to SystemSetting model
2. Update middleware CheckFormFeatureAccess
3. Add feature check to relevant forms
4. Update Livewire components
5. Test disabled/enabled states

### 2. Updating Messages
- Update tooltip messages in components
- Update error messages in Livewire components
- Update warning messages in forms

### 3. Styling Updates
- Update disabled button styles
- Update overlay styles
- Update tooltip styles
- Ensure responsive design

## Best Practices

### 1. Consistent Messaging
- Gunakan pesan yang konsisten untuk fitur yang sama
- Sertakan informasi tentang administrator
- Berikan alternatif atau solusi jika memungkinkan

### 2. User Experience
- Jangan biarkan user bingung
- Berikan feedback yang jelas
- Sertakan navigasi kembali ke dashboard

### 3. Performance
- Cache system settings jika diperlukan
- Minimize database queries
- Optimize JavaScript untuk tooltips

## Troubleshooting

### 1. Form Masih Bisa Di-submit
- Periksa middleware registration
- Periksa feature check di Livewire component
- Periksa JavaScript disabled state

### 2. Tooltip Tidak Muncul
- Periksa Alpine.js initialization
- Periksa CSS z-index
- Periksa positioning classes

### 3. Super Admin Tidak Bisa Akses
- Periksa isSuperAdmin() method
- Periksa middleware bypass logic
- Periksa user role assignment
