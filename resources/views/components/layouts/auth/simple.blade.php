<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased bg-gradient-to-b from-[#FFF7ED] via-[#F0F7FF] to-white relative">
        {{-- Decorative SVG Elements --}}
        <x-decorative-svgs />
        
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -left-24 size-[380px] rounded-full bg-[#FFE3E3] blur-3xl opacity-60"></div>
            <div class="absolute -bottom-24 -right-24 size-[420px] rounded-full bg-[#E3F2FF] blur-3xl opacity-60"></div>
        </div>

        <div class="relative flex min-h-svh flex-col items-center justify-center gap-8 p-6 md:p-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-zinc-800" wire:navigate>
                <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Logo Pasar Kolaboraya" class="h-20 w-auto" />
            </a>

            <div class="w-full max-w-md">
                <div class="rounded-2xl border border-white/60 bg-white/70 backdrop-blur-xl shadow-xl">
                    <div class="px-8 py-7">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
