<div class="flex flex-col gap-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-12 h-12" opacity="opacity-10" />
    
    <x-auth-header :title="'Masuk ke akun Anda'" :description="'Masukkan email dan kata sandi Anda untuk masuk'" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <div class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="'Alamat email'"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="contoh@gmail.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="'Kata sandi'"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="'Kata sandi'"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ 'Lupa kata sandi?' }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="'Ingat saya'" class="cursor-pointer"/>

        <div class="flex items-center justify-end">
            <flux:button wire:click="login" variant="primary" class="w-full cursor-pointer">{{ 'Masuk' }}</flux:button>
        </div>
    </div>

        @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-slate-400">
            <span>{{ 'Belum punya akun?' }}</span>
            <flux:link :href="route('register')" wire:navigate class="">{{ 'Daftar' }}</flux:link>
        </div>
    @endif
</div>
