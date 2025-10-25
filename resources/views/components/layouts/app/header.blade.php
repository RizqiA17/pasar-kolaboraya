<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @if ($title)
        <title>{{ $title }} - {{ config('app.name') }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @livewireScripts
</head>

<body class="min-h-screen bg-primary-light-blue block! dark:bg-slate-950">
    {{-- Decorative SVG Elements --}}
    <x-decorative-svgs-subtle />

    <!-- Modern Header with Glassmorphism -->
    <flux:header
        class="sticky top-0 z-50 border-b bg-cream/80 border-white/20 dark:bg-neutral-green/20! backdrop-blur-xl shadow-2xl shadow-blue-500/10 dark:shadow-none grid! grid-cols-3!">
        <!-- Background gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-pink-600/5"></div>

        {{-- <flux:sidebar.toggle class="relative z-10 lg:hidden text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 transition-all duration-300" icon="bars-2" inset="left" /> --}}

        <!-- Logo with modern styling -->
        <a href="{{ route('dashboard') }}"
            class="relative lg:col-span-1 col-span-2 z-10 ms-2 me-8 flex items-center space-x-3 rtl:space-x-reverse lg:ms-0 group"
            wire:navigate>
            <x-app-logo />
            <div class="hidden lg:block">
                <div class="h-6 w-px bg-gradient-to-b from-transparent via-slate-300 to-transparent dark:via-slate-600">
                </div>
            </div>
        </a>


        <!-- Modern Navigation Bar -->
        <flux:navbar class="relative col-span-1 z-10 -mb-px max-lg:hidden justify-center">
            <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                class="group relative px-4 py-2 text-slate-700 hover:text-blue-600 dark:text-slate-200 dark:hover:text-blue-400 transition-all duration-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl mx-1"
                wire:navigate>
                <span class="relative z-10">{{ __('Beranda') }}</span>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </flux:navbar.item>

            @php
                $user = auth()->user();
                $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
                $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
                $ecosystemsEnabled = \App\Models\SystemSetting::isEcosystemsEnabled($user);
                $userActionsEnabled = \App\Models\SystemSetting::isUserActionsEnabled();
                $collectiveActionsEnabled = \App\Models\SystemSetting::isCollectiveActionsEnabled();
                $isSuperAdmin = $user->isSuperAdmin();
                $isEcosystemBuilder = $user->isApprovedEcosystemBuilder();
                $hasActiveMarketSession = $user->hasActivePasarKolaboraya();
            @endphp

            <!-- Koneksi -->
            @if ($connectionsEnabled && $hasActiveMarketSession)
                <flux:navbar.item icon="link" :href="route('connections')"
                    :current="request()->routeIs('connections')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-indigo-600 dark:text-slate-200 dark:hover:text-indigo-400 transition-all duration-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative z-10">{{ __('Koneksi') }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-blue-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </flux:navbar.item>
            @else
                <flux:navbar.item icon="link"
                    class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    {{-- <flux:icon name="link" class="w-5 h-5" /> --}}
                    <span class="relative z-10 ml-2">{{ __('Koneksi') }}</span>
                    <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                        <span>
                            @if (!$hasActiveMarketSession)
                                Anda harus bergabung dengan sesi pasar terlebih dahulu
                            @else
                                Fitur koneksi sedang dinonaktifkan oleh administrator.
                            @endif
                        </span>
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </flux:navbar.item>
            @endif

            <!-- Kolaborasi -->
            {{-- @if ($collaborationsEnabled || $isSuperAdmin)
                <flux:navbar.item icon="users" :href="route('collaborations.manage')"
                    :current="request()->routeIs('collaborations.manage')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-purple-600 dark:text-slate-200 dark:hover:text-purple-400 transition-all duration-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative z-10">{{ __('Kolaborasi') }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </flux:navbar.item>
            @else
                <flux:navbar.item icon="users"
                    class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <span class="relative z-10 ml-2">{{ __('Kolaborasi') }}</span>
                    <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                        <span>Fitur kolaborasi sedang dinonaktifkan oleh administrator</span>
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </flux:navbar.item>
            @endif --}}

            <!-- Ekosistem (follows collaboration setting, but ecosystem builders always have access) -->
            @if ($collaborationsEnabled && $hasActiveMarketSession)
                {{-- {{dd('ecosystemsEnabled: ' => $ecosystemsEnabled, 'isSuperAdmin: ' => $isSuperAdmin, 'isEcosystemBuilder: ' => $isEcosystemBuilder, 'hasActiveMarketSession: ' => $hasActiveMarketSession)}} --}}
                <flux:navbar.item icon="building-library" :href="route('ecosystem.browse')"
                    :current="request()->routeIs('ecosystem.*')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-green-600 dark:text-slate-200 dark:hover:text-green-400 transition-all duration-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative z-10">{{ __('Kolaborasi') }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </flux:navbar.item>
            @else
                <flux:navbar.item icon="building-library"
                    class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <span class="relative z-10 ml-2">{{ __('Kolaborasi') }}</span>
                    <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                        <span>
                            @if (!$hasActiveMarketSession)
                                Anda harus bergabung dengan sesi pasar terlebih dahulu
                            @elseif(!$collaborationsEnabled)
                                Fitur kolaborasi sedang dinonaktifkan oleh administrator.
                            @endif
                        </span>
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </flux:navbar.item>
            @endif

            <!-- Aksi Kolektif (follows user actions setting) -->
            @if ($userActionsEnabled && $hasActiveMarketSession)
                <flux:navbar.item icon="sparkles" :href="route('collective-action.browse')"
                    :current="request()->routeIs('collective-action.*')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-purple-600 dark:text-slate-200 dark:hover:text-purple-400 transition-all duration-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative z-10">{{ __('Aksi Kolektif') }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-violet-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </flux:navbar.item>
            @else
                <flux:navbar.item icon="sparkles"
                    class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <span class="relative z-10 ml-2">{{ __('Aksi Kolektif') }}</span>
                    <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
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
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </flux:navbar.item>
            @endif

            <!-- Peta Ekosistem (Public Access) -->
            {{-- <flux:navbar.item icon="map"
                :href="route('public.ecosystem.mapping') .'?pasar_id='.auth()->user()->active_pasar_kolaboraya_id"
                :current="request()->routeIs('public.ecosystem.mapping')"
                class="group relative px-4 py-2 text-slate-700 hover:text-cyan-600 dark:text-slate-200 dark:hover:text-cyan-400 transition-all duration-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-xl mx-1"
                wire:navigate>
                <span class="relative z-10">{{ __('Peta Ekosistem') }}</span>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </flux:navbar.item> --}}

            @if (Auth::user()->isSuperAdmin())
                <flux:navbar.item icon="chart-bar"
                    :href="route('admin.market.statistics')"
                    :current="request()->routeIs('admin.market.statistics')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-cyan-600 dark:text-slate-200 dark:hover:text-cyan-400 transition-all duration-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative z-10">{{ __('Statistik Pasar') }}</span>
                </flux:navbar.item>
            @endif

            <!-- Note: "Aksi Bersama" functionality is now unified with "Aksi Kolektif" -->
        </flux:navbar>

        {{-- <flux:spacer /> --}}

        <div class="flex col-span-1 items-center gap-2 justify-end">
            <!-- Dark Mode Toggle -->
            <x-dark-mode-toggle class="relative z-10" />

            <!-- Modern Notification System -->
            <x-flux::dropdown align="right" width="128" class="relative z-10" x-data="notificationDropdown()"
                @open="refreshNotifications()">
                <flux:button icon="bell"
                    class="group relative m-auto text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm rounded-full size-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 dark:border-slate-700/50">
                </flux:button>
                <div x-show="unreadCount > 0"
                    class="absolute top-0 right-0 w-3 h-3 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full animate-pulse">
                </div>
                <flux:menu
                    class="mt-2 max-sm:-translate-x-4 lg:-translate-x-8 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20 rounded-2xl overflow-hidden">
                    <div class="p-4 lg:w-128 w-80 max-w-[calc(100vw-2rem)]">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Notifikasi</h3>
                            <div class="flex items-center space-x-2">
                                <button @click="refreshNotifications()"
                                    class="text-xs text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400"
                                    title="Refresh notifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                                <span x-show="unreadCount > 0"
                                    class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                                    <span x-text="unreadCount"></span> baru
                                </span>
                                <a href="{{ route('notifications.index') }}"
                                    class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    Lihat semua
                                </a>
                            </div>
                        </div>

                        <!-- Loading state -->
                        <div x-show="loading" class="text-center py-4">
                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600">
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Memuat notifikasi...</p>
                        </div>

                        <!-- Notifications list -->
                        <div x-show="!loading" class="space-y-3 max-h-96 overflow-y-auto">
                            <template x-for="notification in notifications" :key="notification.id">
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    :class="{
                                        'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-l-blue-500': !notification
                                            .is_read
                                    }">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <div x-show="!notification.is_read"
                                                    class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                                    x-text="notification.title || 'Notifikasi'"></h4>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400"
                                                x-text="notification.message"></p>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-500"
                                                x-text="notification.time_ago"></p>
                                        </div>
                                        <div class="flex items-center space-x-1 ml-2">
                                            <button x-show="notification.redirect_url"
                                                @click="viewNotification(notification.id)"
                                                class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                                Lihat
                                            </button>
                                            <button x-show="!notification.is_read"
                                                @click="markAsRead(notification.id)"
                                                class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                                ✓
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Empty state -->
                            <div x-show="notifications.length === 0" class="text-center py-8">
                                <div class="w-12 h-12 mx-auto text-gray-400 mb-2">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 0 0-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 0 1 15 0v5z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                            </div>
                        </div>
                    </div>
                </flux:menu>
            </x-flux::dropdown>

            <!-- Modern Desktop User Menu -->
            <flux:dropdown position="top" align="center" class="relative z-10">
                {{-- <flux:profile circle :chevron="false"
                    @if (auth()->user()->profile?->profile_photo) avatar="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" @else :initials="auth()->user()->initials()" @endif
                    class="group transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105" /> --}}
                <flux:button
                    class="group size-10! bg-white/60! hover:bg-white/80! dark:bg-slate-800/60! dark:hover:bg-slate-800/80! backdrop-blur-sm rounded-full! shadow-lg hover:shadow-xl transition-all duration-300 outline-2 outline-white/20 dark:outline-slate-700/50 p-0!">
                    <x-ui.avatar :user="auth()->user()" size="md" class="size-10!" />
                </flux:button>
                {{-- <flux:profile circle :chevron="false" avatar="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" class="size-12!" /> --}}
                <div
                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-slate-900">
                </div>

                <flux:menu
                    class="mt-2 bg-white/90! dark:bg-slate-800/90! backdrop-blur-xl border border-white/20! dark:border-slate-700/50! shadow-2xl shadow-blue-500/20! rounded-2xl overflow-hidden">
                    <flux:menu.radio.group>
                        <div class="p-4">
                            <div class="flex items-center gap-3">
                                <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-xl">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 text-white shadow-lg text-lg font-semibold">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start">
                                    <span
                                        class="truncate font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                                    <span
                                        class="truncate text-sm text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <div class="flex items-center gap-3 px-4 py-3">
                        @if ($user->is_ecosystem_builder)
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">
                                Ekosistem Builder
                            </span>
                        @elseif($user->assigned_role)
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400">
                                {{ $user->assigned_role }}
                            </span>
                        @else
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">
                                Belum Dipilih
                            </span>
                        @endif
                    </div>

                    <!-- Active Session Information -->
                    @if (auth()->user()->hasActivePasarKolaboraya())
                        <div class="px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                    <flux:icon.cube class="w-4 h-4 text-blue-600 dark:text-blue-300" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                        Sesi Aktif
                                    </h4>
                                    <p class="text-xs text-blue-600 dark:text-blue-300">
                                        {{ auth()->user()->activePasarKolaboraya->name }}
                                    </p>
                                    <p class="text-xs text-blue-500 dark:text-blue-400">
                                        {{ auth()->user()->activePasarKolaboraya->acceptedUsers->count() }} anggota
                                    </p>
                                </div>
                                <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs"
                                    {{-- variant="secondary" --}}>
                                    Ganti
                                </flux:button>
                            </div>
                        </div>
                    @elseif(auth()->user()->hasPasarKolaborayas())
                        <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center">
                                    <flux:icon.exclamation-triangle
                                        class="w-4 h-4 text-yellow-600 dark:text-yellow-300" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">
                                        Pilih Sesi
                                    </h4>
                                    <p class="text-xs text-yellow-600 dark:text-yellow-300">
                                        {{ auth()->user()->acceptedPasarKolaborayas->count() }} Pasar Kolaboraya
                                        tersedia
                                    </p>
                                </div>
                                <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs"
                                    variant="primary">
                                    Pilih
                                </flux:button>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/20 border-l-4 border-gray-400">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <flux:icon.information-circle class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        Belum Bergabung
                                    </h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">
                                        Hubungi admin untuk diundang
                                    </p>
                                </div>
                                <flux:button href="{{ route('pasar-kolaboraya.join-request') }}" size="xs"
                                    {{-- variant="secondary" --}}>
                                    Minta
                                </flux:button>
                            </div>
                        </div>
                    @endif

                    <div
                        class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
                    </div>

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="user" wire:navigate
                            class="px-4 py-3 text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-all duration-200">
                            {{ __('Profile') }}</flux:menu.item>
                        @if (auth()->user()->isSuperAdmin())
                            <flux:menu.item :href="route('admin.dashboard')" icon="shield-check" wire:navigate
                                class="px-4 py-3 text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-all duration-200">
                                {{ __('Admin') }}</flux:menu.item>
                        @endif
                    </flux:menu.radio.group>

                    <div
                        class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full px-4 py-3 text-slate-700 hover:text-red-600 hover:bg-red-50 dark:text-slate-200 dark:hover:text-red-400 dark:hover:bg-red-900/20 transition-all duration-200">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>

        <!-- Modern Mobile User Menu -->
        <flux:dropdown position="top" align="end" class="relative z-10 lg:hidden ms-4">
            <flux:profile circle :chevron="false"
                @if (auth()->user()->profile?->profile_photo) avatar="{{ asset('storage/' . auth()->user()->profile->profile_photo) }}" @else :initials="auth()->user()->initials()" @endif
                class="group transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105" />

            <flux:menu
                class="mt-2 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20 rounded-2xl overflow-hidden">
                <flux:menu.radio.group>
                    <div class="p-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-xl">
                                <x-ui.avatar :user="auth()->user()" size="lg" />
                            </span>

                            <div class="grid flex-1 text-start">
                                <span
                                    class="truncate font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                                <span
                                    class="truncate text-sm text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <!-- Active Session Information for Mobile -->
                @if (auth()->user()->hasActivePasarKolaboraya())
                    <div class="px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                <flux:icon.cube class="w-4 h-4 text-blue-600 dark:text-blue-300" />
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                    Sesi Aktif
                                </h4>
                                <p class="text-xs text-blue-600 dark:text-blue-300">
                                    {{ auth()->user()->activePasarKolaboraya->name }}
                                </p>
                                <p class="text-xs text-blue-500 dark:text-blue-400">
                                    {{ auth()->user()->activePasarKolaboraya->acceptedUsers->count() }} anggota
                                </p>
                            </div>
                            <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs"
                                {{-- variant="secondary" --}}>
                                Ganti
                            </flux:button>
                        </div>
                    </div>
                @elseif(auth()->user()->hasPasarKolaborayas())
                    <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center">
                                <flux:icon.exclamation-triangle class="w-4 h-4 text-yellow-600 dark:text-yellow-300" />
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">
                                    Pilih Sesi
                                </h4>
                                <p class="text-xs text-yellow-600 dark:text-yellow-300">
                                    {{ auth()->user()->acceptedPasarKolaborayas->count() }} Pasar Kolaboraya tersedia
                                </p>
                            </div>
                            <flux:button href="{{ route('pasar-kolaboraya.select') }}" size="xs"
                                variant="primary">
                                Pilih
                            </flux:button>
                        </div>
                    </div>
                @else
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/20 border-l-4 border-gray-400">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <flux:icon.information-circle class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Belum Bergabung
                                </h4>
                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    Hubungi admin untuk diundang
                                </p>
                            </div>
                            <flux:button href="{{ route('pasar-kolaboraya.join-request') }}" size="xs"
                                {{-- variant="secondary" --}}>
                                Minta
                            </flux:button>
                        </div>
                    </div>
                @endif

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent">
                </div>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full px-4 py-3 text-slate-700 hover:text-red-600 hover:bg-red-50 dark:text-slate-200 dark:hover:text-red-400 dark:hover:bg-red-900/20 transition-all duration-200">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    <!-- Mobile Bottom Navigation Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50">
        <!-- Background with glassmorphism effect -->
        <div
            class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border-t border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20">
            <!-- Background gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-pink-600/5"></div>

            <!-- Navigation Items -->
            <div class="relative flex items-center justify-around px-2 py-3">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group p-1"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg 
                            class="w-full h-full transition-colors duration-200
                                {{ request()->routeIs('dashboard') ? 'stroke-blue-600 dark:stroke-blue-400' : 'stroke-slate-600 group-hover:stroke-blue-600 dark:stroke-slate-300 dark:group-hover:stroke-blue-400' }}" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium transition-colors duration-200
                                  {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-600 group-hover:text-blue-600 dark:text-slate-300 dark:group-hover:text-blue-400' }}">
                        {{ __('Dashboard') }}
                    </span>
                </a>

                <!-- Connections -->
                @if ($connectionsEnabled && $hasActiveMarketSession)
                    <a href="{{ route('connections') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group p-1"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg 
                                class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('connections') ? 'stroke-indigo-600 dark:stroke-indigo-400' : 'stroke-slate-600 group-hover:stroke-indigo-600 dark:stroke-slate-300 dark:group-hover:stroke-indigo-400' }}" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium transition-colors duration-200
                                    {{ request()->routeIs('connections') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-600 group-hover:text-indigo-600 dark:text-slate-300 dark:group-hover:text-indigo-400' }}">
                            {{ __('Koneksi') }}
                        </span>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
                        x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                        <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ __('Koneksi') }}</span>

                        <!-- Tooltip -->
                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-xs rounded-lg shadow-lg whitespace-nowrap z-50">
                            <span>
                                @if (!$hasActiveMarketSession)
                                    Bergabung dengan sesi pasar terlebih dahulu
                                @else
                                    Fitur koneksi sedang dinonaktifkan sedang dinonaktifkan oleh administrator.
                                @endif
                            </span>
                            <div
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Collaborations -->
                {{-- @if ($collaborationsEnabled || $isSuperAdmin)
                    <a href="{{ route('collaborations.manage') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('collaborations.manage') ? 'bg-purple-500/20 text-purple-600 dark:text-purple-400' : 'text-slate-600 hover:text-purple-600 dark:text-slate-300 dark:hover:text-purple-400 hover:bg-purple-500/10' }}"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium">{{ __('Kolaborasi') }}</span>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
                        x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                        <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ __('Kolaborasi') }}</span>

                        <!-- Tooltip -->
                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-xs rounded-lg shadow-lg whitespace-nowrap z-50">
                            <span>Fitur kolaborasi sedang dinonaktifkan</span>
                            <div
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                            </div>
                        </div>
                    </div>
                @endif --}}

                <!-- Ekosistem -->
                @if ($collaborationsEnabled && $hasActiveMarketSession)
                    <a href="{{ route('ecosystem.browse') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group p-1"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg 
                                class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('ecosystem.*') ? 'stroke-green-600 dark:stroke-green-400' : 'stroke-slate-600 group-hover:stroke-green-600 dark:stroke-slate-300 dark:group-hover:stroke-green-400' }}" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium transition-colors duration-200
                                    {{ request()->routeIs('ecosystem.*') ? 'text-green-600 dark:text-green-400' : 'text-slate-600 group-hover:text-green-600 dark:text-slate-300 dark:group-hover:text-green-400' }}">
                            {{ __('Kolaborasi') }}
                        </span>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
                        x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                        <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 dark:text-slate-500">{{ __('Kolaborasi') }}</span>

                        <!-- Tooltip -->
                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-xs rounded-lg shadow-lg whitespace-nowrap z-50">
                            <span>
                                @if (!$hasActiveMarketSession)
                                    Bergabung dengan sesi pasar terlebih dahulu
                                @elseif(!$collaborationsEnabled)
                                    Fitur kolaborasi sedang dinonaktifkan oleh administrator.
                                @endif
                            </span>
                            <div
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Aksi Kolektif -->
                @if ($userActionsEnabled && $hasActiveMarketSession)
                    <a href="{{ route('collective-action.browse') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group p-1"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg 
                                class="w-full h-full transition-colors duration-200
                                    {{ request()->routeIs('collective-action.*') ? 'stroke-purple-600 dark:stroke-purple-400' : 'stroke-slate-600 group-hover:stroke-purple-600 dark:stroke-slate-300 dark:group-hover:stroke-purple-400' }}" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-center transition-colors duration-200
                                    {{ request()->routeIs('collective-action.*') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}">
                            {{ __('Aksi Kolektif') }}
                        </span>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
                        x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                        <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-slate-400 dark:text-slate-500 text-center">{{ __('Aksi Kolektif') }}</span>

                        <!-- Tooltip -->
                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-xs rounded-lg shadow-lg whitespace-nowrap z-50">
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
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
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
                    <a 
                        href="{{ route('admin.market.statistics') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group p-1"
                        wire:navigate>
                        <flux:icon 
                            name="chart-bar" 
                            class="w-6 h-6 mb-1 transition-colors duration-200 {{ request()->routeIs('admin.market.statistics') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}" 
                        />
                        <span class="text-xs font-medium text-center transition-colors duration-200
                                    {{ request()->routeIs('admin.market.statistics') ? 'text-purple-600 dark:text-purple-400' : 'text-slate-600 group-hover:text-purple-600 dark:text-slate-300 dark:group-hover:text-purple-400' }}">
                            {{ __('Statistik Pasar') }}
                        </span>
                    </a>
                @endif

                <!-- Aksi -->
                {{-- @if ($userActionsEnabled || $isSuperAdmin)
                    <a href="{{ route('events') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('events') ? 'bg-pink-500/20 text-pink-600 dark:text-pink-400' : 'text-slate-600 hover:text-pink-600 dark:text-slate-300 dark:hover:text-pink-400 hover:bg-pink-500/10' }}"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs text-center font-medium">{{ __('Aksi Bersama') }}</span>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center size-20 rounded-2xl opacity-60 cursor-not-allowed"
                        x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                        <div class="w-6 h-6 mb-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-center text-slate-400 dark:text-slate-500">{{ __('Aksi Bersama') }}</span>

                        <!-- Tooltip -->
                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-xs rounded-lg shadow-lg whitespace-nowrap z-50">
                            <span>Aksi pengguna sedang dinonaktifkan</span>
                            <div
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                            </div>
                        </div>
                    </div>
                @endif --}}

                <!-- Profile -->
                {{-- <a href="{{ route('settings.profile') }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('settings.profile') ? 'bg-green-500/20 text-green-600 dark:text-green-400' : 'text-slate-600 hover:text-green-600 dark:text-slate-300 dark:hover:text-green-400 hover:bg-green-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Profile') }}</span>
                </a> --}}
            </div>

            <!-- Active indicator -->
            {{-- @if (request()->routeIs('dashboard'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('connections'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('collaborations.manage'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('ecosystem.*'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('collective-action.*'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-purple-500 to-violet-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('ecosystem.mapping'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('admin.market.statistics'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('events'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-pink-500 to-rose-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('settings.profile'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-t-full">
                </div>
            @endif --}}
        </div>
    </div>

    @stack('footer')

    @fluxScripts

    {{-- Chart.js for dashboard visualizations --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Pusher for real-time notifications --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- Notification System JavaScript --}}
    <script>
        function notificationDropdown() {
            return {
                notifications: [],
                unreadCount: 0,
                loading: true,

                init() {
                    this.loadNotifications();
                    this.setupPusher();

                    // Refresh notifications every 5 seconds for real-time updates
                    setInterval(() => {
                        this.loadNotifications();
                    }, 5000);

                    // Also refresh when page becomes visible (user switches tabs)
                    document.addEventListener('visibilitychange', () => {
                        if (!document.hidden) {
                            this.refreshNotifications();
                        }
                    });
                },

                async loadNotifications() {
                    try {
                        const response = await fetch('/notifications/recent');
                        const data = await response.json();
                        this.notifications = data.notifications || [];
                        this.updateUnreadCount();
                        this.loading = false;
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                        this.loading = false;
                    }
                },

                // Method to manually refresh notifications
                refreshNotifications() {
                    this.loading = true;
                    this.loadNotifications();
                },

                async loadUnreadCount() {
                    try {
                        const response = await fetch('/notifications/unread-count');
                        const data = await response.json();
                        this.unreadCount = data.unread_count || 0;
                    } catch (error) {
                        console.error('Error loading unread count:', error);
                    }
                },

                updateUnreadCount() {
                    this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                },

                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/notifications/${notificationId}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                            },
                        });

                        if (response.ok) {
                            // Update local state
                            const notification = this.notifications.find(n => n.id === notificationId);
                            if (notification) {
                                notification.is_read = true;
                                this.updateUnreadCount();
                            }
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },

                viewNotification(notificationId) {
                    window.location.href = `/notifications/${notificationId}`;
                },

                setupPusher() {
                    // Try to setup Pusher for real-time updates
                    try {
                        if (typeof Pusher !== 'undefined' && '{{ config('broadcasting.default') }}' === 'pusher') {
                            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                                encrypted: true
                            });

                            const channel = pusher.subscribe('notifications.{{ auth()->id() }}');

                            channel.bind('notification.created', (data) => {
                                this.notifications.unshift(data.notification);
                                this.updateUnreadCount();

                                // Show browser notification if permission is granted
                                if (Notification.permission === 'granted') {
                                    new Notification(data.notification.title || 'Notifikasi Baru', {
                                        body: data.notification.message,
                                        icon: '/favicon.ico'
                                    });
                                }
                            });

                            channel.bind('notification.updated', (data) => {
                                const index = this.notifications.findIndex(n => n.id === data.notification.id);
                                if (index !== -1) {
                                    this.notifications[index] = data.notification;
                                    this.updateUnreadCount();
                                }
                            });

                            console.log('Pusher connected for real-time notifications');
                        } else {
                            console.log('Pusher not available, using polling fallback');
                        }
                    } catch (error) {
                        console.log('Pusher setup failed, using polling fallback:', error);
                    }
                }
            }
        }

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    </script>

    <script>
        // async function refreshCsrfToken() {
        //     const csrfToken = document
        //         .querySelector('meta[name="csrf-token"]')
        //         .getAttribute('content');

        //     try {
        //         const response = await fetch('/csrf-token-refresh', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken
        //             },
        //             body: JSON.stringify({
        //                 action: 'refresh'
        //             })
        //         });

        //         if (!response.ok) {
        //             throw new Error(`Gagal refresh CSRF: ${response.statusText}`);
        //         }

        //         const result = await response.json();

        //         // update <meta> csrf token
        //         document
        //             .querySelector('meta[name="csrf-token"]')
        //             .setAttribute('content', result.token);

        //         // update Livewire internal token
        //         if (window.Livewire) {
        //             window.Livewire.csrfToken = result.token;
        //         }

        //         // update default AJAX headers
        //         if (window.axios) {
        //             window.axios.defaults.headers.common['X-CSRF-TOKEN'] = result.token;
        //         }
        //         if (window.jQuery) {
        //             window.jQuery.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': result.token
        //                 }
        //             });
        //         }

        //         // === Hitung jadwal refresh berdasarkan session_expired_at ===
        //         const clientTimeMs = Date.now();

        //         if (result.session_expired_at) {
        //             const expiredAtMs = result.session_expired_at * 1000;
        //             let delayMs = expiredAtMs - clientTimeMs - (60 * 1000); // 1 menit sebelum expired

        //             if (delayMs < 5000) delayMs = 5000; // minimal 5 detik supaya aman

        //             console.log({
        //                 serverTime: new Date(result.timestamp * 1000).toISOString(),
        //                 clientTime: new Date(clientTimeMs).toISOString(),
        //                 nextRefreshAt: new Date(clientTimeMs + delayMs).toISOString(),
        //                 Token: result.token,
        //                 previousToken: result.previous_token,
        //                 sessionExpiredAt: new Date(expiredAtMs).toISOString(),
        //                 delaySeconds: Math.round(delayMs / 1000)
        //             });

        //             setTimeout(refreshCsrfToken, delayMs);
        //         } else {
        //             console.warn("⚠️ session_expired_at tidak ada di response, fallback 10 menit");
        //             setTimeout(refreshCsrfToken, 10 * 60 * 1000);
        //         }

        //     } catch (error) {
        //         console.error("Kesalahan saat refresh CSRF:", error.message);
        //         setTimeout(refreshCsrfToken, 60000); // retry setelah 1 menit
        //     }
        // }

        // mulai pertama kali
        // refreshCsrfToken();

        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({
                fail
            }) => {
                fail(({
                    status,
                    preventDefault
                }) => {
                    if (status === 419) {
                        alert('Maaf, coba lagi')

                        preventDefault()
                    }
                })
            })
        })
    </script>

    {{-- Stack for additional styles and scripts --}}
    @stack('styles')
    @stack('scripts')
</body>

</html>
