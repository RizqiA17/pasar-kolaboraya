<x-admin.layout title="Detail Pengguna - {{ $user->name }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Pengguna</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $user->name }}</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                    Edit Pengguna
                </a>
                <a href="{{ route('admin.users') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Kembali ke Pengguna
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Nama</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Email</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Peran</label>
                            @php
                                $roleColors = [
                                    'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                    'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                    'super_admin' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Email Terverifikasi</label>
                            <p class="text-slate-800 dark:text-slate-200">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">Ya</span> ({{ $user->email_verified_at->format('M d, Y H:i') }})
                                @else
                                    <span class="text-red-600 dark:text-red-400">Tidak</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Bergabung</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Terakhir Diperbarui</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Profil -->
                @if($user->profile)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Profil</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($user->profile->organization)
                                <div>
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Organisasi</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->organization }}</p>
                                </div>
                            @endif
                            @if($user->profile->phone)
                                <div>
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Telepon</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->phone }}</p>
                                </div>
                            @endif
                            @if($user->profile->vision)
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Visi</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->vision }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Koneksi -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Koneksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $user->sentConnections->where('status', 'accepted')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Accepted Koneksi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $user->sentConnections->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Dikirim</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $user->receivedConnections->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Diterima</div>
                        </div>
                    </div>
                </div>

                <!-- Kolaborasi -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Kolaborasi</h3>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $user->collaborations->count() }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">Active Kolaborasi</div>
                    </div>
                </div>

                <!-- Acara -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Acara</h3>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $user->events->count() }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">Participating Acara</div>
                    </div>
                </div>

                <!-- Quality Metrics & Analytics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-6">Analisis Kualitas & Kesehatan Partisipasi</h3>
                    
                    <!-- Engagement Score -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-md font-medium text-slate-700 dark:text-slate-300">Skor Keterlibatan</h4>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ min(100, max(0, round(($user->sentConnections->where('status', 'accepted')->count() * 10 + $user->collaborations->count() * 15 + $user->events->count() * 5 + $user->activeCollectiveActions->count() * 20) / 2))) }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full" 
                                 style="width: {{ min(100, max(0, round(($user->sentConnections->where('status', 'accepted')->count() * 10 + $user->collaborations->count() * 15 + $user->events->count() * 5 + $user->activeCollectiveActions->count() * 20) / 2))) }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Berdasarkan koneksi, kolaborasi, acara, dan aksi kolektif</p>
                    </div>

                    <!-- Activity Distribution Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-slate-700 dark:text-slate-300 mb-4">Distribusi Aktivitas</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="userActivityChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Quality Indicators -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-slate-600 dark:text-slate-400">Tingkat Konektivitas</h5>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Rasio koneksi aktif</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                        {{ $user->sentConnections->where('status', 'accepted')->count() > 0 ? round(($user->sentConnections->where('status', 'accepted')->count() / max(1, $user->sentConnections->count())) * 100) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-slate-600 dark:text-slate-400">Tingkat Kolaborasi</h5>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Kolaborasi per bulan</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                        {{ $user->collaborations->count() > 0 ? round($user->collaborations->count() / max(1, $user->created_at->diffInMonths(now()))) : 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-slate-600 dark:text-slate-400">Kontribusi Aksi Kolektif</h5>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Aksi yang diikuti</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                        {{ $user->activeCollectiveActions->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-slate-600 dark:text-slate-400">Tingkat Partisipasi</h5>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Aktivitas per minggu</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ $user->created_at->diffInWeeks(now()) > 0 ? round(($user->collaborations->count() + $user->events->count() + $user->activeCollectiveActions->count()) / max(1, $user->created_at->diffInWeeks(now()))) : 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Avatar -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                    <x-ui.avatar :user="$user" size="xl" class="mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $user->name }}</h3>
                    <p class="text-slate-600 dark:text-slate-400">{{ $user->email }}</p>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="block w-full px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Pengguna
                        </a>
                        @if(!$user->isSuperAdmin() || \App\Models\User::where('role', 'super_admin')->count() > 1)
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Hapus Pengguna
                                </button>
                            </form>
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
            // User Activity Distribution Chart
            const userActivityCtx = document.getElementById('userActivityChart');
            if (userActivityCtx) {
                new Chart(userActivityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Koneksi', 'Kolaborasi', 'Acara', 'Aksi Kolektif'],
                        datasets: [{
                            data: [
                                {{ $user->sentConnections->where('status', 'accepted')->count() }},
                                {{ $user->collaborations->count() }},
                                {{ $user->events->count() }},
                                {{ $user->activeCollectiveActions->count() }}
                            ],
                            backgroundColor: [
                                '#3B82F6', // Blue
                                '#8B5CF6', // Purple
                                '#EC4899', // Pink
                                '#F59E0B'  // Orange
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
</x-admin.layout>
