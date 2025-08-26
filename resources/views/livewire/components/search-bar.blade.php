<div class="relative w-full max-w-md">
    <flux:input wire:model="search" :label="__()" type="text" class="w-full" autofocus autocomplete=""
        placeholder="{{ $placeholder }}" />

    @if (!empty($results))
        <div class="absolute bg-white border rounded-lg shadow-lg mt-1 w-full z-10 max-h-60 overflow-y-auto">
            @foreach ($results as $item)
                <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" wire:click="selectResult({{ $item['id'] }})">
                    {{ $item[$field] }}
                </div>
            @endforeach
        </div>
    @endif
</div>
