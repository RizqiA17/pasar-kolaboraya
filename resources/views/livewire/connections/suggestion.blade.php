<section>

    @if (count($recommendations) === 0)
        <p class="text-gray-500 text-center py-4">Tidak ada rekomendasi orang saat ini.</p>
    @else
        @foreach ($recommendations as $rec)
            <div class="p-3 border-b flex justify-between items-center">
                <div>
                    <strong>{{ $rec['name'] }}</strong><br>
                    <span class="text-sm text-gray-500">{{ $rec['mutual_count'] }} mutual friends</span>
                </div>
                <button wire:click="sendRequest({{ $rec['id'] }})" class="bg-blue-500 text-white px-3 py-1 rounded">
                    Connect
                </button>
            </div>
        @endforeach
    @endif
</section>
