<section>
    @if (count($requests ?? []) === 0)
        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-neutral-900 mb-1">Tidak Ada Permintaan</h3>
            <p class="text-neutral-500 max-w-sm mx-auto">Saat ini tidak ada permintaan koneksi yang menunggu.</p>
        </div>
    @else
        <div class="divide-y">
            @foreach ($requests as $request)
                <div class="p-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-sky-100 to-blue-50 flex items-center justify-center text-sky-700 text-xl font-medium border border-sky-100">
                                {{ substr($request['name'], 0, 2) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-neutral-900">{{ $request['name'] }}</h3>
                            <p class="text-sm text-neutral-500 mb-3">{{ $request['mutual_count'] }} mutual friends</p>
                            
                            <div class="flex gap-2">
                                <button wire:click="acceptRequest({{ $request['id'] }})" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                    Konfirmasi
                                </button>
                                <button wire:click="rejectRequest({{ $request['id'] }})" class="flex-1 bg-neutral-200 hover:bg-neutral-300 text-neutral-700 px-4 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
