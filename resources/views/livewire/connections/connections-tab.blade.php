<section class="mx-auto max-w-7xl min-w-0">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Tabs Navigation --}}
        <div class="flex flex-wrap col-span-1 space-x-2 sm:space-x-4 mb-4">
            <button wire:click="setTab('qr-scan')"
                class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                    {{ $tab === 'qr-scan'
                        ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                        : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                Kode
            </button>

            <button wire:click="setTab('list')"
                class="px-3 sm:px-4 py-2 font-medium text-sm sm:text-base
                    {{ $tab === 'list'
                        ? 'border-b-2 border-sky-500 text-sky-600 dark:border-secondary-green dark:text-secondary-green'
                        : 'text-neutral-600 hover:text-sky-600 dark:text-neutral-300 dark:hover:text-secondary-green' }}">
                Koneksi
            </button>
        </div>
    </div>
    {{-- Content Sections --}}
    @if ($tab === 'qr-scan')
        <livewire:connections.qr-scanner />
    @endif

    @if ($tab === 'list')
        <livewire:connections.list-connection />
    @endif
    <script>
        window.addEventListener('update-page-title', event => {
            document.title = "Kolaboraya - " + event.detail.title;
        });
    </script>

</section>
