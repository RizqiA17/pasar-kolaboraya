<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-12 h-12" opacity="opacity-10" />
    
    <x-auth-header :title="'Mulai Perubahan Sosial'" :description="'Masukkan data Anda untuk bergabung bersama kami'" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    @php
        $registrationEnabled = \App\Models\SystemSetting::getValue('registration_enabled', '1') === '1';
    @endphp

    @if(!$registrationEnabled)
        <!-- Registration Disabled Message -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">
                Registrasi Dinonaktifkan
            </h3>
            <p class="text-red-700 dark:text-red-300 mb-4">
                Registrasi pengguna baru sedang dinonaktifkan. Silakan hubungi administrator untuk informasi lebih lanjut.
            </p>
            <a href="{{ route('login') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Kembali ke Login
            </a>
        </div>
    @else

    <div class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="'Nama'"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="'Nama lengkap'"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="'Alamat email'"
            type="email"
            required
            autocomplete="email"
            placeholder="contoh@gmail.com"
        />

        <!-- Gender -->
        <flux:select
            wire:model="gender"
            :label="'Jenis Kelamin'"
            required
            :placeholder="'Pilih jenis kelamin'"
        >
            <flux:select.option value="laki-laki">Laki-laki</flux:select.option>
            <flux:select.option value="perempuan">Perempuan</flux:select.option>
            <flux:select.option value="non-biner">Non-biner</flux:select.option>
            <flux:select.option value="yang_lainnya">Lainnya</flux:select.option>
            <flux:select.option value="tidak_ingin_menyebutkan">Tidak ingin menyebutkan</flux:select.option>
        </flux:select>

        <!-- Organization Type -->
        <flux:select
            wire:model.live="organization_type"
            :label="'Tipe Organisasi'"
            required
            :placeholder="'Pilih tipe organisasi'"
        >
            <flux:select.option value="organisasi">Organisasi</flux:select.option>
            <flux:select.option value="komunitas">Komunitas</flux:select.option>
            <flux:select.option value="individu">Individu</flux:select.option>
        </flux:select>

        <!-- Organization Name -->
        <flux:input
            wire:model.live="organization_name"
            :label="'Nama Organisasi/Komunitas'"
            type="text"
            :required="$organization_type === 'organisasi' || $organization_type === 'komunitas'"
            :disabled="!$organization_type"
            :readonly="$organization_type === 'individu'"
            :placeholder="$organization_type === 'individu' ? 'Individu' : ($organization_type ? 'Masukkan nama organisasi atau komunitas' : 'Pilih tipe organisasi terlebih dahulu')"
        />

        <!-- Phone Number -->
        <flux:input
            wire:model="phone_number"
            :label="'Nomor Telepon'"
            type="tel"
            required
            :placeholder="'Masukkan nomor telepon'"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="'Kata sandi'"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="'Kata sandi'"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="'Konfirmasi kata sandi'"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="'Konfirmasi kata sandi'"
            viewable
        />

        <!-- Registration Key -->
        <flux:input
            wire:model="registration_key"
            :label="'Kode Registrasi'"
            type="text"
            required
            :placeholder="'Masukkan kode registrasi yang diberikan admin'"
        />
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Kode registrasi menentukan tipe akun Anda (Partisipan, Tamu, atau Komunitas). Hubungi administrator untuk mendapatkan kode registrasi.
        </p>

        <div class="flex items-center justify-end">
            <flux:button wire:click="register" variant="primary" class="w-full cursor-pointer">
                {{ 'Buat akun' }}
            </flux:button>
        </div>
    </div>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
        <span>{{ 'Sudah punya akun?' }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ 'Masuk' }}</flux:link>
    </div>
    @endif
</div>
