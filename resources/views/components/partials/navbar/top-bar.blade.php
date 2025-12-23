    <flux:navbar class="relative z-10 justify-center col-span-1 -mb-px max-lg:hidden h-14">
        <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
            class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-blue-600 dark:text-slate-200 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl"
            wire:navigate>
            <span class="relative z-10">{{ __('Beranda') }}</span>
        </flux:navbar.item>

        <!-- Koneksi -->
        @if ($connectionsEnabled && $hasActiveMarketSession)
            <flux:navbar.item icon="link" :href="route('connections')" :current="request()->routeIs('connections')"
                class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-indigo-600 dark:text-slate-200 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl"
                wire:navigate>
                <span class="relative z-10">{{ __('Koneksi') }}</span>
            </flux:navbar.item>
        @else
            <flux:navbar.item icon="link"
                class="relative px-4 py-2 mx-1 cursor-not-allowed group text-slate-400 dark:text-slate-500 rounded-xl opacity-60"
                x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                {{-- <flux:icon name="link" class="w-5 h-5" /> --}}
                <span class="relative z-10 ml-2">{{ __('Koneksi') }}</span>
                <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                <!-- Tooltip -->
                <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 px-3 py-2 mt-2 text-sm text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                    <span>
                        @if (!$hasActiveMarketSession)
                            Anda harus bergabung dengan sesi pasar terlebih dahulu
                        @else
                            Fitur koneksi sedang dinonaktifkan oleh administrator.
                        @endif
                    </span>
                    <div
                        class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                    </div>
                </div>
            </flux:navbar.item>
        @endif

        <!-- Ekosistem -->
        @if ($collaborationsEnabled && $hasActiveMarketSession)
            <flux:navbar.item icon="building-library" :href="route('ecosystem.browse')"
                :current="request()->routeIs('ecosystem.*')"
                class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-green-600 dark:text-slate-200 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl"
                wire:navigate>
                <span class="relative z-10">{{ __('Kolaborasi') }}</span>
            </flux:navbar.item>
        @else
            <flux:navbar.item icon="building-library"
                class="relative px-4 py-2 mx-1 cursor-not-allowed group text-slate-400 dark:text-slate-500 rounded-xl opacity-60"
                x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                <span class="relative z-10 ml-2">{{ __('Kolaborasi') }}</span>
                <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                <!-- Tooltip -->
                <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 px-3 py-2 mt-2 text-sm text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                    <span>
                        @if (!$hasActiveMarketSession)
                            Anda harus bergabung dengan sesi pasar terlebih dahulu
                        @elseif(!$collaborationsEnabled)
                            Fitur kolaborasi sedang dinonaktifkan oleh administrator.
                        @endif
                    </span>
                    <div
                        class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                    </div>
                </div>
            </flux:navbar.item>
        @endif

        <!-- Aksi Kolektif (follows user actions setting) -->
        @if ($userActionsEnabled && $hasActiveMarketSession)
            <flux:navbar.item icon="sparkles" :href="route('collective-action.browse')"
                :current="request()->routeIs('collective-action.*')"
                class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-purple-600 dark:text-slate-200 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl"
                wire:navigate>
                <span class="relative z-10">{{ __('Aksi Kolektif') }}</span>
            </flux:navbar.item>
        @else
            <flux:navbar.item icon="sparkles"
                class="relative px-4 py-2 mx-1 cursor-not-allowed group text-slate-400 dark:text-slate-500 rounded-xl opacity-60"
                x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                <span class="relative z-10 ml-2">{{ __('Aksi Kolektif') }}</span>
                <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                <!-- Tooltip -->
                <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 px-3 py-2 mt-2 text-sm text-white transform -translate-x-1/2 rounded-lg shadow-lg top-full left-1/2 bg-slate-800 dark:bg-slate-700 whitespace-nowrap">
                    <span>
                        @if (!$hasActiveMarketSession)
                            Anda harus bergabung dengan sesi pasar terlebih dahulu
                        @elseif(!$userActionsEnabled)
                            Fitur aksi kolektif sedang dinonaktifkan oleh administrator.
                        @else
                            Fitur aksi kolektif tidak tersedia untuk user tipe
                            {{ $user->getUserTypeLabelAttribute() }}. Hanya partisipan, tamu, dan komunitas yang
                            dapat mengakses fitur
                            aksi kolektif.
                        @endif
                    </span>
                    <div
                        class="absolute w-0 h-0 transform -translate-x-1/2 border-b-4 border-l-4 border-r-4 border-transparent bottom-full left-1/2 border-b-slate-800 dark:border-b-slate-700">
                    </div>
                </div>
            </flux:navbar.item>
        @endif

        <!-- Peta Ekosistem (Public Access) -->
        {{-- <flux:navbar.item icon="map"
                :href="route('public.ecosystem.mapping') .'?pasar_id='.auth()->user()->active_pasar_kolaboraya_id"
                :current="request()->routeIs('public.ecosystem.mapping')"
                class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-cyan-600 dark:text-slate-200 dark:hover:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-xl"
                wire:navigate>
                <span class="relative z-10">{{ __('Peta Ekosistem') }}</span>
            </flux:navbar.item> --}}

        @if (Auth::user()->isSuperAdmin())
            <flux:navbar.item icon="chart-bar" :href="route('admin.market.statistics')"
                :current="request()->routeIs('admin.market.statistics')"
                class="relative px-4 py-2 mx-1 transition-all duration-300 group text-slate-700 hover:text-cyan-600 dark:text-slate-200 dark:hover:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-xl"
                wire:navigate>
                <span class="relative z-10">{{ __('Statistik Pasar') }}</span>
            </flux:navbar.item>
        @endif

        <!-- Note: "Aksi Bersama" functionality is now unified with "Aksi Kolektif" -->
    </flux:navbar>