<div
    class="col-span-1 mt-auto flex group relative overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 h-44 py-5 px-6 max-h-full flex-col">
    <div class="relative z-10 flex flex-col flex-grow">
        <div class="absolute top-0 right-0 w-16 h-16 opacity-10">
            <img src="{{ Storage::url('web/ASET VISUAL/WEBP/7.webp') }}" alt=""
                class="w-full h-full object-contain">
        </div>
        <div class="flex items-center justify-between mb-2">
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-200">QR Code
                    Saya
                </h3>
                <p class="text-gray-700 dark:text-slate-300 text-sm">Akses ke Pasar Kolaboraya
                </p>
            </div>
            <div class="w-12 h-12 bg-secondary-green rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 dark:text-slate-400 text-xs mb-3">Tunjukkan QR code ini kepada
            admin untuk masuk ke Pasar Kolaboraya</p>
        <flux:link wire:navigate href="{{ route('qr.show') }}"
            class="inline-flex items-end pb-2 text-xs font-medium transition-colors flex-grow">
            Lihat QR Code
            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </flux:link>
    </div>
</div>
