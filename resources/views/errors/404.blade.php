<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 - Halaman Tidak Ditemukan | {{ config('app.name', 'Pasar Kolaboraya') }}</title>

    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200/20 dark:bg-blue-600/10 rounded-full blur-3xl">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200/20 dark:bg-purple-600/10 rounded-full blur-3xl">
        </div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-8">
        <!-- Logo -->
        <div class="mb-8">
            <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Pasar Kolaboraya Logo"
                class="w-24 h-24 md:w-32 md:h-32 object-contain">
        </div>

        <!-- 404 Content -->
        <div class="text-center max-w-2xl mx-auto">
            <!-- Error Number -->
            <div class="mb-6">
                <h1
                    class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    404
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    Halaman Tidak Ditemukan
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
                    Mari kita bantu Anda kembali ke jalur yang benar.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Kembali ke Beranda
                </a>

                <button onclick="window.history.back()"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 5v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Kembali
                </button>

                {{-- @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 5v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Masuk
                    </a>
                @endauth --}}
            </div>

            <!-- Search Suggestion -->
            {{-- <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-white/20 dark:border-slate-700/50">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-3">
                    Cari Sesuatu?
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">
                    Gunakan fitur pencarian untuk menemukan konten yang Anda butuhkan
                </p>
                <div class="flex gap-2">
                    <input type="text" 
                           placeholder="Cari kolaborasi, event, atau user..." 
                           class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-slate-200">
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="absolute bottom-4 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Pasar Kolaboraya') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
