<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen antialiased bg-primary-light-blue dark:bg-slate-900 relative">
    {{-- Decorative SVG Elements --}}
    <x-decorative-svgs />

    {{-- <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div
            class="absolute -top-24 -left-24 size-[380px] rounded-full bg-[#FFE3E3] dark:bg-sky-500/10 blur-3xl opacity-60 dark:opacity-30">
        </div>
        <div
            class="absolute -bottom-24 -right-24 size-[420px] rounded-full bg-[#E3F2FF] dark:bg-purple-500/10 blur-3xl opacity-60 dark:opacity-30">
        </div>
    </div> --}}

    <div class="relative flex min-h-svh flex-col items-center justify-center gap-8 p-6 md:p-10">

        <div class="w-full max-w-md">
            <div
                class="rounded-2xl border pt-12 border-white/60 dark:border-slate-700/50 bg-white/70 dark:bg-slate-800/80 backdrop-blur-xl shadow-xl dark:shadow-slate-900/50">
                <div class="flex justify-center items-center relative">
                    <a href="{{ route('home') }}"
                        class="flex items-center font-semibold text-zinc-800 dark:text-slate-200" wire:navigate>
                        <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Logo Pasar Kolaboraya"
                            class="h-20 w-auto block dark:hidden" />
                        <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025-white.webp') }}"
                            alt="Logo Pasar Kolaboraya" class="h-20 w-auto hidden dark:block" />
                    </a>
                    <!-- Dark Mode Toggle -->
                    <div class="absolute right-4 top-0">
                        <x-dark-mode-toggle />
                    </div>
                </div>
                <div class="px-8 py-7">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
