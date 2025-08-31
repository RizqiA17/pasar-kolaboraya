<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">

    <flux:header sticky class="relative border-b border-white/20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-blue-500/10">
        <!-- Background gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-pink-600/5"></div>
        
        <flux:sidebar.toggle
            class="relative z-10 lg:hidden text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 transition-all duration-300" icon="bars-2"
            inset="left" />

        <a href="{{ route('dashboard') }}"
            class="relative z-10 lg:flex items-center p-y-3 rounded-lg transition-all duration-300 lg:me-8 hidden group"wire:navigate>
            <x-app-logo />
        </a>

        <flux:spacer />

        {{-- Modern Notification --}}
        <x-flux::dropdown align="right" width="128" class="relative z-10" x-on:show="Livewire.dispatch('dropdown-shown')"
            x-on:hide="Livewire.dispatch('dropdown-hidden')">
            <flux:button icon="bell"
                class="group relative m-auto text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 bg-white/60 hover:bg-white/80 dark:bg-slate-800/60 dark:hover:bg-slate-800/80 backdrop-blur-sm rounded-full size-10 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20 dark:border-slate-700/50">
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full animate-pulse"></div>
            </flux:button>
            <flux:menu
                class="mt-2 -translate-x-8 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20 rounded-2xl overflow-hidden">
                <div class="p-4 w-128">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Notifikasi</h3>
                        <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">3 baru</span>
                    </div>
                    {{-- Panggil komponen Livewire di dalam dropdown --}}
                    <livewire:connections.requested-connection wire:key="requested-connection" />
                </div>
            </flux:menu>
        </x-flux::dropdown>

        <flux:dropdown position="top" align="end" class="relative z-10 lg:hidden ms-4">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down"
                class="group bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105" />

            <flux:menu class="mt-2 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-white/20 dark:border-slate-700/50 shadow-2xl shadow-blue-500/20 rounded-2xl overflow-hidden">
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

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent"></div>

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="user" wire:navigate
                        class="px-4 py-3 text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-all duration-200">
                        {{ __('Profile') }}</flux:menu.item>
                </flux:menu.radio.group>

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent"></div>

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

    {{-- Modern Sidebar hanya untuk user profile dan settings --}}
    <flux:sidebar sticky stashable class="border-e border-white/20 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl lg:block hidden">
        <flux:sidebar.toggle
            class="lg:hidden text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 transition-all duration-300"
            icon="x-mark" />

        <flux:spacer />

        <flux:navlist variant="outline" class="space-y-3">
            <flux:navlist.group :heading="__('Settings')" class="grid">
                <flux:navlist.item :href="route('settings.profile')" icon="user" wire:navigate
                    class="group relative text-slate-700 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-200 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-all duration-300 rounded-xl px-4 py-3">
                    <span class="relative z-10">{{ __('Profile') }}</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </flux:navlist.item>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full group relative text-slate-700 hover:text-red-600 hover:bg-red-50 dark:text-slate-200 dark:hover:text-red-400 dark:hover:bg-red-900/20 transition-all duration-300 rounded-xl px-4 py-3">
                        <span class="relative z-10">{{ __('Log Out') }}</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-pink-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </flux:navlist.item>
                </form>
            </flux:navlist.group>
        </flux:navlist>

        <!-- Modern Desktop User Profile -->
        <div class="mt-6 p-4 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-2xl border border-white/20 dark:border-slate-700/50">
            <div class="flex items-center gap-3">
                <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-xl">
                    <x-ui.avatar :user="auth()->user()" size="lg" :showStatus="true" />
                </span>

                <div class="grid flex-1 text-start">
                    <span class="truncate font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                    <span class="truncate text-sm text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</span>
                </div>
            </div>
        </div>
    </flux:sidebar>

    {{-- Modern Background with subtle gradients --}}
    <div class="fixed size-0">
        <div class="pointer-events-none absolute inset-0 overflow-hidden lg:ml-64 h-[100svh] lg:w-[100svw_-_16rem] w-[100svw]">
            <!-- Subtle gradient overlays -->
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-50/30 via-transparent to-purple-50/30 dark:from-blue-900/20 dark:to-purple-900/20"></div>
            
            <!-- Floating elements -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-blue-400/10 to-purple-400/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-r from-purple-400/10 to-pink-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-gradient-to-r from-pink-400/10 to-rose-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>
    </div>

    {{ $slot }}

    @fluxScripts
</body>

</html>
