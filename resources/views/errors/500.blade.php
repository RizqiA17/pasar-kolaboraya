<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>500 - Kesalahan Server | {{ config('app.name', 'Pasar Kolaboraya') }}</title>
    
    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-red-50 via-white to-orange-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-200/20 dark:bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-200/20 dark:bg-orange-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-8">
        <!-- Logo -->
        <div class="mb-8">
            <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" 
                 alt="Pasar Kolaboraya Logo" 
                 class="w-24 h-24 md:w-32 md:h-32 object-contain">
        </div>

        <!-- 500 Content -->
        <div class="text-center max-w-2xl mx-auto">
            <!-- Error Number -->
            <div class="mb-6">
                <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent">
                    500
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    Kesalahan Server
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Maaf, terjadi kesalahan pada server kami. Tim teknis telah diberitahu dan sedang bekerja untuk memperbaikinya. 
                    Silakan coba lagi dalam beberapa saat.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Coba Lagi
                </button>

                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Help Information -->
            <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-white/20 dark:border-slate-700/50">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-3">
                    Butuh Bantuan?
                </h3>
                <div class="grid md:grid-cols-2 gap-4 text-left">
                    <div class="space-y-2">
                        <h4 class="font-medium text-slate-700 dark:text-slate-300">Coba Ini Dulu:</h4>
                        <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            <li>• Refresh halaman</li>
                            <li>• Bersihkan cache browser</li>
                            <li>• Coba browser berbeda</li>
                            <li>• Tunggu beberapa menit</li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <h4 class="font-medium text-slate-700 dark:text-slate-300">Hubungi Kami:</h4>
                        <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            <li>• Email: support@kolaboraya.com</li>
                            <li>• WhatsApp: +62 812-3456-7890</li>
                            <li>• Jam kerja: 08:00 - 17:00 WIB</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-center justify-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-blue-700 dark:text-blue-300">
                        Status Server: Sedang Diperiksa
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-4 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Pasar Kolaboraya') }}. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto-refresh after 30 seconds if user is still on the page
        setTimeout(function() {
            if (document.visibilityState === 'visible') {
                window.location.reload();
            }
        }, 30000);
    </script>
</body>
</html>
