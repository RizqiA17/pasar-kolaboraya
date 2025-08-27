<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        <div class="relative grid min-h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex">
                <div class="absolute inset-0 bg-gradient-to-br from-[#1E365C] via-[#4ECDC4] to-[#FF6B6B]"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer><flux:heading>{{ trim($author) }}</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="relative mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[380px]">
                    <a href="{{ route('home') }}" class="z-20 flex items-center gap-3 font-semibold text-zinc-800 lg:hidden" wire:navigate>
                        <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Logo Pasar Kolaboraya" class="h-10 w-auto" />
                    </a>
                    <div class="rounded-2xl border border-white/60 bg-white/70 backdrop-blur-xl shadow-xl">
                        <div class="px-8 py-7">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
