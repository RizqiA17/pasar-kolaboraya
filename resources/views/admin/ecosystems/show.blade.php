<x-admin.layout title="Detail Ekosistem - {{ $ecosystem->ecosystem_title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Detail Ekosistem</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">{{ $ecosystem->ecosystem_title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.ecosystems') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                    Kembali ke Ekosistem
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Informasi Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Judul Ekosistem</label>
                            <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->ecosystem_title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Nama Organisasi</label>
                            <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->organization_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Deskripsi</label>
                            <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->description }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Wilayah Kerja</label>
                            <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->work_region }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Status</label>
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                    ];
                                    $status = $ecosystem->is_active ? 'active' : 'inactive';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                    {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Maksimal Anggota</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->max_users ?: 'Tidak terbatas' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Auto Join Aksi Kolektif</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->auto_join_collective_actions ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Dibuat</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $ecosystem->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$ecosystem->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->creator->name }}</div>
                            <div class="text-gray-600 dark:text-slate-300">{{ $ecosystem->creator->email }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Bergabung {{ $ecosystem->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Issues Addressed -->
                @if($ecosystem->issues_addressed && count($ecosystem->issues_addressed) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Isu yang Ditangani</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->issues_addressed as $issue)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                    {{ $issue }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Existing Roles -->
                @if($ecosystem->existing_roles && count($ecosystem->existing_roles) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Peran yang Sudah Ada</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->existing_roles as $role)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Needed Roles -->
                @if($ecosystem->needed_roles && count($ecosystem->needed_roles) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Peran yang Dibutuhkan</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->needed_roles as $role)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 rounded-full">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Anggota -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Anggota ({{ $ecosystem->users->count() }})</h3>
                    <div class="space-y-3">
                        @forelse($ecosystem->users as $user)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <x-ui.avatar :user="$user" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-600 dark:text-slate-300">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->pivot->status === 'accepted' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                       ($user->pivot->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                    {{ ucfirst($user->pivot->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-slate-300">Tidak ada anggota ditemukan.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quality Metrics & Analytics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-6">Analisis Kualitas & Kesehatan Ekosistem</h3>
                    
                    <!-- Ecosystem Health Score -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green">Skor Kesehatan Ekosistem</h4>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">
                                @php
                                    $totalMembers = $ecosystem->users->count();
                                    $activeMembers = $ecosystem->users->where('pivot.status', 'accepted')->count();
                                    $collectiveActions = $ecosystem->collectiveActions()->count();
                                    $healthScore = min(100, max(0, round(
                                        ($activeMembers > 0 ? ($activeMembers / max(1, $totalMembers)) * 40 : 0) +
                                        ($collectiveActions * 15) +
                                        ($ecosystem->is_active ? 20 : 0) +
                                        (count($ecosystem->issues_addressed ?? []) * 5) +
                                        (count($ecosystem->existing_roles ?? []) * 5)
                                    )));
                                @endphp
                                {{ $healthScore }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full" 
                                 style="width: {{ $healthScore }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300 mt-1">Berdasarkan anggota aktif, aksi kolektif, dan struktur organisasi</p>
                    </div>

                    <!-- Member Activity Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Distribusi Status Anggota</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="ecosystemMemberChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Collective Actions Participation Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Partisipasi Aksi Kolektif</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="ecosystemCollectiveActionsChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Quality Indicators -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Tingkat Aktivasi</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Anggota aktif vs total</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                        {{ $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Diversitas Isu</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Jumlah isu yang ditangani</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ count($ecosystem->issues_addressed ?? []) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Kapasitas Organisasi</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Peran yang tersedia</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                        {{ count($ecosystem->existing_roles ?? []) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Tingkat Partisipasi Aksi Kolektif</h5>
                                    <p class="text-xs text-gray-600 dark:text-slate-300">Aksi kolektif per bulan</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                        {{ $ecosystem->created_at->diffInMonths(now()) > 0 ? round($collectiveActions / max(1, $ecosystem->created_at->diffInMonths(now()))) : $collectiveActions }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ecosystem Growth Trend -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Tren Pertumbuhan Ekosistem</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="ecosystemGrowthChart" wire:ignore></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pilar II - Ekosistem Quality Metrics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Kualitas Ekosistem</h3>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/20 text-purple-800 dark:text-purple-200 rounded-full text-sm font-medium">
                            Pilar II
                        </span>
                    </div>

                    @php
                        $ekosistemQuality = $ecosystem->calculateEkosistemScore();
                    @endphp

                    <!-- Overall Score -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-500 to-blue-600 rounded-full mb-4">
                            <span class="text-xl font-bold text-white">{{ $ekosistemQuality['ekosistem_score'] }}%</span>
                        </div>
                        <h4 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Skor Kualitas Ekosistem</h4>
                        <p class="text-sm text-gray-600 dark:text-slate-300">Rata-rata dari 6 metrik kualitas</p>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Membership Activation Rate -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Tingkat Aktivasi Keanggotaan</h5>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $ekosistemQuality['activation_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['activation_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['accepted_members'] }} dari {{ $ekosistemQuality['details']['max_users'] }} anggota
                            </p>
                        </div>

                        <!-- Ecosystem Acceptance Rate -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Tingkat Penerimaan Ekosistem</h5>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $ekosistemQuality['acceptance_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['acceptance_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['accepted_members'] }} dari {{ $ekosistemQuality['details']['total_decisions'] }} keputusan
                            </p>
                        </div>

                        <!-- Ecosystem Contribution Completion Rate -->
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Penyelesaian Kontribusi</h5>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $ekosistemQuality['completion_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-purple-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['completion_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['completed_contributions'] }} dari {{ $ekosistemQuality['details']['total_contributions'] }} kontribusi
                            </p>
                        </div>

                        <!-- Ecosystem Contribution Diversity -->
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-4 border border-orange-200 dark:border-orange-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Keragaman Kontribusi</h5>
                                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $ekosistemQuality['diversity_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['diversity_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['contribution_types_count'] }} jenis (HHI: {{ $ekosistemQuality['details']['hhi_value'] }})
                            </p>
                        </div>

                        <!-- Role Fit -->
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Kesesuaian Kebutuhan Skill</h5>
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $ekosistemQuality['role_fit_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['role_fit_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['role_coverage_count'] }} dari {{ $ekosistemQuality['details']['needed_roles_count'] }} peran
                            </p>
                        </div>

                        <!-- Ecosystem Engagement in Collective Actions -->
                        <div class="bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg p-4 border border-pink-200 dark:border-pink-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Keterlibatan Aksi Kolektif</h5>
                                <span class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ $ekosistemQuality['engagement_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-pink-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $ekosistemQuality['engagement_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $ekosistemQuality['details']['accepted_invitations'] }} dari {{ $ekosistemQuality['details']['invited_to_actions'] }} undangan
                            </p>
                        </div>
                    </div>

                    <!-- Performance Insights -->
                    <div class="mt-6 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <h4 class="font-medium text-primary-blue dark:text-secondary-green mb-3">Insight Performa</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-slate-300">Kekuatan Utama:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">
                                    @php
                                        $bestMetric = '';
                                        $bestScore = 0;
                                        $metrics = [
                                            'activation_score' => 'Aktivasi Keanggotaan',
                                            'acceptance_score' => 'Penerimaan Ekosistem',
                                            'completion_score' => 'Penyelesaian Kontribusi',
                                            'diversity_score' => 'Keragaman Kontribusi',
                                            'role_fit_score' => 'Kesesuaian Skill',
                                            'engagement_score' => 'Keterlibatan Aksi'
                                        ];
                                        foreach($metrics as $key => $label) {
                                            if($ekosistemQuality[$key] > $bestScore) {
                                                $bestScore = $ekosistemQuality[$key];
                                                $bestMetric = $label;
                                            }
                                        }
                                    @endphp
                                    {{ $bestMetric }} ({{ $bestScore }}%)
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-slate-300">Area Perbaikan:</span>
                                <span class="font-medium text-orange-600 dark:text-orange-400">
                                    @php
                                        $worstMetric = '';
                                        $worstScore = 100;
                                        foreach($metrics as $key => $label) {
                                            if($ekosistemQuality[$key] < $worstScore) {
                                                $worstScore = $ekosistemQuality[$key];
                                                $worstMetric = $label;
                                            }
                                        }
                                    @endphp
                                    {{ $worstMetric }} ({{ $worstScore }}%)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistik Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Statistik Cepat</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $ecosystem->users->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Anggota</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $ecosystem->users->where('pivot.status', 'accepted')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Anggota Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $ecosystem->users->where('pivot.status', 'pending')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Persetujuan</div>
                        </div>
                        @if($ecosystem->max_users)
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $ecosystem->max_users }}</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Maksimal Anggota</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.ecosystems.delete', $ecosystem) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this ecosystem? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Hapus Ekosistem
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
                $totalMembers = $ecosystem->users->count();
                $activeMembers = $ecosystem->users->where('pivot.status', 'accepted')->count();
                $pendingMembers = $ecosystem->users->where('pivot.status', 'pending')->count();
                $rejectedMembers = $ecosystem->users->where('pivot.status', 'rejected')->count();
                $collectiveActions = $ecosystem->collectiveActions()->count();
            @endphp

            // Ecosystem Member Status Chart
            const ecosystemMemberCtx = document.getElementById('ecosystemMemberChart');
            if (ecosystemMemberCtx) {
                new Chart(ecosystemMemberCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Menunggu', 'Ditolak'],
                        datasets: [{
                            data: [{{ $activeMembers }}, {{ $pendingMembers }}, {{ $rejectedMembers }}],
                            backgroundColor: [
                                '#10B981', // Green
                                '#F59E0B', // Yellow
                                '#EF4444'  // Red
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

            // Collective Actions Participation Chart
            const ecosystemCollectiveActionsCtx = document.getElementById('ecosystemCollectiveActionsChart');
            if (ecosystemCollectiveActionsCtx) {
                new Chart(ecosystemCollectiveActionsCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Aksi Kolektif'],
                        datasets: [{
                            label: 'Jumlah Partisipasi',
                            data: [{{ $collectiveActions }}],
                            backgroundColor: '#8B5CF6',
                            borderColor: '#7C3AED',
                            borderWidth: 1
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
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Ecosystem Growth Trend Chart
            const ecosystemGrowthCtx = document.getElementById('ecosystemGrowthChart');
            if (ecosystemGrowthCtx) {
                // Generate monthly data for the last 6 months
                const months = [];
                const memberData = [];
                const actionData = [];
                
                for (let i = 5; i >= 0; i--) {
                    const date = new Date();
                    date.setMonth(date.getMonth() - i);
                    months.push(date.toLocaleDateString('id-ID', { month: 'short' }));
                    
                    // Simulate growth data (in real implementation, you'd query actual data)
                    memberData.push(Math.max(0, {{ $totalMembers }} - (5 - i) * 2));
                    actionData.push(Math.max(0, {{ $collectiveActions }} - (5 - i)));
                }

                new Chart(ecosystemGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Anggota',
                            data: memberData,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Aksi Kolektif',
                            data: actionData,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
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
        });
    </script>
    @endpush
</x-admin.layout>
