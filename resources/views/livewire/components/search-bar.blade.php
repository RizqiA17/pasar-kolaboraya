<div class="relative w-full max-w-md">
    <form wire:submit.prevent="search">
        <flux:input.group>
            <flux:input wire:model="query" type="text" class="w-full" autofocus autocomplete="off"
                placeholder="{{ $placeholder }}" />

            <flux:button type="submit" icon="magnifying-glass">
            </flux:button>
        </flux:input.group>
    </form>

    @if (!empty($results))
        <div class="absolute bg-white border rounded-lg shadow-lg mt-1 w-full z-10 max-h-60 overflow-y-auto">
            @foreach ($results as $group => $items)
                @if (!empty($items))
                    <div class="px-4 py-2 text-xs font-bold text-gray-500 bg-gray-100">
                        {{ $group }}
                    </div>
                    @foreach ($items as $item)
                        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                            wire:click="selectResult('{{ $item['id'] }}', '{{ $group }}')">
                            {{ $item['display'] }}
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    @elseif (!empty($query))
        <div class="absolute bg-white border rounded-lg shadow-lg mt-1 w-full z-10 max-h-60 overflow-y-auto">
            <div class="px-4 py-2 text-xs font-bold text-gray-500 bg-gray-100">
                Tidak ada hasil
            </div>
        </div>
    @endif
</div>
