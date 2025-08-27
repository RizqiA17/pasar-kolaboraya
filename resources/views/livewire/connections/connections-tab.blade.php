<section>

    <div class="flex justify-between items-center">
        {{-- Tabs Navigation --}}
        <div class="flex space-x-4 mb-4">
            <button wire:click="setTab('suggestion')"
                class="px-4 py-2 font-medium {{ $tab === 'suggestion' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-neutral-600 hover:text-sky-600' }}">
                Rekomendasi
            </button>

            <button wire:click="setTab('list')"
                class="px-4 py-2 font-medium {{ $tab === 'list' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-neutral-600 hover:text-sky-600' }}">
                Koneksi
            </button>

            <button wire:click="setTab('requests')"
                class="px-4 py-2 font-medium relative {{ $tab === 'requests' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-neutral-600 hover:text-sky-600' }}">
                Permintaan
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
            </button>
        </div>
        {{-- Search Bar --}}
        <div class="mb-6">
            <div class="relative max-w-xl w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="search" placeholder="Cari kreator..."
                    class="block w-full pl-10 pr-4 py-2.5 text-sm border border-neutral-200 rounded-lg bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            </div>
        </div>
    </div>

    {{-- Content Sections --}}
    @if ($tab === 'requests')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Permintaan Koneksi</h2>
                <a href="#" class="text-sm text-sky-600 hover:text-sky-700">Lihat Semua</a>
            </div>
            <div class="p-4">
                <livewire:connections.requested-connection />
            </div>
        </div>
    @endif

    @if ($tab === 'suggestion')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Rekomendasi untuk Anda</h2>
                <a href="#" class="text-sm text-sky-600 hover:text-sky-700">Lihat Semua</a>
            </div>
            <livewire:connections.suggestion />
        </div>
    @endif

    @if ($tab === 'list')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100">
                <h2 class="text-lg font-semibold">Semua Koneksi</h2>
            </div>
            <livewire:connections.list-connection />
        </div>
    @endif
</section>
