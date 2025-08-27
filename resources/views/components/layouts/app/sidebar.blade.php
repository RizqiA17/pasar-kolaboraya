<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:header sticky class="border-b border-blue-200 bg-navy shadow-lg">
        <flux:sidebar.toggle
            class="lg:hidden text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300" icon="bars-2"
            inset="left" />

        <a href="{{ route('dashboard') }}"
            class="lg:flex items-center p-y-3 rounded-lg transition-all duration-300 lg:me-8 hidden"wire:navigate>
            <x-app-logo />
        </a>

        <livewire:components.search-bar align="center" />

        <flux:spacer />

        {{-- Notification --}}
        <x-flux::dropdown align="right" width="96" class="relative" 
            x-on:show="Livewire.dispatch('dropdown-shown')"
            x-on:hide="Livewire.dispatch('dropdown-hidden')">
            <flux:button icon="bell"
                class="m-auto text-white bg-cream! rounded-full size-10 shadow-lg hover:shadow-xl transition-all duration-300">
            </flux:button>
            <flux:menu
                class="-translate-x-8 bg-white border border-blue-200 dark:bg-gray-800 dark:border-blue-600 shadow-lg">
                <div class="p-3 w-96">
                    {{-- Panggil komponen Livewire di dalam dropdown --}}
                    <livewire:connections.requested-connection wire:key="requested-connection" />
                </div>
            </flux:menu>
        </x-flux::dropdown>

        <flux:dropdown position="top" align="end" class="lg:hidden ms-4">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down"
                class="bg-gradient-to-r from-blue-200 to-purple-200 hover:from-blue-300 hover:to-purple-300 dark:from-blue-700 dark:to-purple-700 dark:hover:from-blue-600 dark:hover:to-purple-600 transition-all duration-300" />

            <flux:menu class="bg-white border border-blue-200 dark:bg-gray-800 dark:border-blue-600 shadow-lg">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 text-white shadow-lg">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span
                                    class="truncate font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</span>
                                <span
                                    class="truncate text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator class="border-gray-200 dark:border-gray-600" />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate
                        class="text-gray-700 hover:text-blue-600 hover:bg-blue-100 dark:text-gray-200 dark:hover:text-blue-300 dark:hover:bg-blue-800">
                        {{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator class="border-gray-200 dark:border-gray-600" />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full text-gray-700 hover:text-red-600 hover:bg-red-100 dark:text-gray-200 dark:hover:text-red-300 dark:hover:bg-red-800">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:sidebar sticky stashable class="border-e border-blue-200">
        <flux:sidebar.toggle
            class="lg:hidden text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
            icon="x-mark" />

        <flux:navlist variant="outline" class="space-y-2">
            <flux:navlist.group :heading="__('Menu')" class="grid">

                <flux:menu.separator class="border-gray-200 dark:border-gray-600" />

                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    class="text-gray-700 hover:text-blue-600 hover:bg-blue-200 dark:text-gray-200 dark:hover:text-blue-300 dark:hover:bg-blue-700 transition-all duration-200"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                <flux:navlist.item icon="link" :href="route('connections')"
                    :current="request()->routeIs('connections')"
                    class="text-gray-700 hover:text-indigo-600 hover:bg-indigo-200 dark:text-gray-200 dark:hover:text-indigo-300 dark:hover:bg-indigo-700 transition-all duration-200"
                    wire:navigate>{{ __('Koneksi') }}</flux:navlist.item>

                <flux:navlist.item icon="users" :href="route('collaborations')"
                    :current="request()->routeIs('collaborations')"
                    class="text-gray-700 hover:text-purple-600 hover:bg-purple-200 dark:text-gray-200 dark:hover:text-purple-300 dark:hover:bg-purple-700 transition-all duration-200"
                    wire:navigate>{{ __('Kolaborasi') }}
                </flux:navlist.item>

                <flux:navlist.item icon="user-group" :href="route('events')" :current="request()->routeIs('events')"
                    class="text-gray-700 hover:text-pink-600 hover:bg-pink-200 dark:text-gray-200 dark:hover:text-pink-300 dark:hover:bg-pink-700 transition-all duration-200"
                    wire:navigate>{{ __('Aksi Bersama') }}</flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline" class="space-y-2">

            <flux:navlist.group :heading="__('Settings')" class="grid">

                <flux:menu.separator class="border-gray-200 dark:border-gray-600" />

                <flux:navlist.item :href="route('settings.profile')" icon="cog" wire:navigate
                    class="text-gray-700 hover:text-blue-600 hover:bg-blue-100 dark:text-gray-200 dark:hover:text-blue-300 dark:hover:bg-blue-800">
                    {{ __('Settings') }}
                </flux:navlist.item>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full text-gray-700 hover:text-red-600 hover:bg-red-100 dark:text-gray-200 dark:hover:text-red-300 dark:hover:bg-red-800">
                        {{ __('Log Out') }}
                    </flux:navlist.item>
                </form>
            </flux:navlist.group>

            <flux:menu.separator class="border-gray-200 dark:border-gray-600" />

        </flux:navlist>

        <!-- Desktop User Menu -->
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                <span
                    class="flex h-full w-full items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 text-white shadow-lg">
                    {{ auth()->user()->initials() }}
                </span>
            </span>

            <div class="grid flex-1 text-start text-sm leading-tight">
                <span class="truncate font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</span>
                <span class="truncate text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </flux:sidebar>

    <div class="fixed size-0">
        <div
            class="pointer-events-none absolute inset-0 overflow-hidden lg:ml-64 h-[100svh] lg:w-[100svw_-_16rem] w-[100svw] bg-cream">
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-coral/30 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-sky/30 blur-3xl"></div>
            <div class="absolute top-1/3 -left-10 h-64 w-64 rounded-full bg-purple/20 blur-3xl"></div>
        </div>
    </div>

    {{ $slot }}

    @fluxScripts
</body>

</html>
