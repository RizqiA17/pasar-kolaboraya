{{-- <x-admin.layout title="Hasil Survey"> --}}
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    <a href="{{ route('admin.surveys') }}" class="text-blue-600 hover:text-blue-800">
                        <flux:icon.arrow-left class="size-5" />
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Hasil Survey</h1>
                </div>
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-300">{{ $survey->name }}</h2>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm">{{ $survey->description }}</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-600">{{ $totalResponses }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">Total Respon</div>
            </div>
        </div>
    
        <!-- Survey Info Card -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                        @if ($survey->is_active)
                            <span class="text-green-600">Aktif</span>
                        @else
                            <span class="text-gray-600">Tidak Aktif</span>
                        @endif
                    </div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Status Survey</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                        {{ $survey->created_at->format('d M Y') }}</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Tanggal Dibuat</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $survey->creator->name }}</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Dibuat Oleh</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $totalResponses }}</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Total Respon</div>
                </div>
            </div>
        </div>
    
        @if ($totalResponses > 0)
            <!-- Tab Navigation -->
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg">
                {{-- <div class="border-b border-slate-200 dark:border-slate-700">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button wire:click="setActiveTab('overview')"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Ringkasan
                        </button>
                        <button wire:click="setActiveTab('chart')"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'chart' ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Radar Chart
                        </button>
                        <button wire:click="setActiveTab('reasons')"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'reasons' ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Alasan Anonim
                        </button>
                    </nav>
                </div> --}}
    
                <div class="p-6">
                    {{-- @if ($activeTab === 'overview') --}}
                        <!-- Overview Tab -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Kategori Koneksi -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4 flex items-center">
                                    <flux:icon.users class="size-5 mr-2" />
                                    Koneksi
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-blue-700 dark:text-blue-300">Rata-rata Jumlah
                                            Koneksi:</span>
                                        <span
                                            class="font-semibold text-blue-800 dark:text-blue-200">{{ $averageScores['koneksi']['jumlah_koneksi'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-blue-700 dark:text-blue-300">Rata-rata Kualitas
                                            Koneksi:</span>
                                        <span
                                            class="font-semibold text-blue-800 dark:text-blue-200">{{ $averageScores['koneksi']['rata_kualitas_koneksi'] ?? 0 }}/5</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-blue-700 dark:text-blue-300">Rata-rata Keluasan
                                            Jejaring:</span>
                                        <span
                                            class="font-semibold text-blue-800 dark:text-blue-200">{{ number_format($averageScores['koneksi']['keluasan_jejaring'] ?? 0, 1) }}/5</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="text-xs text-blue-600 dark:text-blue-400 mb-1">Distribusi Keluasan Jejaring:</div>
                                        <div class="space-y-1">
                                            @php
                                                $labels = [1 => 'Lokal', 2 => 'Kabupaten', 3 => 'Provinsi', 4 => 'Nasional', 5 => 'Internasional'];
                                            @endphp
                                            @foreach($keluasanJejaringDistribution as $value => $count)
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-blue-600 dark:text-blue-400">{{ $labels[$value] }}:</span>
                                                    <span class="text-blue-800 dark:text-blue-200">{{ $count }} respon</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Kategori Kolaborasi -->
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4 flex items-center">
                                    <flux:icon.user-group class="size-5 mr-2" />
                                    Kolaborasi
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-green-700 dark:text-green-300">Rata-rata Kualitas:</span>
                                        <span
                                            class="font-semibold text-green-800 dark:text-green-200">{{ $averageScores['kolaborasi']['kualitas_kolaborasi'] ?? 0 }}/5</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-green-700 dark:text-green-300">Rata-rata Keragaman:</span>
                                        <span
                                            class="font-semibold text-green-800 dark:text-green-200">{{ $averageScores['kolaborasi']['keragaman_kolaborator'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-green-700 dark:text-green-300">Rata-rata Proyek:</span>
                                        <span
                                            class="font-semibold text-green-800 dark:text-green-200">{{ $averageScores['kolaborasi']['jumlah_proyek_kolaborasi'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-green-700 dark:text-green-300">Rata-rata Tingkat:</span>
                                        <span
                                            class="font-semibold text-green-800 dark:text-green-200">{{ $averageScores['kolaborasi']['tingkat_kolaborasi'] ?? 0 }}/5</span>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Kategori Aksi -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <h3
                                    class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-4 flex items-center">
                                    <flux:icon.bolt class="size-5 mr-2" />
                                    Aksi
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-purple-700 dark:text-purple-300">Rata-rata Aksi
                                            Besar:</span>
                                        <span
                                            class="font-semibold text-purple-800 dark:text-purple-200">{{ $averageScores['aksi']['jumlah_aksi_besar'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-purple-700 dark:text-purple-300">Rata-rata Aksi
                                            Sedang:</span>
                                        <span
                                            class="font-semibold text-purple-800 dark:text-purple-200">{{ $averageScores['aksi']['jumlah_aksi_sedang'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-purple-700 dark:text-purple-300">Rata-rata Aksi
                                            Kecil:</span>
                                        <span
                                            class="font-semibold text-purple-800 dark:text-purple-200">{{ $averageScores['aksi']['jumlah_aksi_kecil'] ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- @elseif($activeTab === 'chart') --}}
                        <!-- Chart Tab -->
                        <div class="max-w-4xl mt-4 mx-auto">
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-6 text-center">Radar
                                Chart Hasil Survey</h3>
                            <div class="rounded-lg p-6">
                                <div class="relative" style="height: 500px;">
                                    <canvas id="radarChartKoneksi"></canvas>
                                </div>
                                <div class="relative" style="height: 500px;">
                                    <canvas id="radarChartKolaborasi"></canvas>
                                </div>
                                <div class="relative" style="height: 500px;">
                                    <canvas id="radarChartAksi"></canvas>
                                </div>
                            </div>
                        </div>
                    {{-- @elseif($activeTab === 'reasons') --}}
                        <!-- Reasons Tab -->
                        <div class="space-y-6">
                            <!-- Kategori Koneksi -->
                            <div>
                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-4 flex items-center">
                                    <flux:icon.users class="size-5 mr-2" />
                                    Alasan - Kategori Koneksi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Jumlah Koneksi</h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['koneksi']['jumlah_koneksi'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Kualitas Koneksi
                                        </h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['koneksi']['rata_kualitas_koneksi'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Keluasan Jejaring
                                        </h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['koneksi']['keluasan_jejaring'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Kategori Kolaborasi -->
                            <div>
                                <h3
                                    class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4 flex items-center">
                                    <flux:icon.user-group class="size-5 mr-2" />
                                    Alasan - Kategori Kolaborasi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Kualitas Kolaborasi
                                        </h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['kolaborasi']['kualitas_kolaborasi'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Keragaman
                                            Kolaborator</h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['kolaborasi']['keragaman_kolaborator'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Proyek Kolaborasi
                                        </h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['kolaborasi']['jumlah_proyek_kolaborasi'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Kategori Aksi -->
                            <div>
                                <h3
                                    class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-4 flex items-center">
                                    <flux:icon.bolt class="size-5 mr-2" />
                                    Alasan - Kategori Aksi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Aksi Besar</h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['aksi']['jumlah_aksi_besar'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Aksi Sedang</h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['aksi']['jumlah_aksi_sedang'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-2">Aksi Kecil</h4>
                                        <div class="space-y-2 max-h-40 overflow-y-auto">
                                            @forelse($anonymousReasons['aksi']['jumlah_aksi_kecil'] as $index => $reason)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">Responden
                                                        {{ $index + 1 }}:</span>
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $reason }}</p>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada alasan yang
                                                    diberikan.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                </div>
            </div>
        @else
            <!-- No Responses -->
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                <flux:icon.chart-bar class="size-16 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum Ada Respon</h3>
                <p class="text-gray-500 dark:text-gray-400">Survey ini belum memiliki respon dari peserta.</p>
            </div>
        @endif
    </div>
    
    {{-- @if ($totalResponses > 0 && $activeTab === 'chart') --}}
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                let radarChartInstanceKoneksi = null;
                let radarChartInstanceKolaborasi = null;
                let radarChartInstanceAksi = null;
    
                initializeRadarChart();
    
                function initializeRadarChart() {
                    const canvasKoneksi = document.getElementById('radarChartKoneksi');
                    const canvasKolaborasi = document.getElementById('radarChartKolaborasi');
                    const canvasAksi = document.getElementById('radarChartAksi');
                    if (!canvasKoneksi || !canvasKolaborasi || !canvasAksi) {
                        console.error('Canvas element not found');
                        return;
                    }
    
                    // Destroy existing charts if they exist
                    if (radarChartInstanceKoneksi) {
                        radarChartInstanceKoneksi.destroy();
                    }
                    if (radarChartInstanceKolaborasi) {
                        radarChartInstanceKolaborasi.destroy();
                    }
                    if (radarChartInstanceAksi) {
                        radarChartInstanceAksi.destroy();
                    }
    
                    const ctxKoneksi = canvasKoneksi.getContext('2d');
                    const ctxKolaborasi = canvasKolaborasi.getContext('2d');
                    const ctxAksi = canvasAksi.getContext('2d');
                    const radarData = @json($radarData);
    
                    // Get theme-aware colors
                    function getThemeColors() {
                        const isDark = localStorage.getItem('theme') === 'dark' || 
                                      (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                        
                        return {
                            isDark: isDark,
                            gridColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                            angleLinesColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                            textColor: isDark ? '#ffffff' : '#000000',
                            koneksi: {
                                bg: 'rgba(59, 130, 246, 0.1)',
                                border: 'rgba(59, 130, 246, 0.8)',
                                point: 'rgba(59, 130, 246, 1)'
                            },
                            kolaborasi: {
                                bg: 'rgba(75, 192, 192, 0.1)',
                                border: 'rgba(75, 192, 192, 0.8)',
                                point: 'rgba(75, 192, 192, 1)'
                            },
                            aksi: {
                                bg: 'rgba(255, 99, 132, 0.1)',
                                border: 'rgba(255, 99, 132, 0.8)',
                                point: 'rgba(255, 99, 132, 1)'
                            }
                        };
                    }
    
                    function customRound(value) {
                        if (value > 10) {
                            return Math.ceil(value / 10) * 10;
                        } else {
                            return Math.ceil(value);
                        }
                    }
    
                    const jumlahKoneksi = radarData.koneksi.jumlah_koneksi;
                    const kualitasKoneksi = radarData.koneksi.kualitas_koneksi;
                    const keluasanJejaring = radarData.koneksi.keluasan_jejaring;
                    const kualitasKolaborasi = radarData.kolaborasi.kualitas_kolaborasi;
                    const keragamanKolaborator = radarData.kolaborasi.keragaman_kolaborator;
                    const jumlahProyek = radarData.kolaborasi.jumlah_proyek;
                    const tingkatKolaborasi = radarData.kolaborasi.tingkat_kolaborasi;
                    const sumberDayaDisumbangkan = radarData.kolaborasi.sumber_daya_disumbangkan;
                    const jenisSumberDaya = radarData.kolaborasi.jenis_sumber_daya;
                    const aksiBesar = radarData.aksi.aksi_besar;
                    const themeColors = getThemeColors();
    
                    radarChartInstanceKoneksi = new Chart(ctxKoneksi, {
                        type: 'radar',
                        data: {
                            labels: [
                                'Jumlah Koneksi',
                                'Kualitas Koneksi (1-5)',
                                'Keluasan Jejaring (1-5)',
                            ],
                            datasets: [{
                                label: 'Rata-rata Skor',
                                data: [
                                    jumlahKoneksi,
                                    kualitasKoneksi,
                                    keluasanJejaring,
                                ],
                                backgroundColor: themeColors.koneksi.bg,
                                borderColor: themeColors.koneksi.border,
                                borderWidth: 2,
                                pointBackgroundColor: themeColors.koneksi.point,
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    beginAtZero: true,
                                    max: Math.max(5, customRound(Math.max(jumlahKoneksi, kualitasKoneksi, keluasanJejaring))),
                                    min: 0,
                                    ticks: {
                                        stepSize: Math.max(5, customRound(Math.max(jumlahKoneksi, kualitasKoneksi, keluasanJejaring))) > 10 ? 
                                            Math.max(5, customRound(Math.max(jumlahKoneksi, kualitasKoneksi, keluasanJejaring))) / 10 : 1,
                                        backdropColor: 'transparent'
                                    },
                                    grid: {
                                        color: themeColors.gridColor,
                                        circular: true
                                    },
                                    angleLines: {
                                        color: themeColors.angleLinesColor
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.0
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        color: themeColors.textColor,
                                    }
                                }
                            }
                        }
                    });
    
    
                    radarChartInstanceKolaborasi = new Chart(ctxKolaborasi, {
                        type: 'radar',
                        data: {
                            labels: [
                                'Kualitas Kolaborasi',
                                'Keragaman Kolaborator',
                                'Jumlah Proyek',
                                'Tingkat Kolaborasi',
                                'Sumber Daya yang Disumbangkan'
                            ],
                            datasets: [{
                                label: 'Rata-rata Skor',
                                data: [
                                    kualitasKolaborasi,
                                    keragamanKolaborator,
                                    jumlahProyek,
                                    tingkatKolaborasi,
                                    sumberDayaDisumbangkan,
                                ],
                                backgroundColor: themeColors.kolaborasi.bg,
                                borderColor: themeColors.kolaborasi.border,
                                borderWidth: 2,
                                pointBackgroundColor: themeColors.kolaborasi.point,
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    beginAtZero: true,
                                    max: customRound(Math.max(kualitasKolaborasi, keragamanKolaborator, jumlahProyek,
                                        tingkatKolaborasi,
                                        sumberDayaDisumbangkan)),
                                    min: 0,
                                    ticks: {
                                        stepSize: customRound(Math.max(kualitasKolaborasi, keragamanKolaborator,
                                            jumlahProyek, tingkatKolaborasi,
                                            sumberDayaDisumbangkan)) > 10 ? customRound(Math.max(kualitasKolaborasi,
                                            keragamanKolaborator, jumlahProyek, tingkatKolaborasi,
                                            sumberDayaDisumbangkan)) / customRound(Math.max(kualitasKolaborasi,
                                            keragamanKolaborator, jumlahProyek, tingkatKolaborasi,
                                            sumberDayaDisumbangkan)) * 10 : customRound(Math.max(kualitasKolaborasi,
                                            keragamanKolaborator, jumlahProyek, tingkatKolaborasi,
                                            sumberDayaDisumbangkan)) / customRound(Math.max(kualitasKolaborasi,
                                            keragamanKolaborator, jumlahProyek, tingkatKolaborasi,
                                            sumberDayaDisumbangkan)),
                                        backdropColor: 'transparent'
                                    },
                                    grid: {
                                        color: themeColors.gridColor,
                                        circular: true
                                    },
                                    angleLines: {
                                        color: themeColors.angleLinesColor
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.0
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        color: themeColors.textColor,
                                    }
                                },
                                tooltip: {                                    
                                    callbacks: {
                                        title: function(context) {
                                            return context[0].label;
                                        },
                                        label: function(context) {
                                            const label = context.dataset.label || '';
                                            const value = context.parsed.r;
                                            
                                            // Check if this is the "Sumber Daya yang Disumbangkan" point
                                            if (context.label === 'Sumber Daya yang Disumbangkan' && jenisSumberDaya && jenisSumberDaya.length > 0) {
                                                const resourceTypes = jenisSumberDaya.join(', ');
                                                return [
                                                    `${label}: ${value}`,
                                                    `Jenis Sumber Daya: ${resourceTypes}`
                                                ];
                                            }
                                            
                                            return `${label}: ${value}`;
                                        }
                                    },
                                    backgroundColor: themeColors.isDark ? 'rgba(0, 0, 0, 0.8)' : 'rgba(255, 255, 255, 0.9)',
                                    titleColor: themeColors.textColor,
                                    bodyColor: themeColors.textColor,
                                    borderColor: themeColors.isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.2)',
                                    borderWidth: 1,
                                    padding: 12,
                                    displayColors: false,
                                    multiLabelBackground: function(context) {
                                        return 'transparent';
                                    }
                                }
                            }
                        }
                    });
    
                    radarChartInstanceAksi = new Chart(ctxAksi, {
                        type: 'radar',
                        data: {
                            labels: [
                                'Aksi Besar',
                                'Aksi Sedang',
                                'Aksi Kecil'
                            ],
                            datasets: [{
                                label: 'Rata-rata Skor',
                                data: [
                                    Math.min(radarData.aksi.aksi_besar),
                                    Math.min(radarData.aksi.aksi_sedang),
                                    Math.min(radarData.aksi.aksi_kecil)
                                ],
                                backgroundColor: themeColors.aksi.bg,
                                borderColor: themeColors.aksi.border,
                                borderWidth: 2,
                                pointBackgroundColor: themeColors.aksi.point,
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    beginAtZero: true,
                                    max: customRound(Math.max(
                                        Math.min(radarData.aksi.aksi_besar),
                                        Math.min(radarData.aksi.aksi_sedang),
                                        Math.min(radarData.aksi.aksi_kecil))),
                                    min: 0,
                                    ticks: {
                                        stepSize: customRound(Math.max(
                                            Math.min(radarData.aksi.aksi_besar),
                                            Math.min(radarData.aksi.aksi_sedang),
                                            Math.min(radarData.aksi.aksi_kecil))) > 10 ? customRound(Math.max(
                                            Math.min(radarData.aksi.aksi_besar),
                                            Math.min(radarData.aksi.aksi_sedang),
                                            Math.min(radarData.aksi.aksi_kecil))) / customRound(Math.max(
                                            Math.min(radarData.aksi.aksi_besar),
                                            Math.min(radarData.aksi.aksi_sedang),
                                            Math.min(radarData.aksi.aksi_kecil))) * 10 : customRound(Math.max(
                                            Math.min(radarData.aksi.aksi_besar),
                                            Math.min(radarData.aksi.aksi_sedang),
                                            Math.min(radarData.aksi.aksi_kecil))) / customRound(Math.max(
                                            Math.min(radarData.aksi.aksi_besar),
                                            Math.min(radarData.aksi.aksi_sedang),
                                            Math.min(radarData.aksi.aksi_kecil))),
                                        backdropColor: 'transparent'
                                    },
                                    grid: {
                                        color: themeColors.gridColor,
                                        circular: true
                                    },
                                    angleLines: {
                                        color: themeColors.angleLinesColor
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.0
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        color: themeColors.textColor,
                                    }
                                }
                            }
                        }
                    });
                }
    
                // Function to update chart colors when theme changes
                function updateChartColors() {
                    if (radarChartInstanceKoneksi || radarChartInstanceKolaborasi || radarChartInstanceAksi) {
                        // Re-initialize charts with new theme colors
                        initializeRadarChart();
                    }
                }
    
                // Listen for theme changes
                function setupThemeListener() {
                    // Listen for storage changes (when theme is changed in another tab)
                    window.addEventListener('storage', function(e) {
                        if (e.key === 'theme') {
                            updateChartColors();
                        }
                    });
    
                    // Listen for custom theme change events
                    document.addEventListener('themeChanged', function() {
                        updateChartColors();
                    });
    
                    // Listen for system theme changes
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                        if (!localStorage.getItem('theme')) {
                            updateChartColors();
                        }
                    });
                }
    
                // Initialize chart when DOM is ready
                document.addEventListener('DOMContentLoaded', function() {
                    // Wait for Livewire to finish loading
                    setTimeout(initializeRadarChart, 100);
                    setupThemeListener();
                });
    
                // Re-initialize chart when Livewire updates
                document.addEventListener('livewire:navigated', function() {
                    setTimeout(initializeRadarChart, 100);
                    setupThemeListener();
                });
    
                // Listen for Livewire updates
                Livewire.on('tabChanged', function() {
                    setTimeout(initializeRadarChart, 100);
                });
    
                // Also try to initialize when the page is fully loaded
                window.addEventListener('load', function() {
                    setTimeout(initializeRadarChart, 200);
                    setupThemeListener();
                });
            </script>
        @endpush
    {{-- @endif --}}
    {{-- </x-admin.layout> --}}