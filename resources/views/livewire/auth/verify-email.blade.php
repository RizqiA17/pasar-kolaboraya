<div class="mt-4 flex flex-col gap-6">
    <flux:text class="text-center">
        {{ 'Silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan.' }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text class="text-center font-medium !text-green-600">
            {{ 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.' }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full cursor-pointer">
            @if (Auth::user()->hasVerifiedEmail())
                {{ 'Email sudah terverifikasi, masuk ke akun Anda' }}
            @else
                {{ 'Kirim ulang email verifikasi' }}
            @endif
        </flux:button>
        <flux:link class="text-sm cursor-pointer" wire:click="logout">
            {{ 'Keluar' }}
        </flux:link>
    </div>
</div>
