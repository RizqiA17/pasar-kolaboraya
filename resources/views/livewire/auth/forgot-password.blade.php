 <div class="flex flex-col gap-6">
    <x-auth-header :title="__('Lupa Kata Sandi')" :description="__('Masukkan email Anda untuk menerima tautan reset kata sandi')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Alamat Email')"
            type="email"
            required
            autofocus
            placeholder="contoh@gmail.com"
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Kirim tautan reset kata sandi') }}</flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        <span>{{ __('Atau, kembali ke') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('masuk') }}</flux:link>
    </div>
</div>
