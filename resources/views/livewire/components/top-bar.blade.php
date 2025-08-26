<div class="bg-white shadow">
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Search Bar -->
            <div class="flex-1 flex items-center">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" id="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ $searchPlaceholder }}" type="search">
                    </div>
                </div>
            </div>
            @if ($tab === 'suggestion')
                @include('partials.head', [
                    'title' => 'Daftar Koneksi',
                ])
                <livewire:components.search-bar :model="\App\Models\User::class" :fields="['name']" :placeholder="'Cari orang...'" />
            @endif

            <button wire:click="setTab('suggestion')"
                class="{{ $tab === 'suggestion' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
                Rekomendasi
            </button>

            <button wire:click="setTab('list')"
                class="{{ $tab === 'list' ? 'border-b-2 border-blue-500 font-bold' : '' }}">
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
