<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $code ?? 'Error' }} - {{ $message ?? 'Terjadi Kesalahan' }} | {{ config('app.name', 'Pasar Kolaboraya') }}</title>
    
    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-white to-gray-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-slate-200/20 dark:bg-slate-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gray-200/20 dark:bg-gray-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-8">
        <!-- Logo -->
        <div class="mb-8">
            <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" 
                 alt="Pasar Kolaboraya Logo" 
                 class="w-24 h-24 md:w-32 md:h-32 object-contain">
        </div>

        <!-- Error Content -->
        <div class="text-center max-w-2xl mx-auto">
            <!-- Error Number -->
            <div class="mb-6">
                <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-slate-600 via-gray-600 to-zinc-600 bg-clip-text text-transparent">
                    {{ $code ?? 'Error' }}
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    {{ $message ?? 'Terjadi Kesalahan' }}
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Maaf, terjadi kesalahan yang tidak terduga. Silakan coba lagi atau hubungi tim support kami jika masalah berlanjut.
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

            <!-- Error Details -->
            @if(config('app.debug'))
            <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 text-left">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-3">
                    Detail Error (Development Mode)
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400">Error Code:</span>
                        <span class="font-mono text-slate-800 dark:text-slate-200">{{ $code ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400">Message:</span>
                        <span class="font-mono text-slate-800 dark:text-slate-200">{{ $message ?? 'No message' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600 dark:text-slate-400">Time:</span>
                        <span class="font-mono text-slate-800 dark:text-slate-200">{{ now()->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Help Information -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-blue-700 dark:text-blue-300">
                        Butuh bantuan? Hubungi support kami di support@kolaboraya.com
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
</body>
</html>
