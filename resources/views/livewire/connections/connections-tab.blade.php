<section>

    <div class="grid md:grid-cols-2">
        {{-- Tabs Navigation --}}
        <div class="flex col-span-1 space-x-4 mb-4">
            <button wire:click="setTab('qr-scan')"
                class="px-4 py-2 font-medium {{ $tab === 'qr-scan' ? 'border-b-2 border-sky-500 text-sky-600' : 'text-neutral-600 hover:text-sky-600' }}">
                Scan QR
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

        {{-- SearchBar hanya muncul di tab "list" --}}
        <div class="col-span-1 w-full flex justify-end max-md:mb-8">
            @if ($tab === 'list')
                <livewire:components.search-bar :placeholder="'Cari Koneksi...'" :model="\App\Models\Connection::class" :fields="['requester.name', 'receiver.name']"
                    wire:model="results" searchFocus="list" />
            @endif
        </div>
    </div>
    {{-- Content Sections --}}
    @if ($tab === 'requests')
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4">
                <livewire:connections.requested-connection :isContent="true" />
            </div>
        </div>
    @endif

    @if ($tab === 'qr-scan')
        <livewire:connections.qr-scanner />
    @endif

    @if ($tab === 'list')
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-neutral-100 dark:border-slate-700">
                <h2 class="text-lg font-semibold">Semua Koneksi</h2>
            </div>
            @if ($searchResults)
                <livewire:connections.list-connection />
            @else
                <livewire:connections.list-connection />
            @endif
        </div>
    @endif
    <script>
        window.addEventListener('update-page-title', event => {
            document.title = "Kolaboraya - " + event.detail.title;
        });
    </script>

</section>
