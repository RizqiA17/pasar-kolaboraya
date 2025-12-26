<div class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
    <div class="flex items-center justify-between">
        <div>
            <p class="mb-1 text-sm font-bold text-gray-900 dark:text-slate-200">{{ $title }}</p>
            <p class="text-2xl font-bold sm:text-3xl {{ $iconColor }}">
                {{ $stats }}</p>
        </div>
        @if (isset($icon))
            <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 {{ $iconBg }} rounded-xl">
                <flux:icon name="{{ $icon }}" class="w-5 h-5 sm:w-6 sm:h-6 {{ $iconColor }}" />
            </div>
        @endif
    </div>
    @if (isset($link))
        <flux:link href="{{ $link }}" wire:navigate
            class="inline-flex items-end flex-grow text-xs font-medium transition-colors">
            Lihat Semua
            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </flux:link>
    @endif
</div>
