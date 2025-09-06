<x-admin.layout title="Dashboard">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Dashboard Admin</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah aktivitas terbaru di sistem Anda.</p>
            </div>
            <div class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <!-- Users Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Total Pengguna</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['users']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.users') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                        Lihat semua pengguna →
                    </a>
                </div>
            </div>

            <!-- Collaborations Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Kolaborasi</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['collaborations']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.collaborations') }}" class="text-xs sm:text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                        Lihat semua kolaborasi →
                    </a>
                </div>
            </div>

            <!-- Events Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Acara</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['events']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 dark:bg-pink-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.events') }}" class="text-xs sm:text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium">
                        Lihat semua acara →
                    </a>
                </div>
            </div>

            <!-- Connections Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Koneksi</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['connections']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.connections') }}" class="text-xs sm:text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                        Lihat semua koneksi →
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Minat</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['interests']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Keahlian</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['skills']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Kontribusi</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['contributions']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Kategori Acara</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-200">{{ number_format($stats['event_categories']) }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
            <!-- Recent Users -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800 dark:text-slate-200">Pengguna Terbaru</h3>
                    <a href="{{ route('admin.users') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center space-x-3">
                            <x-ui.avatar :user="$user" size="sm" />
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada pengguna ditemukan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Collaborations -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800 dark:text-slate-200">Kolaborasi Terbaru</h3>
                    <a href="{{ route('admin.collaborations') }}" class="text-xs sm:text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentCollaborations as $collaboration)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $collaboration->title }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">by {{ $collaboration->creator->name }}</p>
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $collaboration->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada kolaborasi ditemukan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Events -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800 dark:text-slate-200">Acara Terbaru</h3>
                    <a href="{{ route('admin.events') }}" class="text-xs sm:text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentEvents as $event)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $event->title }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">by {{ $event->creator->name }}</p>
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $event->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada acara ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
