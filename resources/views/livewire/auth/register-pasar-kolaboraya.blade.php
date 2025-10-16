<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-12 h-12" opacity="opacity-10" />
    
    <x-auth-header :title="'Daftar Pasar Kolaboraya'" :description="'Bergabung langsung dengan Pasar Kolaboraya tanpa kode registrasi'" />

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
    @elseif(!$pasarKolaboraya)
        <!-- Pasar Kolaboraya Not Found -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6 text-center">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-2">
                Pasar Kolaboraya Tidak Ditemukan
            </h3>
            <p class="text-yellow-700 dark:text-yellow-300 mb-4">
                Pasar Kolaboraya yang Anda cari tidak ditemukan atau tidak aktif.
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Registrasi Normal
            </a>
        </div>
    @else
        <!-- Event Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-6">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                    Registrasi Event
                </h3>
            </div>
            <p class="text-sm text-blue-700 dark:text-blue-300">
                Anda akan bergabung dengan <strong>{{ $pasarKolaboraya->name }}</strong> sebagai Komunitas.
            </p>
        </div>

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
                <flux:select.option value="komunitas">Komunitas</flux:select.option>
                <flux:select.option value="organisasi">Organisasi</flux:select.option>
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

            <div class="flex items-center justify-end">
                <flux:button wire:click="register" variant="primary" class="w-full cursor-pointer">
                    {{ 'Bergabung dengan Pasar Kolaboraya' }}
                </flux:button>
            </div>
        </div>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
            <span>{{ 'Sudah punya akun?' }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ 'Masuk' }}</flux:link>
        </div>
    @endif
</div>
