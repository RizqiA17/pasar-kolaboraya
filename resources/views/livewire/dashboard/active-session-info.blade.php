@if($hasActiveSession)
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                    <flux:icon.cube class="w-5 h-5 text-blue-600 dark:text-blue-300" />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                        Sesi Aktif
                    </h3>
                    <p class="text-xs text-blue-600 dark:text-blue-300 font-medium">
                        {{ $activePasarKolaboraya->name }}
                    </p>
                    <p class="text-xs text-blue-500 dark:text-blue-400">
                        {{ $memberCount }} anggota aktif
                    </p>
                </div>
            </div>
            <flux:button 
                wire:click="switchSession"
                size="xs"
                {{-- variant="secondary" --}}
                class="text-blue-600 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-800"
            >
                Ganti Sesi
            </flux:button>
        </div>
    </div>
@else
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800">
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
                {{-- variant="secondary" --}}
                class="text-amber-600 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-800"
            >
                Pilih Sesi
            </flux:button>
        </div>
    </div>
@endif
