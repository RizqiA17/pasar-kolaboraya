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
            </button>
        </div>
        {{-- Search Bar --}}
        {{-- SearchBar hanya muncul di tab "suggestion" --}}
        @if ($tab === 'suggestion')
            <livewire:components.search-bar :placeholder="'Cari Kreator...'" :model="\App\Models\User::class" :fields="['name']" wire:model="results"
                searchFocus="suggestion" />
        @elseif ($tab === 'list')
            <livewire:components.search-bar :placeholder="'Cari Koneksi...'" :model="\App\Models\Connection::class" :fields="['requester.name', 'receiver.name']" wire:model="results"
                searchFocus="list" />


            {{-- Debug: tampilkan hasil pencarian dari SearchBar --}}
            {{-- <div class="mt-4">
                <h3 class="font-bold">Hasil dari Child SearchBar:</h3>
                <pre>{{ print_r($searchResults, true) }}</pre>
            </div> --}}
        @endif
    </div>


    {{-- Content Sections --}}
    @if ($tab === 'requests')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Permintaan Koneksi</h2>
            </div>
            <div class="p-4">
                <livewire:connections.requested-connection />
            </div>
        </div>
    @endif

    @if ($tab === 'suggestion')
        <livewire:connections.suggestion />
    @endif

    @if ($tab === 'list')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100">
                <h2 class="text-lg font-semibold">Semua Koneksi</h2>
            </div>
            @if ($searchResults)
                <livewire:connections.list-connection />
            @else
                <livewire:connections.list-connection />
            @endif
        </div>
    @endif
</section>
