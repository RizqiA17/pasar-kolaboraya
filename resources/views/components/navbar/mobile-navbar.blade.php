<div class="fixed bottom-0 left-0 right-0 z-50 lg:hidden">
    <!-- Background with glassmorphism effect -->
    <div
        class="border-t shadow-2xl bg-cream/80 border-white/20 dark:bg-slate-900/90 backdrop-blur-xl dark:border-slate-700 shadow-blue-500/20">
        <!-- Background gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-pink-600/5 none"></div>

        <!-- Navigation Items -->
        <div class="relative flex items-center justify-around">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center py-4 transition-all duration-300 size-20 rounded-2xl group h-fit"
                wire:navigate>
                <div class="w-6 h-6 mb-1">
                    <svg class="w-full h-full transition-colors duration-200
                                {{ request()->routeIs('dashboard') ? 'stroke-blue-600 dark:stroke-blue-400' : 'stroke-slate-600 group-hover:stroke-blue-600 dark:stroke-slate-300 dark:group-hover:stroke-blue-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                </div>
                <span
                    class="text-xs font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-600 group-hover:text-blue-600 dark:text-slate-300 dark:group-hover:text-blue-400' }}">
                    {{ __('Beranda') }}
                </span>
            </a>

            <!-- Connections -->
            @if ($connectionsEnabled && $hasActiveMarketSession)
                <a href="{{ route('connections') }}"
                    class="flex flex-col items-center justify-center py-4 transition-all duration-300 size-20 rounded-2xl group h-fit"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('connections') ? 'stroke-indigo-600 dark:stroke-indigo-400' : 'stroke-slate-600 group-hover:stroke-indigo-600 dark:stroke-slate-300 dark:group-hover:stroke-indigo-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xs font-medium transition-colors duration-200
                                    {{ request()->routeIs('connections') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-600 group-hover:text-indigo-600 dark:text-slate-300 dark:group-hover:text-indigo-400' }}">
                        {{ __('Koneksi') }}
                    </span>
                </a>
            @else
                <div class="flex flex-col items-center justify-center cursor-not-allowed size-20 rounded-2xl opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ __('Koneksi') }}</span>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 px-3 py-2 mt-2 text-xs text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                        <span>
                            @if (!$hasActiveMarketSession)
                                Bergabung dengan sesi pasar terlebih dahulu
                            @else
                                Fitur koneksi sedang dinonaktifkan sedang dinonaktifkan oleh administrator.
                            @endif
                        </span>
                        <div
                            class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Ekosistem -->
            @if ($collaborationsEnabled && $hasActiveMarketSession)
                <a href="{{ route('ecosystem.browse') }}"
                    class="flex flex-col items-center justify-center py-4 transition-all duration-300 size-20 rounded-2xl group h-fit"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('ecosystem.*') ? 'stroke-green-600 dark:stroke-green-400' : 'stroke-slate-600 group-hover:stroke-green-600 dark:stroke-slate-300 dark:group-hover:stroke-green-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xs font-medium transition-colors duration-200
                                    {{ request()->routeIs('ecosystem.*') ? 'text-green-600 dark:text-green-400' : 'text-slate-600 group-hover:text-green-600 dark:text-slate-300 dark:group-hover:text-green-400' }}">
                        {{ __('Kolaborasi') }}
                    </span>
                </a>
            @else
                <div class="flex flex-col items-center justify-center cursor-not-allowed size-20 rounded-2xl opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ __('Kolaborasi') }}</span>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 px-3 py-2 mt-2 text-xs text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                        <span>
                            @if (!$hasActiveMarketSession)
                                Bergabung dengan sesi pasar terlebih dahulu
                            @elseif(!$collaborationsEnabled)
                                Fitur kolaborasi sedang dinonaktifkan oleh administrator.
                            @endif
                        </span>
                        <div
                            class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Aksi Kolektif -->
            @if ($userActionsEnabled && $hasActiveMarketSession)
                <a href="{{ route('collective-action.browse') }}"
                    class="flex flex-col items-center justify-center py-4 transition-all duration-300 size-20 rounded-2xl group h-fit"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('collective-action.*') ? 'stroke-purple-600 dark:stroke-purple-400' : 'stroke-slate-600 group-hover:stroke-purple-600 dark:stroke-slate-300 dark:group-hover:stroke-purple-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xs font-medium text-center transition-colors duration-200
                                    {{ request()->routeIs('collective-action.*') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}">
                        {{ __('Aksi Kolektif') }}
                    </span>
                </a>
            @else
                <div class="flex flex-col items-center justify-center cursor-not-allowed size-20 rounded-2xl opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xs font-medium text-center text-slate-400 dark:text-slate-500">{{ __('Aksi Kolektif') }}</span>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 px-3 py-2 mt-2 text-xs text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                        <span>
                            @if (!$hasActiveMarketSession)
                                Bergabung dengan sesi pasar terlebih dahulu
                            @elseif(!$userActionsEnabled)
                                Fitur aksi kolektif sedang dinonaktifkan oleh administrator.
                            @else
                                Fitur aksi kolektif tidak tersedia untuk user tipe
                                {{ $user->getUserTypeLabelAttribute() }}
                            @endif
                        </span>
                        <div
                            class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Peta Ekosistem (Public Access) -->
            {{-- <a href="{{ route('public.ecosystem.mapping') . '?pasar_id=' . auth()->user()->active_pasar_kolaboraya_id }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('ecosystem.mapping') ? 'bg-cyan-500/20 text-cyan-600 dark:text-cyan-400' : 'text-slate-600 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 hover:bg-cyan-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Peta') }}</span>
                </a> --}}

            @if (Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.market.statistics') }}"
                    class="flex flex-col items-center justify-center py-4 transition-all duration-300 size-20 rounded-2xl group h-fit"
                    wire:navigate>
                    <flux:icon name="chart-bar"
                        class="w-6 h-6 mb-1 transition-colors duration-200 {{ request()->routeIs('admin.market.statistics') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}" />
                    <span
                        class="text-xs font-medium text-center transition-colors duration-200
                                    {{ request()->routeIs('admin.market.statistics') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}">
                        {{ __('Statistik Pasar') }}
                    </span>
                </a>
            @endif
        </div>
    </div>
</div>
