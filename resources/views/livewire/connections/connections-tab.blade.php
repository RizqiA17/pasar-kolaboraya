<section>

    {{-- Tabs --}}
    <div class="flex space-x-4 mb-4">

        <button wire:click="setTab('suggestion')"
            class="{{ $tab === 'suggestion' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
            Rekomendasi
        </button>

        <button wire:click="setTab('list')" class="{{ $tab === 'list' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
            Koneksi
        </button>

    </div>

    {{-- Content --}}
    <div>
        @if ($tab === 'list')
            <livewire:connections.list-connection />
        @elseif ($tab === 'suggestion')
            <livewire:connections.suggestion />
        @endif
    </div>
</section>
