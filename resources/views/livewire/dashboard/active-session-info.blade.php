@if($hasActiveSession)
    <div class="h-fit bg-blue-50 dark:bg-green-700/20 rounded-xl p-4 border border-blue-200 dark:border-secondary-green/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-teal-800 rounded-full flex items-center justify-center">
                    <flux:icon.cube class="w-5 h-5 text-blue-600 dark:text-green-300" />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-800 dark:text-secondary-green">
                        Sesi Aktif
                    </h3>
                    <p class="text-gray-700 dark:text-slate-300 text-xs">
                        {{ $activePasarKolaboraya['name'] }}
                    </p>
                    <p class="text-xs text-blue-600 dark:text-secondary-green">
                        {{ $memberCount }} anggota aktif
                    </p>
                </div>
            </div>
            <flux:button 
                href="{{route('pasar-kolaboraya.select')}}"
                size="xs"
                variant="primary"
                class=""
                wire:navigate
            >
                Ganti Sesi
            </flux:button>
        </div>
    </div>
@else
    <div class="h-fit bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-200 dark:border-accent-orange/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-800 rounded-full flex items-center justify-center">
                <flux:icon.exclamation-triangle class="w-5 h-5 text-amber-600 dark:text-amber-300" />
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">
                    Belum Ada Sesi Aktif
                </h3>
                <p class="text-xs text-amber-600 dark:text-amber-300">
                    Pilih sesi Pasar Kolaboraya untuk memulai kolaborasi
                </p>
            </div>
            <flux:button 
                href="{{ route('pasar-kolaboraya.select') }}"
                size="xs"
                wire:navigate
                class="text-amber-600 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-800"
            >
                Pilih Sesi
            </flux:button>
        </div>
    </div>
@endif
