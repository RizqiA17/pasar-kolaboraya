<div class="p-4 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-8 h-8" opacity="opacity-10" />
    
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Undangan Kolaborasi</h3>
        @if(count($requests) > 0)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                {{ count($requests) }} undangan
            </span>
        @endif
    </div>

    @if(count($requests) > 0)
        <div class="space-y-3 max-h-64 overflow-y-auto">
            @foreach($requests as $request)
                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-600 rounded-lg relative">
                    <!-- SVG Accent for Request Item -->
                    <x-svg-accent position="top-right" size="w-4 h-4" opacity="opacity-5" />
                    
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $request['collaboration']['title'] }}
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ $request['collaboration']['description'] ?? 'Tidak ada deskripsi' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                Oleh: <span class="font-medium">{{ $request['creator']['name'] }}</span>
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                                {{ \Carbon\Carbon::parse($request['created_at'])->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 mt-3">
                        <button wire:click="accept({{ $request['collaboration_id'] }})"
                                class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima
                        </button>
                        <button wire:click="reject({{ $request['collaboration_id'] }})"
                                class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-6">
            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada undangan kolaborasi</p>
            <p class="text-xs text-gray-400 dark:text-gray-600">Undangan akan muncul di sini</p>
        </div>
    @endif

    @if(count($requests) > 0)
        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
            <div class="text-center">
                <a href="{{ route('collaborations.manage') }}" 
                   class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Lihat Semua Undangan →
                </a>
            </div>
        </div>
    @endif
</div>
