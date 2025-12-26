<div
    class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 backdrop-blur-sm dark:border-t! dark:border-slate-700">
    <div class="flex items-center justify-between">
        <div>
            <p class="mb-1 text-sm font-bold text-gray-900 dark:text-slate-200">{{ $title }}</p>
            <p class="text-2xl font-bold sm:text-3xl text-primary-blue dark:text-secondary-green">
                {{ $stats }}</p>
        </div>
        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 {{ $iconBg }} rounded-xl">
            <flux:icon name="{{ $icon }}" class="w-5 h-5 sm:w-6 sm:h-6 {{ $iconColor }}" />
        </div>
    </div>
</div>
