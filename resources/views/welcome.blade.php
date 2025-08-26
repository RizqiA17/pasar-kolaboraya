<x-layouts.guest>
    <!-- Hero Section -->
    <div class="relative min-h-screen bg-cream overflow-hidden">
        <!-- Navigation -->
        <nav class="absolute top-0 w-full z-50 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="text-navy text-2xl font-bold">
                    Pasar Kolaboraya
                </div>
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-navy text-white rounded-full hover:bg-blue-700 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-navy hover:text-blue-700 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-navy text-white rounded-full hover:bg-blue-700 transition">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative pt-32 pb-16 sm:pt-48">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-coral rounded-full filter blur-3xl opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute top-1/2 right-0 w-96 h-96 bg-sky rounded-full filter blur-3xl opacity-20 translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-purple rounded-full filter blur-3xl opacity-20"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl sm:text-7xl font-bold text-navy mb-8 leading-tight">
                        Kolaborasi untuk<br>Perubahan Sosial
                    </h1>
                    <p class="text-xl sm:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto">
                        Pasar Kolaboraya adalah ruang <span class="text-sky font-semibold">temu lintas-ekosistem</span> bagi Kreator Perubahan Sosial yang siap <span class="text-coral font-semibold">memperluas dampak</span>.
                    </p>
                    <div class="space-x-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-navy text-white rounded-full text-lg font-semibold hover:bg-blue-700 transition">
                            Bergabung Sekarang
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Features -->
                <div class="mt-32 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="bg-sky/10 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                            <svg class="w-6 h-6 text-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy mb-3">Jaringan Luas</h3>
                        <p class="text-gray-600">Terhubung dengan kreator perubahan sosial dari berbagai latar belakang dan fokus.</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="bg-coral/10 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                            <svg class="w-6 h-6 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy mb-3">Kolaborasi Efektif</h3>
                        <p class="text-gray-600">Temukan partner yang sesuai dan kolaborasi untuk menciptakan dampak yang lebih besar.</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="bg-purple/10 w-12 h-12 flex items-center justify-center rounded-xl mb-6">
                            <svg class="w-6 h-6 text-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy mb-3">Dampak Terukur</h3>
                        <p class="text-gray-600">Pantau dan ukur dampak dari setiap kolaborasi yang Anda lakukan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-32 pb-8">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="border-t border-gray-200 pt-8 text-center text-gray-500">
                    <p>&copy; 2025 Pasar Kolaboraya. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <style>
        .bg-cream { background-color: #FFFBF5; }
        .bg-navy { background-color: #1E365C; }
        .text-navy { color: #1E365C; }
        .bg-coral { background-color: #FF6B6B; }
        .text-coral { color: #FF6B6B; }
        .bg-sky { background-color: #4ECDC4; }
        .text-sky { color: #4ECDC4; }
        .bg-purple { background-color: #9C6BFF; }
        .text-purple { color: #9C6BFF; }
    </style>
</x-layouts.guest>
