<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset Kata Sandi')" :description="__('Silakan masukkan kata sandi baru Anda di bawah ini')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <div class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Kata Sandi')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Kata Sandi')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Konfirmasi Kata Sandi')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Konfirmasi Kata Sandi')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button wire:click="resetPassword" variant="primary" class="w-full">
                {{ __('Reset Kata Sandi') }}
            </flux:button>
        </div>
    </div>
</div>
