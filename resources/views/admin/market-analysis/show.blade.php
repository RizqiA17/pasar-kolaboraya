<x-admin.layout title="Analisis Detail Sesi Pasar - {{ $pasarKolaboraya->name }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Analisis Detail Sesi Pasar</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $pasarKolaboraya->name }}</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('admin.market-analysis') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Kembali ke Analisis
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Analysis Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Session Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Sesi Pasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Nama Sesi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($pasarKolaboraya->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                @elseif($pasarKolaboraya->status === 'inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                @endif">
                                {{ $pasarKolaboraya->status_label }}
                            </span>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Dibuat Oleh</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->creator->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal Dibuat</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($pasarKolaboraya->started_at)
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Dimulai</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->started_at->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                        @if($pasarKolaboraya->ended_at)
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Berakhir</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $pasarKolaboraya->ended_at->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                    @if($pasarKolaboraya->description)
                        <div class="mt-4">
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Deskripsi</label>
                            <p class="text-slate-800 dark:text-slate-200 mt-1">{{ $pasarKolaboraya->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Overall Health Score -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-6">Skor Kesehatan Ekosistem</h3>
                    
                    <div class="text-center mb-6">
                        <div class="relative inline-flex items-center justify-center w-32 h-32">
                            <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="#e5e7eb" stroke-width="8" fill="none" class="dark:stroke-slate-600"></circle>
                                <circle cx="50" cy="50" r="40" stroke="url(#gradient)" stroke-width="8" fill="none" 
                                        stroke-dasharray="{{ 2 * pi() * 40 }}" 
                                        stroke-dashoffset="{{ 2 * pi() * 40 * (1 - $healthMetrics['overall_health_score'] / 100) }}"
                                        stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-slate-800 dark:text-slate-200">
                                        {{ $healthMetrics['overall_health_score'] }}
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">dari 100</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Kesehatan Ekosistem</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                @if($healthMetrics['overall_health_score'] >= 80)
                                    Sangat Sehat - Ekosistem berfungsi optimal
                                @elseif($healthMetrics['overall_health_score'] >= 60)
                                    Sehat - Ekosistem berfungsi dengan baik
                                @elseif($healthMetrics['overall_health_score'] >= 40)
                                    Cukup Sehat - Ekosistem memerlukan perhatian
                                @else
                                    Perlu Perbaikan - Ekosistem memerlukan intervensi
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Health Score Breakdown -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Kesehatan Ekosistem</span>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $healthMetrics['ecosystem_health_score'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(100, $healthMetrics['ecosystem_health_score']) }}%"></div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Indeks Kolaborasi</span>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $healthMetrics['collaboration_index'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: {{ min(100, $healthMetrics['collaboration_index']) }}%"></div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Tingkat Partisipasi</span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $healthMetrics['participation_rate'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ min(100, $healthMetrics['participation_rate']) }}%"></div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Skor Keterlibatan</span>
                                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $healthMetrics['engagement_score'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ min(100, $healthMetrics['engagement_score']) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Metrics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-6">Metrik Detail</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Network Metrics -->
                        <div>
                            <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 mb-4">Jaringan & Konektivitas</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Kepadatan Koneksi</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['connection_density'] }}%</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Total Koneksi</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['total_connections'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Keragaman Jaringan</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['network_diversity'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Growth Metrics -->
                        <div>
                            <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 mb-4">Pertumbuhan & Aktivitas</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Tingkat Pertumbuhan</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['user_growth_rate'] }}/bulan</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Pengguna Aktif</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['active_users'] }}/{{ $healthMetrics['total_users'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Utilisasi Sumber Daya</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $healthMetrics['resource_utilization'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Distribution Chart -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-6">Distribusi Aktivitas</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="activityChart" wire:ignore></canvas>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Statistik Cepat</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $healthMetrics['total_users'] }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Pengguna</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $healthMetrics['total_ecosystems'] }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Ekosistem</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $healthMetrics['total_collective_actions'] }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Aksi Kolektif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                @if($healthMetrics['days_since_start'] < 1)
                                    {{ round($healthMetrics['days_since_start'] * 24) }} jam
                                @elseif($healthMetrics['days_since_start'] < 7)
                                    {{ round($healthMetrics['days_since_start'], 1) }} hari
                                @elseif($healthMetrics['days_since_start'] < 30)
                                    {{ round($healthMetrics['days_since_start'] / 7, 1) }} minggu
                                @else
                                    {{ round($healthMetrics['days_since_start'] / 30, 1) }} bulan
                                @endif
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                @if($healthMetrics['days_since_start'] < 1)
                                    Aktif
                                @else
                                    Hari Aktif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Indicators -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Indikator Kesehatan</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Status Ekosistem</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full mr-2
                                    @if($healthMetrics['ecosystem_health_score'] >= 70) bg-green-500
                                    @elseif($healthMetrics['ecosystem_health_score'] >= 40) bg-yellow-500
                                    @else bg-red-500
                                    @endif"></div>
                                <span class="text-xs font-medium
                                    @if($healthMetrics['ecosystem_health_score'] >= 70) text-green-600 dark:text-green-400
                                    @elseif($healthMetrics['ecosystem_health_score'] >= 40) text-yellow-600 dark:text-yellow-400
                                    @else text-red-600 dark:text-red-400
                                    @endif">
                                    @if($healthMetrics['ecosystem_health_score'] >= 70) Sehat
                                    @elseif($healthMetrics['ecosystem_health_score'] >= 40) Cukup
                                    @else Perlu Perhatian
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Tingkat Kolaborasi</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full mr-2
                                    @if($healthMetrics['collaboration_index'] >= 50) bg-green-500
                                    @elseif($healthMetrics['collaboration_index'] >= 25) bg-yellow-500
                                    @else bg-red-500
                                    @endif"></div>
                                <span class="text-xs font-medium
                                    @if($healthMetrics['collaboration_index'] >= 50) text-green-600 dark:text-green-400
                                    @elseif($healthMetrics['collaboration_index'] >= 25) text-yellow-600 dark:text-yellow-400
                                    @else text-red-600 dark:text-red-400
                                    @endif">
                                    @if($healthMetrics['collaboration_index'] >= 50) Tinggi
                                    @elseif($healthMetrics['collaboration_index'] >= 25) Sedang
                                    @else Rendah
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Partisipasi</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full mr-2
                                    @if($healthMetrics['participation_rate'] >= 80) bg-green-500
                                    @elseif($healthMetrics['participation_rate'] >= 50) bg-yellow-500
                                    @else bg-red-500
                                    @endif"></div>
                                <span class="text-xs font-medium
                                    @if($healthMetrics['participation_rate'] >= 80) text-green-600 dark:text-green-400
                                    @elseif($healthMetrics['participation_rate'] >= 50) text-yellow-600 dark:text-yellow-400
                                    @else text-red-600 dark:text-red-400
                                    @endif">
                                    @if($healthMetrics['participation_rate'] >= 80) Aktif
                                    @elseif($healthMetrics['participation_rate'] >= 50) Cukup
                                    @else Rendah
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Rekomendasi</h3>
                    <div class="space-y-3">
                        @if($healthMetrics['participation_rate'] < 50)
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-orange-600 dark:text-orange-400">•</span> Tingkatkan partisipasi dengan mengirim notifikasi atau event khusus
                            </div>
                        @endif
                        
                        @if($healthMetrics['collaboration_index'] < 25)
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-orange-600 dark:text-orange-400">•</span> Dorong kolaborasi dengan membuat aksi kolektif yang menarik
                            </div>
                        @endif
                        
                        @if($healthMetrics['connection_density'] < 30)
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-orange-600 dark:text-orange-400">•</span> Fasilitasi koneksi antar pengguna dengan fitur rekomendasi
                            </div>
                        @endif
                        
                        @if($healthMetrics['network_diversity'] < 50)
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-orange-600 dark:text-orange-400">•</span> Diversifikasi jaringan dengan mengundang organisasi dari berbagai sektor
                            </div>
                        @endif
                        
                        @if($healthMetrics['overall_health_score'] >= 80)
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-green-600 dark:text-green-400">•</span> Ekosistem berjalan dengan baik, pertahankan momentum ini
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity Distribution Chart
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx) {
                new Chart(activityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pengguna', 'Ekosistem', 'Aksi Kolektif', 'Koneksi'],
                        datasets: [{
                            data: [
                                {{ $healthMetrics['total_users'] }},
                                {{ $healthMetrics['total_ecosystems'] }},
                                {{ $healthMetrics['total_collective_actions'] }},
                                {{ $healthMetrics['total_connections'] }}
                            ],
                            backgroundColor: [
                                '#3B82F6', // Blue
                                '#8B5CF6', // Purple
                                '#F59E0B', // Orange
                                '#10B981'  // Green
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

    <!-- SVG Gradient Definition -->
    <svg width="0" height="0" style="position: absolute;">
        <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#10B981;stop-opacity:1" />
            </linearGradient>
        </defs>
    </svg>
</x-admin.layout>
