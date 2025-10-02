<x-admin.layout title="Detail Koneksi - {{ $connection->requester->name }} & {{ $connection->receiver->name }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Detail Koneksi</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">
                    {{ $connection->requester->name }} ↔ {{ $connection->receiver->name }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.connections') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors text-center">
                    Kembali ke Koneksi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Connection Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Informasi Koneksi</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Status</label>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                        'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$connection->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($connection->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Dibuat</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $connection->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @if($connection->message)
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Pesan</label>
                                <p class="text-gray-600 dark:text-slate-300">{{ $connection->message }}</p>
                            </div>
                        @endif
                        @if($connection->accepted_at)
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Diterima</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $connection->accepted_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Requester Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Pengirim Koneksi</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$connection->requester" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-primary-blue dark:text-secondary-green">{{ $connection->requester->name }}</div>
                            <div class="text-gray-600 dark:text-slate-300">{{ $connection->requester->email }}</div>
                            <div class="text-sm text-gray-500 dark:text-slate-400">Bergabung {{ $connection->requester->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Receiver Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Penerima Koneksi</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$connection->receiver" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-primary-blue dark:text-secondary-green">{{ $connection->receiver->name }}</div>
                            <div class="text-gray-600 dark:text-slate-300">{{ $connection->receiver->email }}</div>
                            <div class="text-sm text-gray-500 dark:text-slate-400">Bergabung {{ $connection->receiver->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Quality Metrics & Analytics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-6">Analisis Kualitas & Kesehatan Koneksi</h3>
                    
                    <!-- Connection Quality Score -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green">Skor Kualitas Koneksi</h4>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                @php
                                    $requesterConnections = $connection->requester->sentConnections->where('status', 'accepted')->count();
                                    $receiverConnections = $connection->receiver->sentConnections->where('status', 'accepted')->count();
                                    $requesterEcosystems = $connection->requester->ecosystems->count();
                                    $receiverEcosystems = $connection->receiver->ecosystems->count();
                                    $requesterCollectiveActions = $connection->requester->activeCollectiveActions->count();
                                    $receiverCollectiveActions = $connection->receiver->activeCollectiveActions->count();
                                    
                                    $qualityScore = min(100, max(0, round(
                                        ($connection->status === 'accepted' ? 40 : ($connection->status === 'pending' ? 20 : 0)) +
                                        (min($requesterConnections, 10) * 2) +
                                        (min($receiverConnections, 10) * 2) +
                                        (min($requesterEcosystems, 5) * 3) +
                                        (min($receiverEcosystems, 5) * 3) +
                                        (min($requesterCollectiveActions, 5) * 2) +
                                        (min($receiverCollectiveActions, 5) * 2)
                                    )));
                                @endphp
                                {{ $qualityScore }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full" 
                                 style="width: {{ $qualityScore }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Berdasarkan status koneksi, aktivitas pengguna, dan tingkat keterlibatan</p>
                    </div>

                    <!-- User Activity Comparison Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Perbandingan Aktivitas Pengguna</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="userActivityComparisonChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Connection Network Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Jaringan Koneksi</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="connectionNetworkChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Quality Indicators -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Tingkat Konektivitas Pengirim</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Koneksi aktif</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                        {{ $requesterConnections }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Tingkat Konektivitas Penerima</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Koneksi aktif</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ $receiverConnections }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Ekosistem Pengirim</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Total ekosistem</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                        {{ $requesterEcosystems }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Ekosistem Penerima</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Total ekosistem</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                        {{ $receiverEcosystems }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Timeline -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Timeline Koneksi</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="connectionTimelineChart" wire:ignore></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Statistik Cepat</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $connection->status === 'accepted' ? 'Aktif' : ucfirst($connection->status) }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Status Koneksi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $connection->created_at->diffInDays(now()) }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Hari Sejak Dibuat</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $requesterConnections + $receiverConnections }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Total Koneksi Kedua User</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.connections.delete', $connection) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Hapus Koneksi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @php
                $requesterConnections = $connection->requester->sentConnections->where('status', 'accepted')->count();
                $receiverConnections = $connection->receiver->sentConnections->where('status', 'accepted')->count();
                $requesterEcosystems = $connection->requester->ecosystems->count();
                $receiverEcosystems = $connection->receiver->ecosystems->count();
                $requesterCollectiveActions = $connection->requester->activeCollectiveActions->count();
                $receiverCollectiveActions = $connection->receiver->activeCollectiveActions->count();
            @endphp

            // User Activity Comparison Chart
            const userActivityComparisonCtx = document.getElementById('userActivityComparisonChart');
            if (userActivityComparisonCtx) {
                new Chart(userActivityComparisonCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Koneksi', 'Ekosistem', 'Aksi Kolektif'],
                        datasets: [{
                            label: '{{ $connection->requester->name }}',
                            data: [{{ $requesterConnections }}, {{ $requesterEcosystems }}, {{ $requesterCollectiveActions }}],
                            backgroundColor: '#3B82F6',
                            borderColor: '#2563EB',
                            borderWidth: 1
                        }, {
                            label: '{{ $connection->receiver->name }}',
                            data: [{{ $receiverConnections }}, {{ $receiverEcosystems }}, {{ $receiverCollectiveActions }}],
                            backgroundColor: '#10B981',
                            borderColor: '#059669',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Connection Network Chart
            const connectionNetworkCtx = document.getElementById('connectionNetworkChart');
            if (connectionNetworkCtx) {
                new Chart(connectionNetworkCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Koneksi Aktif', 'Ekosistem', 'Aksi Kolektif'],
                        datasets: [{
                            data: [
                                {{ $requesterConnections + $receiverConnections }},
                                {{ $requesterEcosystems + $receiverEcosystems }},
                                {{ $requesterCollectiveActions + $receiverCollectiveActions }}
                            ],
                            backgroundColor: [
                                '#8B5CF6', // Purple
                                '#F59E0B', // Orange
                                '#EC4899'  // Pink
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

            // Connection Timeline Chart
            const connectionTimelineCtx = document.getElementById('connectionTimelineChart');
            if (connectionTimelineCtx) {
                // Generate timeline data for the last 6 months
                const months = [];
                const connectionData = [];
                
                for (let i = 5; i >= 0; i--) {
                    const date = new Date();
                    date.setMonth(date.getMonth() - i);
                    months.push(date.toLocaleDateString('id-ID', { month: 'short' }));
                    
                    // Simulate connection activity (in real implementation, you'd query actual data)
                    const connectionDate = new Date('{{ $connection->created_at }}');
                    const monthDiff = Math.ceil((date - connectionDate) / (1000 * 60 * 60 * 24 * 30));
                    connectionData.push(monthDiff >= 0 ? 1 : 0);
                }

                new Chart(connectionTimelineCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Status Koneksi',
                            data: connectionData,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 1,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return value === 1 ? 'Aktif' : 'Tidak Aktif';
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
