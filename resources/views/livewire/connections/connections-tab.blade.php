<section class="">
    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
        {{-- Header with Search --}}
        <div class="p-6 border-b border-neutral-100">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-navy">Temukan Kreator Perubahan</h2>
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" placeholder="Cari kreator..." class="block w-full pl-10 pr-4 py-2 text-sm border border-neutral-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="flex border-b border-neutral-100">
            <button wire:click="setTab('suggestion')"
                class="px-8 py-4 text-sm font-medium transition-colors relative {{ $tab === 'suggestion' ? 'text-sky-600 border-sky-600 border-b-2' : 'text-neutral-600 hover:text-sky-600 hover:bg-sky-50' }}">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Rekomendasi
                </div>
            </button>

            <button wire:click="setTab('list')" 
                class="px-8 py-4 text-sm font-medium transition-colors relative {{ $tab === 'list' ? 'text-sky-600 border-sky-600 border-b-2' : 'text-neutral-600 hover:text-sky-600 hover:bg-sky-50' }}">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Koneksi
                </div>
            </button>
        </div>

        {{-- Tab Content --}}
        <div class="p-6">
            @if ($tab === 'list')
                <livewire:connections.list-connection />
            @elseif ($tab === 'suggestion')
                <livewire:connections.suggestion />
            @endif
        </div>
    </div>
</section>
