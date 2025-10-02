<x-admin.layout title="Detail Aksi Kolektif - {{ $collectiveAction->title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Detail Aksi Kolektif</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">{{ $collectiveAction->title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.collective-actions') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors text-center">
                    Kembali ke Aksi Kolektif
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
                            <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Judul Aksi Kolektif</label>
                            <p class="text-primary-blue dark:text-secondary-green">{{ $collectiveAction->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Deskripsi</label>
                            <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->description }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Tujuan</label>
                            <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->goals }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Status</label>
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
                                        'planning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                        'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$collectiveAction->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($collectiveAction->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Skala</label>
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-full">
                                    {{ ucfirst($collectiveAction->scale) }}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Lingkup</label>
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 rounded-full">
                                    {{ ucfirst($collectiveAction->scope) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Minimal Ekosistem</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $collectiveAction->min_ecosystems }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Tanggal Mulai</label>
                                <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->start_date ? $collectiveAction->start_date->format('d M Y') : 'Tidak ditentukan' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Tanggal Selesai</label>
                                <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->end_date ? $collectiveAction->end_date->format('d M Y') : 'Tidak ditentukan' }}</p>
                            </div>
                        </div>
                        @if($collectiveAction->location)
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Lokasi</label>
                                <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->location }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-slate-400">Dibuat</label>
                            <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$collectiveAction->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-primary-blue dark:text-secondary-green">{{ $collectiveAction->creator->name }}</div>
                            <div class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->creator->email }}</div>
                            <div class="text-sm text-gray-500 dark:text-slate-400">Bergabung {{ $collectiveAction->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Required Resources -->
                @if($collectiveAction->required_resources && count($collectiveAction->required_resources) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Sumber Daya yang Dibutuhkan</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($collectiveAction->required_resources as $resource)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 rounded-full">
                                    {{ $resource }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Collaboration Terms -->
                @if($collectiveAction->collaboration_terms)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Syarat Kolaborasi</h3>
                        <p class="text-gray-600 dark:text-slate-300">{{ $collectiveAction->collaboration_terms }}</p>
                    </div>
                @endif

                <!-- Participating Ecosystems -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Ekosistem yang Berpartisipasi ({{ $collectiveAction->participatingEcosystems->count() }})</h3>
                    <div class="space-y-3">
                        @forelse($collectiveAction->participatingEcosystems as $ecosystem)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->ecosystem_title }}</div>
                                        <div class="text-xs text-gray-600 dark:text-slate-300">{{ $ecosystem->organization_name }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-secondary-green/10 text-secondary-green dark:bg-secondary-green/20 dark:text-secondary-green">
                                    Berpartisipasi
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-slate-300">Tidak ada ekosistem yang berpartisipasi.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Contributors -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Kontributor ({{ $collectiveAction->contributors->count() }})</h3>
                    <div class="space-y-3">
                        @forelse($collectiveAction->contributors as $contributor)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <x-ui.avatar :user="$contributor" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $contributor->name }}</div>
                                        <div class="text-xs text-gray-600 dark:text-slate-300">{{ $contributor->email }}</div>
                                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ ucfirst($contributor->pivot->contribution_type) }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $contributor->pivot->status === 'accepted' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                       ($contributor->pivot->status === 'offered' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                                    {{ ucfirst($contributor->pivot->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-slate-300">Tidak ada kontributor ditemukan.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quality Metrics & Analytics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-6">Analisis Kualitas & Kesehatan Aksi Kolektif</h3>
                    
                    <!-- Collective Action Health Score -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green">Skor Kesehatan Aksi Kolektif</h4>
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                @php
                                    $participatingEcosystems = $collectiveAction->participatingEcosystems->count();
                                    $acceptedContributors = $collectiveAction->contributors->where('pivot.status', 'accepted')->count();
                                    $offeredContributors = $collectiveAction->contributors->where('pivot.status', 'offered')->count();
                                    $totalContributors = $collectiveAction->contributors->count();
                                    $minEcosystems = $collectiveAction->min_ecosystems;
                                    
                                    $healthScore = min(100, max(0, round(
                                        ($participatingEcosystems >= $minEcosystems ? 30 : ($participatingEcosystems / max(1, $minEcosystems)) * 30) +
                                        ($totalContributors > 0 ? ($acceptedContributors / $totalContributors) * 25 : 0) +
                                        ($collectiveAction->status === 'active' ? 20 : ($collectiveAction->status === 'completed' ? 15 : 5)) +
                                        (count($collectiveAction->required_resources ?? []) * 5) +
                                        ($collectiveAction->collaboration_terms ? 10 : 0)
                                    )));
                                @endphp
                                {{ $healthScore }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full" 
                                 style="width: {{ $healthScore }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Berdasarkan partisipasi ekosistem, kontributor, status, dan kelengkapan informasi</p>
                    </div>

                    <!-- Contribution Status Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Status Kontribusi</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="contributionStatusChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Ecosystem Participation Chart -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Partisipasi Ekosistem</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="ecosystemParticipationChart" wire:ignore></canvas>
                        </div>
                    </div>

                    <!-- Quality Indicators -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-slate-400">Tingkat Partisipasi Ekosistem</h5>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Ekosistem vs minimal</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                        {{ $minEcosystems > 0 ? round(($participatingEcosystems / $minEcosystems) * 100) : 100 }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-slate-400">Tingkat Penerimaan Kontribusi</h5>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Kontributor diterima</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ $totalContributors > 0 ? round(($acceptedContributors / $totalContributors) * 100) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-slate-400">Kelengkapan Informasi</h5>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Sumber daya & syarat</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                        {{ round(((count($collectiveAction->required_resources ?? []) > 0 ? 50 : 0) + ($collectiveAction->collaboration_terms ? 50 : 0))) }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-slate-400">Tingkat Aktivitas</h5>
                                    <p class="text-xs text-gray-500 dark:text-slate-400">Status aksi kolektif</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                        @php
                                            $statusScores = [
                                                'draft' => 20,
                                                'planning' => 40,
                                                'active' => 80,
                                                'completed' => 100,
                                                'cancelled' => 0
                                            ];
                                        @endphp
                                        {{ $statusScores[$collectiveAction->status] ?? 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collective Action Timeline -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-primary-blue dark:text-secondary-green mb-4">Timeline & Progress</h4>
                        <div class="relative" style="height: 200px;">
                            <canvas id="collectiveActionTimelineChart" wire:ignore></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pilar III - Aksi Kolektif Quality Metrics -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Kualitas Aksi Kolektif</h3>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                            Pilar III
                        </span>
                    </div>

                    @php
                        $aksiQuality = $collectiveAction->calculateAksiScore();
                    @endphp

                    <!-- Overall Score -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                            <span class="text-xl font-bold text-white">{{ $aksiQuality['aksi_score'] }}%</span>
                        </div>
                        <h4 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Skor Aksi Kolektif</h4>
                        <p class="text-sm text-gray-600 dark:text-slate-300">Rata-rata dari 6 metrik kualitas</p>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Activity Score -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Tingkat Aktivitas</h5>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $aksiQuality['activity_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['activity_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                Status: {{ $aksiQuality['details']['action_status'] }}
                            </p>
                        </div>

                        <!-- Impact Score -->
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Dampak Skala & Cakupan</h5>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $aksiQuality['impact_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-purple-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['impact_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ ucfirst($collectiveAction->scale) }} × {{ ucfirst($collectiveAction->scope) }}
                            </p>
                        </div>

                        <!-- Participation Score -->
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-4 border border-orange-200 dark:border-orange-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Tingkat Partisipasi</h5>
                                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $aksiQuality['participation_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['participation_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $aksiQuality['details']['active_participants'] }} dari {{ $aksiQuality['details']['total_registered'] }} user
                            </p>
                        </div>

                        <!-- Engagement Score -->
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Keterlibatan Ekosistem</h5>
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $aksiQuality['engagement_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['engagement_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $aksiQuality['details']['accepted_ecosystems'] }} dari {{ $aksiQuality['details']['invited_ecosystems'] }} ekosistem
                            </p>
                        </div>

                        <!-- Completion Score -->
                        <div class="bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 rounded-lg p-4 border border-pink-200 dark:border-pink-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Penyelesaian Kontribusi</h5>
                                <span class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ $aksiQuality['completion_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-pink-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['completion_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $aksiQuality['details']['completed_contributions'] }} dari {{ $aksiQuality['details']['total_contributions'] }} kontribusi
                            </p>
                        </div>

                        <!-- Diversity Score -->
                        <div class="bg-gradient-to-r from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-lg p-4 border border-teal-200 dark:border-teal-800">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-primary-blue dark:text-secondary-green text-sm">Keragaman Kontribusi</h5>
                                <span class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $aksiQuality['diversity_score'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2 mb-2">
                                <div class="bg-teal-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $aksiQuality['diversity_score'] }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-slate-300">
                                {{ $aksiQuality['details']['contribution_types_count'] }} jenis (HHI: {{ $aksiQuality['details']['hhi_value'] }})
                            </p>
                        </div>
                    </div>

                    <!-- Performance Insights -->
                    <div class="mt-6 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <h4 class="font-medium text-primary-blue dark:text-secondary-green mb-3">Insight Performa</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-slate-300">Metrik Terbaik:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">
                                    @php
                                        $bestMetric = '';
                                        $bestScore = 0;
                                        $metrics = [
                                            'activity_score' => 'Aktivitas',
                                            'impact_score' => 'Dampak',
                                            'participation_score' => 'Partisipasi',
                                            'engagement_score' => 'Keterlibatan',
                                            'completion_score' => 'Penyelesaian',
                                            'diversity_score' => 'Keragaman'
                                        ];
                                        foreach($metrics as $key => $label) {
                                            if($aksiQuality[$key] > $bestScore) {
                                                $bestScore = $aksiQuality[$key];
                                                $bestMetric = $label;
                                            }
                                        }
                                    @endphp
                                    {{ $bestMetric }} ({{ $bestScore }}%)
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-slate-300">Perlu Perbaikan:</span>
                                <span class="font-medium text-orange-600 dark:text-orange-400">
                                    @php
                                        $worstMetric = '';
                                        $worstScore = 100;
                                        foreach($metrics as $key => $label) {
                                            if($aksiQuality[$key] < $worstScore) {
                                                $worstScore = $aksiQuality[$key];
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
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Statistik Cepat</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $collectiveAction->participatingEcosystems->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Ekosistem Berpartisipasi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $collectiveAction->contributors->where('pivot.status', 'accepted')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Kontributor Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $collectiveAction->contributors->where('pivot.status', 'offered')->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Menunggu Persetujuan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $collectiveAction->min_ecosystems }}</div>
                            <div class="text-sm text-gray-600 dark:text-slate-300">Minimal Ekosistem</div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.collective-actions.delete', $collectiveAction) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this collective action? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Hapus Aksi Kolektif
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
                $participatingEcosystems = $collectiveAction->participatingEcosystems->count();
                $acceptedContributors = $collectiveAction->contributors->where('pivot.status', 'accepted')->count();
                $offeredContributors = $collectiveAction->contributors->where('pivot.status', 'offered')->count();
                $declinedContributors = $collectiveAction->contributors->where('pivot.status', 'declined')->count();
                $totalContributors = $collectiveAction->contributors->count();
                $minEcosystems = $collectiveAction->min_ecosystems;
            @endphp

            // Contribution Status Chart
            const contributionStatusCtx = document.getElementById('contributionStatusChart');
            if (contributionStatusCtx) {
                new Chart(contributionStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Diterima', 'Ditawarkan', 'Ditolak'],
                        datasets: [{
                            data: [{{ $acceptedContributors }}, {{ $offeredContributors }}, {{ $declinedContributors }}],
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

            // Ecosystem Participation Chart
            const ecosystemParticipationCtx = document.getElementById('ecosystemParticipationChart');
            if (ecosystemParticipationCtx) {
                new Chart(ecosystemParticipationCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Ekosistem Berpartisipasi', 'Minimal Diperlukan'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [{{ $participatingEcosystems }}, {{ $minEcosystems }}],
                            backgroundColor: [
                                '#8B5CF6', // Purple
                                '#E5E7EB'  // Gray
                            ],
                            borderColor: [
                                '#7C3AED',
                                '#D1D5DB'
                            ],
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

            // Collective Action Timeline Chart
            const collectiveActionTimelineCtx = document.getElementById('collectiveActionTimelineChart');
            if (collectiveActionTimelineCtx) {
                // Generate timeline data based on collective action dates
                const months = [];
                const ecosystemData = [];
                const contributorData = [];
                
                // Get creation date and calculate months
                const createdDate = new Date('{{ $collectiveAction->created_at }}');
                const currentDate = new Date();
                const monthsDiff = Math.max(1, Math.ceil((currentDate - createdDate) / (1000 * 60 * 60 * 24 * 30)));
                
                for (let i = Math.max(0, monthsDiff - 6); i < monthsDiff; i++) {
                    const date = new Date(createdDate);
                    date.setMonth(date.getMonth() + i);
                    months.push(date.toLocaleDateString('id-ID', { month: 'short' }));
                    
                    // Simulate growth data (in real implementation, you'd query actual historical data)
                    const progressFactor = Math.min(1, i / Math.max(1, monthsDiff - 1));
                    ecosystemData.push(Math.round({{ $participatingEcosystems }} * progressFactor));
                    contributorData.push(Math.round({{ $totalContributors }} * progressFactor));
                }

                new Chart(collectiveActionTimelineCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Ekosistem',
                            data: ecosystemData,
                            borderColor: '#8B5CF6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Kontributor',
                            data: contributorData,
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
