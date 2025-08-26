<section>

    {{-- Tabs --}}
    <div class="flex space-x-4 mb-4">

        @if ($tab === 'list')
            @include('partials.head', [
                'title' => 'Rekomendasi Orang',
            ])
            <livewire:components.search-bar :model="\App\Models\User::class" :fields="['name']" :placeholder="'Cari koneksi...'" />
        @elseif ($tab === 'suggestion')
            @include('partials.head', [
                'title' => 'Daftar Koneksi',
            ])
            <livewire:components.search-bar :model="\App\Models\User::class" :fields="['name']" :placeholder="'Cari orang...'" />
        @endif

        <button wire:click="setTab('suggestion')"
            class="{{ $tab === 'suggestion' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
            Rekomendasi
        </button>

        <button wire:click="setTab('list')" class="{{ $tab === 'list' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
            Koneksi
        </button>

        <div class="ms-auto relative">

            {{-- Dropdown --}}
            <x-flux::dropdown align="right" width="64">
                <flux:button icon="bell" class="m-auto text-gray-100 bg-neutral-600 rounded-full size-10">
                </flux:button>

                <flux:menu>
                    <div class="p-3 w-64">
                        {{-- Panggil komponen Livewire di dalam dropdown --}}
                        <livewire:connections.requested-connection />
                    </div>
                </flux:menu>
            </x-flux::dropdown>
        </div>

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
