<x-admin.layout title="Dashboard">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Dashboard Admin</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah aktivitas terbaru di sistem Anda.</p>
            </div>
            <div class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <!-- Users Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Total Peserta</p>
                        <p class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-blue-400">{{ number_format($stats['users']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-blue dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.users') }}" class="text-xs sm:text-sm text-primary-blue dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                        Lihat semua Peserta →
                    </a>
                </div>
            </div>

            <!-- Ecosystems Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Ekosistem</p>
                        <p class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($stats['ecosystems']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.ecosystems') }}" class="text-xs sm:text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                        Lihat semua ekosistem →
                    </a>
                </div>
            </div>

            <!-- Collective Actions Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Aksi Kolektif</p>
                        <p class="text-2xl sm:text-3xl font-bold text-pink-600 dark:text-pink-400">{{ number_format($stats['collective_actions']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 dark:bg-pink-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.collective-actions') }}" class="text-xs sm:text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium">
                        Lihat semua aksi kolektif →
                    </a>
                </div>
            </div>

            <!-- Connections Stat -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Koneksi</p>
                        <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-indigo-400">{{ number_format($stats['connections']) }}</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.connections') }}" class="text-xs sm:text-sm text-blue-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                        Lihat semua koneksi →
                    </a>
                </div>
            </div>
        </div>

        <!-- Market Analysis Card -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-primary-blue dark:text-secondary-green">Analisis Sesi Pasar</h3>
                <a href="{{ route('admin.market-analysis') }}" class="text-xs sm:text-sm text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 font-medium">
                    Lihat analisis detail →
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Sesi Aktif</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                        {{ \App\Models\PasarKolaboraya::where('status', 'active')->count() }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Total Sesi</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                        {{ \App\Models\PasarKolaboraya::count() }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Rata-rata Kesehatan</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                        @php
                            $activeSessions = \App\Models\PasarKolaboraya::where('status', 'active')->with(['acceptedUsers.profile.skills', 'ecosystems', 'collectiveActions'])->get();
                            $avgHealth = $activeSessions->avg(function($session) { return $session->calculateHealthScore(); });
                        @endphp
                        {{ $avgHealth ? round($avgHealth, 1) : 0 }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Total Partisipan</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                        {{ \App\Models\PasarKolaboraya::where('status', 'active')->withCount('acceptedUsers')->get()->sum('accepted_users_count') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- <!-- QR Scanner Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-4 sm:p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-2">QR Code Scanner</h3>
                    <p class="text-green-100 text-sm sm:text-base">Scan QR code user untuk memberikan akses ke Pasar Kolaboraya</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.qr-scanner') }}" class="inline-flex items-center px-4 py-2 bg-white text-green-600 font-medium rounded-lg hover:bg-green-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Buka Scanner
                    </a>
                </div>
            </div>
        </div> --}}

        <!-- Additional Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Minat</p>
                    <p class="text-xl sm:text-2xl font-bold text-primary-blue dark:text-secondary-green">{{ number_format($stats['interests']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Keahlian</p>
                    <p class="text-xl sm:text-2xl font-bold text-primary-blue dark:text-secondary-green">{{ number_format($stats['skills']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Kontribusi</p>
                    <p class="text-xl sm:text-2xl font-bold text-primary-blue dark:text-secondary-green">{{ number_format($stats['contributions']) }}</p>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Kategori Acara</p>
                    <p class="text-xl sm:text-2xl font-bold text-primary-blue dark:text-secondary-green">{{ number_format($stats['event_categories']) }}</p>
                </div>
            </div>
        </div>

        <!-- Ecosystem Builder Approvals -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-primary-blue dark:text-secondary-green">Ecosystem Builder</h3>
                <a href="{{ route('admin.ecosystem-builders') }}" class="text-xs sm:text-sm text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400">Kelola persetujuan</a>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Menunggu</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">{{ $stats['ecosystem_builders_pending'] ?? 0 }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Disetujui</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">{{ $stats['ecosystem_builders_approved'] ?? 0 }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Ditolak</p>
                    <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">{{ $stats['ecosystem_builders_rejected'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
            <!-- Recent Users -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-blue-600 dark:text-blue-400">Peserta Terbaru</h3>
                    <a href="{{ route('admin.users') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center space-x-3">
                            <x-ui.avatar :user="$user" size="sm" />
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-blue-600 dark:text-blue-400 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-slate-300">{{ $user->email }}</p>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-slate-300">Tidak ada Peserta ditemukan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Ecosystems -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-purple-600 dark:text-purple-400">Ekosistem Terbaru</h3>
                    <a href="{{ route('admin.ecosystems') }}" class="text-xs sm:text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentEcosystems as $ecosystem)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-purple-600 dark:text-purple-400 truncate">{{ $ecosystem->ecosystem_title }}</p>
                                <p class="text-xs text-gray-600 dark:text-slate-300">by {{ $ecosystem->creator->name }}</p>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                {{ $ecosystem->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-slate-300">Tidak ada ekosistem ditemukan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Collective Actions -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-pink-600 dark:text-pink-400">Aksi Kolektif Terbaru</h3>
                    <a href="{{ route('admin.collective-actions') }}" class="text-xs sm:text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentCollectiveActions as $collectiveAction)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-pink-600 dark:text-pink-400 truncate">{{ $collectiveAction->title }}</p>
                                <p class="text-xs text-gray-600 dark:text-slate-300">by {{ $collectiveAction->creator->name }}</p>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                {{ $collectiveAction->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-slate-300">Tidak ada aksi kolektif ditemukan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Collective Action Quality Metrics -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-primary-blue dark:text-secondary-green">Kualitas Aksi Kolektif</h3>
                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                        Pilar III
                    </span>
                </div>
                
                @php
                    $activeSessions = \App\Models\PasarKolaboraya::where('status', 'active')->with(['collectiveActions'])->get();
                    $totalCollectiveActions = $activeSessions->sum(function($session) { return $session->collectiveActions->count(); });
                    $avgCollectiveActionQuality = $activeSessions->avg(function($session) { return $session->calculateCollectiveActionQuality(); });
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Rata-rata Kualitas</p>
                        <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                            {{ $avgCollectiveActionQuality ? round($avgCollectiveActionQuality, 1) : 0 }}%
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Total Aksi Kolektif</p>
                        <p class="text-lg sm:text-xl font-bold text-primary-blue dark:text-secondary-green">
                            {{ $totalCollectiveActions }}
                        </p>
                    </div>
                </div>

                @if($totalCollectiveActions > 0)
                    <div class="mt-4 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <h4 class="text-sm font-medium text-primary-blue dark:text-secondary-green mb-2">Distribusi Kualitas</h4>
                        <div class="space-y-2">
                            @php
                                $qualityRanges = [
                                    'excellent' => ['min' => 80, 'max' => 100, 'label' => 'Sangat Baik', 'color' => 'green'],
                                    'good' => ['min' => 60, 'max' => 79, 'label' => 'Baik', 'color' => 'blue'],
                                    'fair' => ['min' => 40, 'max' => 59, 'label' => 'Cukup', 'color' => 'yellow'],
                                    'poor' => ['min' => 0, 'max' => 39, 'label' => 'Perlu Perbaikan', 'color' => 'red']
                                ];
                                
                                $qualityDistribution = [];
                                foreach($activeSessions as $session) {
                                    foreach($session->collectiveActions as $action) {
                                        $score = $action->calculateAksiScore()['aksi_score'];
                                        foreach($qualityRanges as $key => $range) {
                                            if($score >= $range['min'] && $score <= $range['max']) {
                                                $qualityDistribution[$key] = ($qualityDistribution[$key] ?? 0) + 1;
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            
                            @foreach($qualityRanges as $key => $range)
                                @if(isset($qualityDistribution[$key]) && $qualityDistribution[$key] > 0)
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600 dark:text-slate-300">{{ $range['label'] }}</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 bg-slate-200 dark:bg-slate-600 rounded-full h-2">
                                                <div class="bg-{{ $range['color'] }}-500 h-2 rounded-full" 
                                                     style="width: {{ ($qualityDistribution[$key] / $totalCollectiveActions) * 100 }}%"></div>
                                            </div>
                                            <span class="text-primary-blue dark:text-secondary-green font-medium">{{ $qualityDistribution[$key] }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-4 text-center text-gray-600 dark:text-slate-300">
                        <p class="text-sm">Belum ada aksi kolektif untuk dianalisis</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layout>
