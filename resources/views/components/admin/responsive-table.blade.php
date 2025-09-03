@props([
    'items' => [],
    'mobileCardView' => null,
    'desktopTableView' => null,
    'emptyMessage' => 'Tidak ada data ditemukan',
    'emptyIcon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
])

<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
    @if($items->count() > 0)
        <!-- Mobile Card View (hidden on larger screens) -->
        <div class="block lg:hidden">
            @foreach($items as $item)
                {{ $mobileCardView($item) }}
            @endforeach
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto">
            {{ $desktopTableView }}
        </div>
    @else
        <!-- Empty State -->
        <div class="p-8 text-center">
            <div class="text-slate-500 dark:text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $emptyIcon }}"></path>
                </svg>
                <p class="text-lg font-medium">{{ $emptyMessage }}</p>
                <p class="text-sm">Coba sesuaikan kriteria pencarian Anda</p>
            </div>
        </div>
    @endif
</div>
