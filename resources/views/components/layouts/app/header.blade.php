<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @if ($title)
        <title>{{ $title }} - {{ config('app.name') }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    {{-- Decorative SVG Elements --}}
    <x-decorative-svgs-subtle />

    <!-- Modern Header with Glassmorphism -->
    <flux:header
        class="sticky top-0 z-50 border-b bg-cream/80 border-white/20 dark:bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-blue-500/10 grid! grid-cols-3!">
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
                $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
                $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
                $userActionsEnabled = \App\Models\SystemSetting::isUserActionsEnabled();
                $isSuperAdmin = auth()->user()->isSuperAdmin();
            @endphp

            <!-- Koneksi -->
            @if ($connectionsEnabled || $isSuperAdmin)
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
                        <span>Fitur koneksi sedang dinonaktifkan oleh administrator</span>
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

            <!-- Ekosistem -->
            <flux:navbar.item icon="building-library" :href="route('ecosystem.browse')" :current="request()->routeIs('ecosystem.*')"
                class="group relative px-4 py-2 text-slate-700 hover:text-green-600 dark:text-slate-200 dark:hover:text-green-400 transition-all duration-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl mx-1"
                wire:navigate>
                <span class="relative z-10">{{ __('Ekosistem') }}</span>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </flux:navbar.item>

            <!-- Aksi Kolektif -->
            <flux:navbar.item icon="sparkles" :href="route('collective-action.browse')" :current="request()->routeIs('collective-action.*')"
                class="group relative px-4 py-2 text-slate-700 hover:text-purple-600 dark:text-slate-200 dark:hover:text-purple-400 transition-all duration-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl mx-1"
                wire:navigate>
                <span class="relative z-10">{{ __('Aksi Kolektif') }}</span>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-violet-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </flux:navbar.item>

            <!-- Aksi Bersama -->
            {{-- @if ($userActionsEnabled || $isSuperAdmin)
                <flux:navbar.item icon="user-group" :href="route('events')" :current="request()->routeIs('events')"
                    class="group relative px-4 py-2 text-slate-700 hover:text-pink-600 dark:text-slate-200 dark:hover:text-pink-400 transition-all duration-300 hover:bg-pink-50 dark:hover:bg-pink-900/20 rounded-xl mx-1"
                    wire:navigate>
                    <span class="relative text-center z-10">{{ __('Aksi Bersama') }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-pink-500/10 to-rose-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </flux:navbar.item>
            @else
                <flux:navbar.item icon="user-group"
                    class="group relative px-4 py-2 text-slate-400 dark:text-slate-500 cursor-not-allowed rounded-xl mx-1 opacity-60"
                    x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                    <span class="relative text-center z-10 ml-2">{{ __('Aksi Bersama') }}</span>
                    <div class="absolute inset-0 bg-slate-200/20 dark:bg-slate-700/20 rounded-xl"></div>

                    <!-- Tooltip -->
                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-slate-800 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap z-50">
                        <span>Aksi pengguna sedang dinonaktifkan oleh administrator</span>
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-800 dark:border-b-slate-700">
                        </div>
                    </div>
                </flux:navbar.item>
            @endif --}}
        </flux:navbar>

        {{-- <flux:spacer /> --}}

        <div class="flex col-span-1 items-center gap-2 justify-end">
            <!-- Dark Mode Toggle -->
            <x-dark-mode-toggle class="relative z-10" />
            
            <!-- Modern Notification System -->
            <x-flux::dropdown align="right" width="128" class="relative z-10"
                x-on:show="Livewire.dispatch('dropdown-shown')" x-on:hide="Livewire.dispatch('dropdown-hidden')">
                <flux:button icon="bell"
                    class="group relative m-auto text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm rounded-full size-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 dark:border-slate-700/50">
                </flux:button>
                {{-- <div
                    class="absolute top-0 right-0 w-3 h-3 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full animate-pulse">
                </div> --}}
                <flux:menu
                    class="mt-2 -translate-x-8 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20 rounded-2xl overflow-hidden">
                    <div class="p-4 lg:w-128 w-full">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Notifikasi</h3>
                        </div>
                        {{-- Panggil komponen Livewire di dalam dropdown --}}
                        <livewire:connections.requested-connection wire:key="requested-connection" />
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
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 hover:bg-blue-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Dashboard') }}</span>
                </a>

                <!-- Connections -->
                @if ($connectionsEnabled || $isSuperAdmin)
                    <a href="{{ route('connections') }}"
                        class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('connections') ? 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400 hover:bg-indigo-500/10' }}"
                        wire:navigate>
                        <div class="w-6 h-6 mb-1">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium">{{ __('Koneksi') }}</span>
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
                            <span>Fitur koneksi sedang dinonaktifkan</span>
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
                <a href="{{ route('ecosystem.browse') }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('ecosystem.*') ? 'bg-green-500/20 text-green-600 dark:text-green-400' : 'text-slate-600 hover:text-green-600 dark:text-slate-300 dark:hover:text-green-400 hover:bg-green-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Ekosistem') }}</span>
                </a>

                <!-- Aksi Kolektif -->
                <a href="{{ route('collective-action.browse') }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('collective-action.*') ? 'bg-purple-500/20 text-purple-600 dark:text-purple-400' : 'text-slate-600 hover:text-purple-600 dark:text-slate-300 dark:hover:text-purple-400 hover:bg-purple-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Aksi Kolektif') }}</span>
                </a>

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
                <a href="{{ route('settings.profile') }}"
                    class="flex flex-col items-center justify-center size-20 rounded-2xl transition-all duration-300 group {{ request()->routeIs('settings.profile') ? 'bg-green-500/20 text-green-600 dark:text-green-400' : 'text-slate-600 hover:text-green-600 dark:text-slate-300 dark:hover:text-green-400 hover:bg-green-500/10' }}"
                    wire:navigate>
                    <div class="w-6 h-6 mb-1">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium">{{ __('Profile') }}</span>
                </a>
            </div>

            <!-- Active indicator -->
            @if (request()->routeIs('dashboard'))
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
            @elseif(request()->routeIs('events'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-pink-500 to-rose-500 rounded-t-full">
                </div>
            @elseif(request()->routeIs('settings.profile'))
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-t-full">
                </div>
            @endif
        </div>
    </div>

    @fluxScripts

    {{-- Stack for additional styles and scripts --}}
    @stack('styles')
    @stack('scripts')
</body>

</html>
