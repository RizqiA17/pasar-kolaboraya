<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>419 - Sesi Berakhir | {{ config('app.name', 'Pasar Kolaboraya') }}</title>
    
    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css'])
    
    <!-- Prevent JavaScript alerts and disable CSRF token manager -->
    <script>
        // Override alert and confirm functions to prevent browser alerts
        window.alert = function() { return true; };
        window.confirm = function() { return true; };
        
        // Prevent beforeunload events that might trigger alerts
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        });
        
        // Disable CSRF token manager if it exists
        if (window.csrfTokenManager) {
            window.csrfTokenManager.destroy();
        }
        
        // Prevent any error dialogs
        window.addEventListener('error', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Override console.error to prevent error dialogs
        const originalConsoleError = console.error;
        console.error = function() {
            // Don't show error dialogs, just log silently
            originalConsoleError.apply(console, arguments);
        };
        
        // Prevent Livewire from showing error dialogs
        if (window.Livewire) {
            window.Livewire.hook('message.failed', () => {
                return false; // Prevent default error handling
            });
            
            window.Livewire.hook('message.exception', () => {
                return false; // Prevent default exception handling
            });
        }
        
        // Override fetch to prevent error alerts
        const originalFetch = window.fetch;
        window.fetch = function() {
            return originalFetch.apply(this, arguments).catch(function(error) {
                // Don't show alerts for fetch errors
                console.log('Fetch error (suppressed):', error);
                return Promise.reject(error);
            });
        };
        
        // Prevent any unhandled promise rejections from showing alerts
        window.addEventListener('unhandledrejection', function(e) {
            e.preventDefault();
            console.log('Unhandled promise rejection (suppressed):', e.reason);
        });
    </script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-amber-200/20 dark:bg-amber-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-200/20 dark:bg-orange-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-8">
        <!-- Logo -->
        <div class="mb-8">
            <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" 
                 alt="Pasar Kolaboraya Logo" 
                 class="w-24 h-24 md:w-32 md:h-32 object-contain">
        </div>

        <!-- 419 Content -->
        <div class="text-center max-w-2xl mx-auto">
            <!-- Error Number -->
            <div class="mb-6">
                <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 bg-clip-text text-transparent">
                    419
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    Sesi Anda Telah Berakhir
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                    Maaf, sesi Anda telah berakhir karena tidak ada aktivitas dalam waktu yang lama. 
                    Ini adalah langkah keamanan untuk melindungi akun Anda.
                </p>
            </div>

            <!-- Security Information -->
            <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-3">
                    Mengapa Ini Terjadi?
                </h3>
                <div class="text-left space-y-2">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-amber-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Sesi otomatis berakhir setelah 2 jam tidak ada aktivitas
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-amber-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            CSRF token telah expired untuk keamanan
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-amber-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Browser cache atau cookie yang bermasalah
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 5v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Login Kembali
                </a>

                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Help Information -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                        Tips Keamanan
                    </span>
                </div>
                <p class="text-sm text-blue-600 dark:text-blue-400">
                    Untuk menghindari hal ini, pastikan Anda aktif menggunakan aplikasi dan logout dengan benar setelah selesai.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-4 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Pasar Kolaboraya') }}. All rights reserved.
            </p>
        </div>
    </div>
    
    <!-- Additional script to prevent any remaining alerts -->
    <script>
        // Run after page load to ensure all scripts are loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Override any remaining alert functions
            window.alert = function() { return true; };
            window.confirm = function() { return true; };
            
            // Disable CSRF token manager completely
            if (window.csrfTokenManager) {
                window.csrfTokenManager.destroy();
                delete window.csrfTokenManager;
            }
            
            // Prevent any form submissions that might trigger alerts
            document.addEventListener('submit', function(e) {
                e.preventDefault();
                return false;
            });
            
            // Override any remaining error handlers
            window.onerror = function() { return true; };
            window.onunhandledrejection = function() { return true; };
        });
        
        // Also run immediately in case DOMContentLoaded already fired
        window.alert = function() { return true; };
        window.confirm = function() { return true; };
        window.onerror = function() { return true; };
        window.onunhandledrejection = function() { return true; };
    </script>
</body>
</html>
