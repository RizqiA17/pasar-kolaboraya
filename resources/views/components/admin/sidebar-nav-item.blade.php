<a href="{{ route($route)  }}" wire:navigate
    class="group flex items-center px-2 sm:px-3 py-2 sm:py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs($route.'*') ? 'bg-primary-blue/5 dark:bg-secondary-green/10 text-primary-blue dark:text-secondary-green' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-slate-200' }}">
    <flux:icon name="{{$icon}}" class="mr-3 h-5 w-5 flex-shrink-0" />
    <span class="truncate">{{ $label }}</span>
</a>
