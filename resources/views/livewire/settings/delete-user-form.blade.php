<section class="mt-10 space-y-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-12 h-12" opacity="opacity-10" />
    
    <div class="relative mb-5">
        <flux:heading>{{ __('Hapus Akun') }}</flux:heading>
        <flux:subheading>{{ __('Hapus akun Anda dan semua sumber dayanya') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Hapus Akun') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <div class="relative">
            <!-- SVG Accent for Modal -->
            <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-5" />
            
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Are you sure you want to delete your account?') }}</flux:heading>

                    <flux:subheading>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </flux:subheading>
                </div>

                <flux:input wire:model="password" :label="__('Password')" type="password" />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>

                    <flux:button wire:click="deleteUser" variant="danger">{{ __('Delete account') }}</flux:button>
                </div>
            </div>
        </div>
    </flux:modal>
</section>
