<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Dashboard Admin"
        description="Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah aktivitas terbaru di sistem Anda." />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4 sm:gap-4 lg:gap-6">
        <!-- Users Stat -->
        <x-admin.dashboard.stat-card title="Total Peserta" :stats="number_format($stats['users'])" :link="route('admin.users')" icon="users"
            iconColor="text-pink-600 dark:text-pink-400" iconBg="bg-pink-100 dark:bg-pink-900/20" />

        <!-- Connections Stat -->
        <x-admin.dashboard.stat-card title="Koneksi" :stats="number_format($stats['connections'])" :link="route('admin.connections')" icon="link"
            iconColor="text-primary-blue dark:text-blue-400" iconBg="bg-blue-100 dark:bg-blue-900/20" />

        <!-- Ecosystems Stat -->
        <x-admin.dashboard.stat-card title="Ekosistem" :stats="number_format($stats['ecosystems'])" :link="route('admin.ecosystems')" icon="user-group"
            iconColor="text-purple-600 dark:text-purple-400" iconBg="bg-purple-100 dark:bg-purple-900/20" />

        <!-- Collective Actions Stat -->
        <x-admin.dashboard.stat-card title="Aksi Kolektif" :stats="number_format($stats['collective_actions'])" :link="route('admin.collective-actions')" icon="calendar"
            iconColor="text-secondary-green dark:text-emerald-400" iconBg="bg-emerald-100 dark:bg-emerald-900/20" />

    </div>

    <!-- Quick Links -->
    {{-- <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- Market Statistics Card -->
        <div class="p-6 text-white transition-shadow shadow-lg cursor-pointer bg-gradient-to-br from-primary-blue to-sky-600 rounded-2xl hover:shadow-xl"
            onclick="window.location.href='{{ route('admin.market.statistics') }}'">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold">Statistik Pasar</h3>
                <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <p class="mb-4 text-sm text-sky-100">Lihat rekap lengkap data koneksi, ekosistem, aksi kolektif, dan
                kontribusi dari pasar yang dibuka</p>
            <div class="flex items-center text-sm font-semibold">
                <span>Buka Dashboard Statistik</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    </div> --}}

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 2xl:grid-cols-3 sm:gap-4 lg:gap-6">
        <!-- Recent Users -->
        <x-admin.dashboard.recent title="Peserta Terbaru" :link="route('admin.users')"
            titleColor="text-primary-blue dark:text-blue-400"
            linkHoverColor="hover:text-primary-blue/80 dark:hover:text-blue-400/80">
            @forelse($recentUsers as $user)
                <div class="flex items-center space-x-3">
                    <x-ui.avatar :user="$user" size="sm" />
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-slate-200">
                            {{ $user->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-slate-300">{{ $user->email }}</p>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-slate-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-600 dark:text-slate-300">Tidak ada Peserta ditemukan.</p>
            @endforelse
        </x-admin.dashboard.recent>

        <!-- Recent Ecosystems -->
        <x-admin.dashboard.recent title="Ekosistem Terbaru" :link="route('admin.ecosystems')"
            titleColor="text-purple-600 dark:text-purple-400"
            linkHoverColor="hover:text-purple-600/80 dark:hover:text-purple-400/80">
            @forelse($recentEcosystems as $ecosystem)
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg dark:bg-purple-900/20">
                        <flux:icon name="user-group" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-slate-200">
                            {{ $ecosystem->ecosystem_title }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            by {{ $ecosystem->creator->name }}
                        </p>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-slate-400">
                        {{ $ecosystem->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-600 dark:text-slate-300">
                    Tidak ada ekosistem ditemukan.
                </p>
            @endforelse
        </x-admin.dashboard.recent>


        <!-- Recent Collective Actions -->
        <x-admin.dashboard.recent title="Aksi Kolektif Terbaru" :link="route('admin.collective-actions')"
            titleColor="text-secondary-green dark:text-emerald-400"
            linkHoverColor="hover:text-secondary-green/80 dark:hover:text-emerald-400/80">
            @forelse($recentCollectiveActions as $collectiveAction)
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center w-8 h-8 bg-emerald-100 rounded-lg dark:bg-emerald-900/20">
                        <flux:icon name="calendar" class="w-4 h-4 text-secondary-green dark:text-emerald-400" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-slate-200">
                            {{ $collectiveAction->title }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            by {{ $collectiveAction->creator->name }}
                        </p>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-slate-400">
                        {{ $collectiveAction->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-600 dark:text-slate-300">
                    Tidak ada aksi kolektif ditemukan.
                </p>
            @endforelse
        </x-admin.dashboard.recent>


        <!-- Collective Action Quality Metrics -->
        {{-- <div
            class="p-4 border shadow-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl sm:p-6 border-white/20 dark:border-slate-700/50">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <h3 class="text-base font-semibold sm:text-lg text-primary-blue dark:text-secondary-green">Kualitas
                    Aksi Kolektif</h3>
                <span
                    class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/20 dark:text-blue-200">
                    Pilar III
                </span>
            </div>

            @php
                $activeSessions = \App\Models\PasarKolaboraya::where('status', 'active')
                    ->with(['collectiveActions'])
                    ->get();
                $totalCollectiveActions = $activeSessions->sum(function ($session) {
                    return $session->collectiveActions->count();
                });
                $avgCollectiveActionQuality = $activeSessions->avg(function ($session) {
                    return $session->calculateCollectiveActionQuality();
                });
            @endphp

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 sm:text-sm dark:text-slate-400">Rata-rata Kualitas</p>
                    <p class="text-lg font-bold sm:text-xl text-primary-blue dark:text-secondary-green">
                        {{ $avgCollectiveActionQuality ? round($avgCollectiveActionQuality, 1) : 0 }}%
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 sm:text-sm dark:text-slate-400">Total Aksi Kolektif</p>
                    <p class="text-lg font-bold sm:text-xl text-primary-blue dark:text-secondary-green">
                        {{ $totalCollectiveActions }}
                    </p>
                </div>
            </div>

            @if ($totalCollectiveActions > 0)
                <div class="p-3 mt-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                    <h4 class="mb-2 text-sm font-medium text-primary-blue dark:text-secondary-green">Distribusi
                        Kualitas</h4>
                    <div class="space-y-2">
                        @php
                            $qualityRanges = [
                                'excellent' => [
                                    'min' => 80,
                                    'max' => 100,
                                    'label' => 'Sangat Baik',
                                    'color' => 'green',
                                ],
                                'good' => ['min' => 60, 'max' => 79, 'label' => 'Baik', 'color' => 'blue'],
                                'fair' => ['min' => 40, 'max' => 59, 'label' => 'Cukup', 'color' => 'yellow'],
                                'poor' => ['min' => 0, 'max' => 39, 'label' => 'Perlu Perbaikan', 'color' => 'red'],
                            ];

                            $qualityDistribution = [];
                            foreach ($activeSessions as $session) {
                                foreach ($session->collectiveActions as $action) {
                                    $score = $action->calculateAksiScore()['aksi_score'];
                                    foreach ($qualityRanges as $key => $range) {
                                        if ($score >= $range['min'] && $score <= $range['max']) {
                                            $qualityDistribution[$key] = ($qualityDistribution[$key] ?? 0) + 1;
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        @foreach ($qualityRanges as $key => $range)
                            @if (isset($qualityDistribution[$key]) && $qualityDistribution[$key] > 0)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-600 dark:text-slate-300">{{ $range['label'] }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-16 h-2 rounded-full bg-slate-200 dark:bg-slate-600">
                                            <div class="bg-{{ $range['color'] }}-500 h-2 rounded-full"
                                                style="width: {{ ($qualityDistribution[$key] / $totalCollectiveActions) * 100 }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="font-medium text-primary-blue dark:text-secondary-green">{{ $qualityDistribution[$key] }}</span>
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
        </div> --}}
    </div>
</div>
