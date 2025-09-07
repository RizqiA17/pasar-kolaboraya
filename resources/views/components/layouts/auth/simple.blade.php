<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased bg-gradient-to-b from-[#FFF7ED] via-[#F0F7FF] to-white dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 relative">
        {{-- Decorative SVG Elements --}}
        <x-decorative-svgs />
        
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -left-24 size-[380px] rounded-full bg-[#FFE3E3] dark:bg-pink-500/10 blur-3xl opacity-60"></div>
            <div class="absolute -bottom-24 -right-24 size-[420px] rounded-full bg-[#E3F2FF] dark:bg-blue-500/10 blur-3xl opacity-60"></div>
        </div>

        <div class="relative flex min-h-svh flex-col items-center justify-center gap-8 p-6 md:p-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-zinc-800 dark:text-slate-200" wire:navigate>
                    <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Logo Pasar Kolaboraya" class="h-20 w-auto" />
                </a>
                <!-- Dark Mode Toggle -->
                <x-dark-mode-toggle />
            </div>

            <div class="w-full max-w-md">
                <div class="rounded-2xl border border-white/60 dark:border-slate-700/50 bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl shadow-xl">
                    <div class="px-8 py-7">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
