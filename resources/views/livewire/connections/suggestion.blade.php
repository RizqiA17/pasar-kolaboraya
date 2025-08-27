<section>
    @if (count($recommendations) === 0)
        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-neutral-900 mb-1">Tidak Ada Rekomendasi</h3>
            <p class="text-neutral-500 max-w-sm mx-auto">Kami akan memberikan rekomendasi kreator yang mungkin Anda kenal segera.</p>
        </div>
    @else
        <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4 p-4">
            @foreach ($recommendations as $rec)
                <div class="bg-white rounded-xl border border-neutral-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="aspect-[4/3] bg-gradient-to-br from-neutral-100 to-neutral-50 flex items-center justify-center">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-sky-100 to-blue-50 flex items-center justify-center text-sky-700 text-2xl font-medium border border-sky-100">
                            {{ substr($rec['name'], 0, 2) }}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-neutral-900 mb-1">{{ $rec['name'] }}</h3>
                        <p class="text-sm text-neutral-500 mb-4">{{ $rec['mutual_count'] }} mutual friends</p>
                        
                        <div class="flex gap-2">
                            <button wire:click="sendRequest({{ $rec['id'] }})" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Connect
                            </button>
                            <button class="px-4 py-2 border border-neutral-200 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition-colors">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
