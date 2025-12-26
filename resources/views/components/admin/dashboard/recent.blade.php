<div
    class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! dark:border-slate-700">
    <div class="flex items-center justify-between mb-3 sm:mb-4">
        <h3 class="text-base font-semibold {{ $titleColor }}">{{ $title }}</h3>
        <a href="{{ $link }}" class="text-xs {{ $titleColor }} {{ $linkHoverColor }}">Lihat
            semua</a>
    </div>
    <div class="space-y-3">
        {{ $slot }}
    </div>
</div>
