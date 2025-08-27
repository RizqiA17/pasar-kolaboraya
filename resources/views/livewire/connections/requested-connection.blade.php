<div wire:poll.3s="loadRequests" wire:poll.stop="!pollingState">
    <h2 class="text-sm font-bold mb-2">Permintaan Pertemanan</h2>
    <ul class="space-y-2 max-h-60 overflow-y-auto">
        @forelse ($requests as $req)
            <li class="p-2 border rounded flex justify-between items-center">
                <span>{{ $req['sender']['name'] }}</span>
                <div class="space-x-2">
                    <button wire:click="accept({{ $req['id'] }})" class="px-2 py-1 bg-green-500 text-white rounded text-xs">✔</button>
                    <button wire:click="reject({{ $req['id'] }})" class="px-2 py-1 bg-red-500 text-white rounded text-xs">✖</button>
                </div>
            </li>
        @empty
            <li class="text-gray-500 text-sm">Tidak ada permintaan.</li>
        @endforelse
    </ul>
</div>
