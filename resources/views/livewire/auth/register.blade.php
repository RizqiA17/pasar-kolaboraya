<div class="flex flex-col gap-6">
    <x-auth-header :title="'Buat akun baru'" :description="'Masukkan data Anda untuk membuat akun'" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
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
            placeholder="email@example.com"
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
            <flux:button type="submit" variant="primary" class="w-full">
                {{ 'Buat akun' }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600">
        <span>{{ 'Sudah punya akun?' }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ 'Masuk' }}</flux:link>
    </div>
</div>
