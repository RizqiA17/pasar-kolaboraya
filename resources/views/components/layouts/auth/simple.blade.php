<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen antialiased bg-primary-light-blue dark:bg-slate-900 relative">
    {{-- Decorative SVG Elements --}}
    <div class="opacity-30 p-16 absolute">
        <x-decorative-svgs />
    </div>
    <img src="{{ Storage::url('web/ASET VISUAL/bg.webp') }}" class="absolute w-full h-svh object-cover opacity-60"
        alt="">

    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div
            class="absolute -top-24 -left-24 size-[380px] rounded-full bg-[#FFE3E3] dark:bg-sky-500/10 blur-3xl opacity-60 dark:opacity-30">
        </div>
        <div
            class="absolute -bottom-24 -right-24 size-[420px] rounded-full bg-[#E3F2FF] dark:bg-purple-500/10 blur-3xl opacity-60 dark:opacity-30">
        </div>
    </div>

    <div class="relative flex min-h-svh items-center justify-center gap-8">
        <div class="lg:flex items-center justify-center gap-4 flex-grow lg:relative! absolute lg:left-0 -left-[200svw]">
            <div class="text-center lg:p-8">
                <h1 class="text-4xl sm:text-5xl font-bold text-navy dark:text-slate-100 mb-8 leading-tight">
                    Bangun Koneksi, Kolaborasi, <br>dan Aksi Bersama untuk Perubahan Sosial
                </h1>
                <p class="text-xl sm:text-2xl text-gray-600 dark:text-slate-300 mb-12 max-w-3xl mx-auto">
                    Pasar Kolaboraya adalah ruang <span
                        class="text-secondary-green dark:text-sky-400 font-semibold">temu
                        lintas-ekosistem</span> bagi Kreator Perubahan Sosial yang siap <span
                        class="text-coral dark:text-coral-400 font-semibold">memperluas dampak</span>.
                </p>
            </div>
        </div>

        <div class="w-full max-w-md max-h-svh overflow-y-auto">
            <div
                class="rounded-2xl lg:h-svh max-h-svh overflow-y-auto pt-12 flex flex-col justify-center gap-4 lg:gap-8 border lg:rounded-r-none border-white/60 dark:border-slate-700/50 bg-white/70 dark:bg-slate-800/80 backdrop-blur-xl shadow-xl dark:shadow-slate-900/50">
                <div class="flex items-center justify-center relative">
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
                <div class="px-8 py-7 max-h-svh overflow-y-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
