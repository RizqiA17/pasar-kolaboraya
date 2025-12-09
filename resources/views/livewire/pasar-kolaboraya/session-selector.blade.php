<div class="max-w-4xl mx-auto p-6">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Pilih Sesi Pasar Kolaboraya
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Pilih sesi aktif Anda untuk mengakses fitur kolaborasi
        </p>
    </div>

    <!-- My Pasar Kolaboraya -->
    @if($pasarKolaborayas->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Pasar Kolaboraya Saya
            </h2>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($pasarKolaborayas as $pasarKolaboraya)
                    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg  p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $pasarKolaboraya->name }}
                                </h3>
                                @if($pasarKolaboraya->description)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                        {{ Str::limit($pasarKolaboraya->description, 100) }}
                                    </p>
                                @endif
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($pasarKolaboraya->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($pasarKolaboraya->status === 'inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                @endif">
                                {{ $pasarKolaboraya->status_label }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center">
                                <flux:icon.user class="w-4 h-4 mr-1" />
                                {{ $pasarKolaboraya->acceptedUsers->count() }} anggota
                            </div>
                            <div class="flex items-center">
                                <flux:icon.calendar class="w-4 h-4 mr-1" />
                                {{ $pasarKolaboraya->created_at->format('d M Y') }}
                            </div>
                        </div>

                        @if($pasarKolaboraya->status === 'active')
                            <flux:button 
                                wire:click="selectSession({{ $pasarKolaboraya->id }})"
                                variant="primary"
                                class="w-full"
                            >
                                Pilih Sesi Ini
                            </flux:button>
                        @else
                            <flux:button 
                                {{-- variant="secondary" --}}
                                class="w-full"
                                disabled
                            >
                                @if($pasarKolaboraya->status === 'inactive')
                                    Sesi Tidak Aktif
                                @else
                                    Sesi Tidak Tersedia
                                @endif
                            </flux:button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Available Pasar Kolaboraya -->
    {{-- @if($availablePasarKolaborayas->count() > 0)
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Pasar Kolaboraya Tersedia
            </h2>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($availablePasarKolaborayas as $pasarKolaboraya)
                    <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 rounded-lg  p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $pasarKolaboraya->name }}
                                </h3>
                                @if($pasarKolaboraya->description)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                        {{ Str::limit($pasarKolaboraya->description, 100) }}
                                    </p>
                                @endif
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                Tersedia
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center">
                                <flux:icon.user class="w-4 h-4 mr-1" />
                                {{ $pasarKolaboraya->acceptedUsers->count() }} anggota
                            </div>
                            <div class="flex items-center">
                                <flux:icon.user class="w-4 h-4 mr-1" />
                                Oleh {{ $pasarKolaboraya->creator->name }}
                            </div>
                        </div>

                        <flux:button 
                            wire:click="requestToJoin({{ $pasarKolaboraya->id }})"
                            class="w-full"
                        >
                            Minta Bergabung
                        </flux:button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif --}}

    <!-- No Pasar Kolaboraya -->
    @if($pasarKolaborayas->count() === 0 && $availablePasarKolaborayas->count() === 0)
        <div class="text-center py-12">
            <flux:icon.cube class="w-16 h-16 text-gray-400 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                Belum ada Pasar Kolaboraya
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">
                Anda belum bergabung dengan Pasar Kolaboraya mana pun. Hubungi admin untuk diundang.
            </p>
            <flux:button 
                href="{{ route('dashboard') }}"
                variant="primary"
            >
                Kembali ke Dashboard
            </flux:button>
        </div>
    @endif
</div>
