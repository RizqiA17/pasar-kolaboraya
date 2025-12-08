<div wire:ignore.self
    class="col-span-1 group relative overflow-hidden rounded-xl p-5 text-gray-900 dark:text-slate-200 shadow-lg hover:shadow-xl transition-transform duration-500 hover:scale-105 bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! dark:border-slate-700 flex flex-col h-44">
    <div class="relative z-10 flex flex-col flex-grow">
        <div class="flex items-center justify-between mb-3">
            <div
                class="w-10 h-10 {{$iconBgColor}} rounded-lg flex items-center justify-center backdrop-blur-sm">
                <flux:icon name="{{ $icon }}" class='size-5 {{ $iconColor }}' />
            </div>
            <div class="text-right">
                <div class="text-xl font-bold text-gray-900 dark:text-slate-200">
                    <div>
                        {{ $count }}
                    </div>
                    <div class="text-gray-900 dark:text-slate-300 text-xs">Total</div>
                </div>
            </div>
        </div>
        <h3 class="text-sm font-bold mb-1 text-gray-900 dark:text-slate-200">{{ $title }}</h3>
        <p class="text-gray-900 dark:text-slate-300 mb-3 text-xs">{{ $description }}</p>
        <flux:link href="{{ $link }}" wire:navigate
            class="inline-flex items-end pb-2 text-xs font-medium transition-colors flex-grow">
            Lihat Semua
            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </flux:link>
    </div>
</div>
