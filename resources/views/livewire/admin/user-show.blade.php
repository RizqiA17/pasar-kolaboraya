<div class="space-y-6">
    <!-- Page Header -->
    <x-admin.header title="Detail Pengguna" :description="$user->name">
        <div class="flex items-center space-x-3">
            
            <flux:button href="{{ route('admin.users.edit', $user) }}"
                class="w-full px-4 py-2 text-center text-white transition-colors rounded-lg sm:w-auto bg-primary-blue dark:bg-secondary-green hover:bg-sky-800 dark:hover:bg-teal-600" variant="primary">
                Edit Pengguna
            </flux:button>
            <flux:button href="{{ route('admin.users') }}"
                class="w-full px-4 py-2 text-center text-white transition-colors bg-gray-600 rounded-lg sm:w-auto hover:bg-gray-700">
                Kembali
            </flux:button>
        </div>
    </x-admin.header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- User Information -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Basic Information -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Nama</label>
                        <p class="text-primary-blue dark:text-secondary-green">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Email</label>
                        <p class="text-primary-blue dark:text-secondary-green">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Role</label>
                        @php
                            $roleColors = [
                                'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'super_admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                        @endphp
                        <span
                            class=" px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Peran Peserta</label>
                        @php
                            $roleInfo = $user->getRoleDisplayInfo();
                            $colorClasses = [
                                'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                                'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                            ];
                        @endphp
                        <div class="flex items-center mt-2 space-x-2">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colorClasses[$roleInfo['color']] }}">
                                {{ $roleInfo['label'] }}
                            </span>
                            @if ($roleInfo['approved_at'])
                                <span class="text-xs text-gray-600 dark:text-slate-300">
                                    Disetujui: {{ $roleInfo['approved_at']->format('M d, Y H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Email
                            Terverifikasi</label>
                        <p class="text-primary-blue dark:text-secondary-green">
                            @if ($user->email_verified_at)
                                <span class="text-green-600 dark:text-green-400">Ya</span>
                                ({{ $user->email_verified_at->format('M d, Y H:i') }})
                            @else
                                <span class="text-red-600 dark:text-red-400">Tidak</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Bergabung</label>
                        <p class="text-primary-blue dark:text-secondary-green">
                            {{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Terakhir
                            Diperbarui</label>
                        <p class="text-primary-blue dark:text-secondary-green">
                            {{ $user->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Profil -->
            @if ($user->profile)
                <div
                    class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                    <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Informasi
                        Profil</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @if ($user->organization_name)
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Organisasi</label>
                                <p class="text-primary-blue dark:text-secondary-green">
                                    {{ $user->organization_name }}</p>
                            </div>
                        @endif
                        @if ($user->phone_number)
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Telepon</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $user->phone_number }}
                                </p>
                            </div>
                        @endif
                        @if ($user->profile->vision)
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-slate-300">Visi</label>
                                <p class="text-primary-blue dark:text-secondary-green">{{ $user->profile->vision }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Koneksi -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Koneksi</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-blue dark:text-blue-400">
                            {{ $user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-slate-300">Accepted Koneksi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $user->sentConnections ? $user->sentConnections->where('status', 'pending')->count() : 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-slate-300">Menunggu Dikirim</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $user->receivedConnections ? $user->receivedConnections->where('status', 'pending')->count() : 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-slate-300">Menunggu Diterima</div>
                    </div>
                </div>
            </div>

            <!-- Ekosistem -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Ekosistem</h3>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                        {{ $user->ecosystems ? $user->ecosystems->count() : 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-slate-300">Ekosistem Aktif</div>
                </div>
            </div>

            <!-- Aksi Kolektif -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Aksi Kolektif
                </h3>
                <div class="text-center">
                    <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">
                        {{ $user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-slate-300">Aksi Kolektif Aktif</div>
                </div>
            </div>

            <!-- Quality Metrics & Analytics -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-6 text-lg font-semibold text-primary-blue dark:text-secondary-green">Analisis Kualitas
                    & Kesehatan Partisipasi</h3>

                <!-- Engagement Score -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-md text-primary-blue dark:text-secondary-green">Skor
                            Keterlibatan</h4>
                        <span class="text-2xl font-bold text-primary-blue dark:text-blue-400">
                            {{ min(100, max(0, round((($user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0) * 10 + ($user->ecosystems ? $user->ecosystems->count() : 0) * 15 + ($user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0) * 20) / 2))) }}
                        </span>
                    </div>
                    <div class="w-full h-3 bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-primary-blue"
                            style="width: {{ min(100, max(0, round((($user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0) * 10 + ($user->ecosystems ? $user->ecosystems->count() : 0) * 15 + ($user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0) * 20) / 2))) }}%">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-600 dark:text-slate-300">Berdasarkan koneksi, ekosistem, dan
                        aksi kolektif</p>
                </div>

                <!-- Activity Distribution Chart -->
                <div class="mb-6">
                    <h4 class="mb-4 font-medium text-md text-primary-blue dark:text-secondary-green">Distribusi
                        Aktivitas</h4>
                    <div class="relative" style="height: 200px;">
                        <canvas id="userActivityChart" wire:ignore></canvas>
                    </div>
                </div>

                <!-- Quality Indicators -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Tingkat
                                    Konektivitas</h5>
                                <p class="text-xs text-gray-600 dark:text-slate-300">Rasio koneksi aktif</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                    {{ ($user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0) > 0 ? round((($user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0) / max(1, $user->sentConnections ? $user->sentConnections->count() : 0)) * 100) : 0 }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Tingkat
                                    Partisipasi Ekosistem</h5>
                                <p class="text-xs text-gray-600 dark:text-slate-300">Ekosistem per bulan</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                    {{ ($user->ecosystems ? $user->ecosystems->count() : 0) > 0 ? round(($user->ecosystems ? $user->ecosystems->count() : 0) / max(1, $user->created_at->diffInMonths(now()))) : 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Kontribusi Aksi
                                    Kolektif</h5>
                                <p class="text-xs text-gray-600 dark:text-slate-300">Aksi yang diikuti</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                    {{ $user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="text-sm font-medium text-gray-600 dark:text-slate-300">Tingkat
                                    Partisipasi</h5>
                                <p class="text-xs text-gray-600 dark:text-slate-300">Aktivitas per minggu</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $user->created_at->diffInWeeks(now()) > 0 ? round((($user->ecosystems ? $user->ecosystems->count() : 0) + ($user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0)) / max(1, $user->created_at->diffInWeeks(now()))) : 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pilar I - Peserta Quality Metrics -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Kualitas Peserta
                    </h3>
                    <span
                        class="px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/20 dark:text-green-200">
                        Pilar I
                    </span>
                </div>

                @php
                    // Calculate participant quality metrics
                    $profileCompleteness = 0;
                    if ($user->profile) {
                        $profileFields = ['bio', 'address', 'skills', 'interests', 'experience'];
                        $completedFields = 0;
                        foreach ($profileFields as $field) {
                            if (!empty($user->profile->$field)) {
                                $completedFields++;
                            }
                        }
                        $profileCompleteness = round(($completedFields / count($profileFields)) * 100);
                    }

                    $connectionQuality = 0;
                    $totalConnections = $user->sentConnections ? $user->sentConnections->count() : 0;
                    $acceptedConnections = $user->sentConnections
                        ? $user->sentConnections->where('status', 'accepted')->count()
                        : 0;
                    if ($totalConnections > 0) {
                        $connectionQuality = round(($acceptedConnections / $totalConnections) * 100);
                    }

                    $ecosystemParticipation = 0;
                    $totalEcosystems = $user->ecosystems ? $user->ecosystems->count() : 0;
                    $activeEcosystems = $user->ecosystems ? $user->ecosystems->where('is_active', true)->count() : 0;
                    if ($totalEcosystems > 0) {
                        $ecosystemParticipation = round(($activeEcosystems / $totalEcosystems) * 100);
                    }

                    $collectiveActionEngagement = 0;
                    $totalActions = $user->collectiveActions ? $user->collectiveActions->count() : 0;
                    $activeActions = $user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0;
                    if ($totalActions > 0) {
                        $collectiveActionEngagement = round(($activeActions / $totalActions) * 100);
                    }

                    $skillDiversity = 0;
                    if ($user->profile && $user->profile->skills) {
                        $skills = is_array($user->profile->skills)
                            ? $user->profile->skills
                            : json_decode($user->profile->skills, true);
                        $skillDiversity = min(100, count($skills) * 20); // Max 5 skills = 100%
                    }

                    $activityConsistency = 0;
                    $weeksSinceJoin = $user->created_at->diffInWeeks(now());
                    if ($weeksSinceJoin > 0) {
                        $totalActivities = $totalEcosystems + $totalActions;
                        $activityConsistency = min(100, round(($totalActivities / $weeksSinceJoin) * 10));
                    }

                    // Calculate overall participant quality score
                    $participantQuality = round(
                        $profileCompleteness * 0.25 +
                            $connectionQuality * 0.2 +
                            $ecosystemParticipation * 0.2 +
                            $collectiveActionEngagement * 0.15 +
                            $skillDiversity * 0.1 +
                            $activityConsistency * 0.1,
                    );
                @endphp

                <!-- Overall Score -->
                <div class="mb-8 text-center">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-gradient-to-r from-green-500 to-primary-blue">
                        <span class="text-xl font-bold text-white">{{ $participantQuality }}%</span>
                    </div>
                    <h4 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">Skor Kualitas
                        Peserta</h4>
                    <p class="text-sm text-gray-600 dark:text-slate-300">Rata-rata dari 6 metrik kualitas</p>
                </div>

                <!-- Metrics Grid -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Profile Completeness -->
                    <div
                        class="p-4 border border-blue-200 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 dark:border-blue-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Kelengkapan
                                Profil</h5>
                            <span
                                class="text-lg font-bold text-primary-blue dark:text-blue-400">{{ $profileCompleteness }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-blue-500 rounded-full"
                                style="width: {{ $profileCompleteness }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            @if ($user->profile)
                                {{ $profileCompleteness }}% profil lengkap
                            @else
                                Profil belum dibuat
                            @endif
                        </p>
                    </div>

                    <!-- Connection Quality -->
                    <div
                        class="p-4 border border-purple-200 rounded-lg bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 dark:border-purple-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Kualitas
                                Koneksi</h5>
                            <span
                                class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $connectionQuality }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-purple-500 rounded-full"
                                style="width: {{ $connectionQuality }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            {{ $acceptedConnections }} dari {{ $totalConnections }} koneksi diterima
                        </p>
                    </div>

                    <!-- Ecosystem Participation -->
                    <div
                        class="p-4 border border-green-200 rounded-lg bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 dark:border-green-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Partisipasi
                                Ekosistem</h5>
                            <span
                                class="text-lg font-bold text-green-600 dark:text-green-400">{{ $ecosystemParticipation }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-green-500 rounded-full"
                                style="width: {{ $ecosystemParticipation }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            {{ $activeEcosystems }} dari {{ $totalEcosystems }} ekosistem aktif
                        </p>
                    </div>

                    <!-- Collective Action Engagement -->
                    <div
                        class="p-4 border border-orange-200 rounded-lg bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 dark:border-orange-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">
                                Keterlibatan Aksi Kolektif</h5>
                            <span
                                class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $collectiveActionEngagement }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-orange-500 rounded-full"
                                style="width: {{ $collectiveActionEngagement }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            {{ $activeActions }} dari {{ $totalActions }} aksi aktif
                        </p>
                    </div>

                    <!-- Skill Diversity -->
                    <div
                        class="p-4 border border-indigo-200 rounded-lg bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 dark:border-indigo-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Keragaman
                                Skill</h5>
                            <span
                                class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $skillDiversity }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-indigo-500 rounded-full"
                                style="width: {{ $skillDiversity }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            @if ($user->profile && $user->profile->skills)
                                @php
                                    $skills = is_array($user->profile->skills)
                                        ? $user->profile->skills
                                        : json_decode($user->profile->skills, true);
                                @endphp
                                {{ count($skills) }} skill terdaftar
                            @else
                                Belum ada skill
                            @endif
                        </p>
                    </div>

                    <!-- Activity Consistency -->
                    <div
                        class="p-4 border border-teal-200 rounded-lg bg-gradient-to-r from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 dark:border-teal-800">
                        <div class="flex items-center justify-between mb-2">
                            <h5 class="text-sm font-medium text-primary-blue dark:text-secondary-green">Konsistensi
                                Aktivitas</h5>
                            <span
                                class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $activityConsistency }}%</span>
                        </div>
                        <div class="w-full h-2 mb-2 bg-gray-200 rounded-full dark:bg-slate-700">
                            <div class="h-2 transition-all duration-1000 bg-teal-500 rounded-full"
                                style="width: {{ $activityConsistency }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-slate-300">
                            {{ $weeksSinceJoin }} minggu bergabung
                        </p>
                    </div>
                </div>

                <!-- Performance Insights -->
                <div class="p-4 mt-6 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                    <h4 class="mb-3 font-medium text-primary-blue dark:text-secondary-green">Insight Performa</h4>
                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                        <div>
                            <span class="text-gray-600 dark:text-slate-300">Kekuatan Utama:</span>
                            <span class="font-medium text-green-600 dark:text-green-400">
                                @php
                                    $metrics = [
                                        'profileCompleteness' => 'Kelengkapan Profil',
                                        'connectionQuality' => 'Kualitas Koneksi',
                                        'ecosystemParticipation' => 'Partisipasi Ekosistem',
                                        'collectiveActionEngagement' => 'Keterlibatan Aksi',
                                        'skillDiversity' => 'Keragaman Skill',
                                        'activityConsistency' => 'Konsistensi Aktivitas',
                                    ];
                                    $bestMetric = '';
                                    $bestScore = 0;
                                    foreach ($metrics as $key => $label) {
                                        if ($$key > $bestScore) {
                                            $bestScore = $$key;
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
                                    foreach ($metrics as $key => $label) {
                                        if ($$key < $worstScore) {
                                            $worstScore = $$key;
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
            <!-- User Avatar -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <x-ui.avatar :user="$user" size="xl" class="mx-auto mb-4" />
                <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green">{{ $user->name }}
                </h3>
                <p class="text-gray-600 dark:text-slate-300">{{ $user->email }}</p>
            </div>

            <!-- Aksi Cepat -->
            <div
                class="p-4 sm:p-6 rounded-xl shadow-lg bg-white dark:bg-slate-900 dark:border-t! dark:border-slate-700">
                <h3 class="mb-4 text-lg font-semibold text-primary-blue dark:text-secondary-green">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="block w-full px-4 py-2 text-center text-white transition-colors rounded-lg bg-primary-blue dark:bg-secondary-green hover:bg-sky-800 dark:hover:bg-teal-600">
                        Edit Pengguna
                    </a>
                    @if (!$user->isSuperAdmin() || \App\Models\User::where('role', 'super_admin')->count() > 1)
                        <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="block w-full px-4 py-2 text-center text-white transition-colors rounded-lg bg-accent-red hover:bg-red-700">
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
                        labels: ['Koneksi', 'Ekosistem', 'Aksi Kolektif'],
                        datasets: [{
                            data: [
                                {{ $user->sentConnections ? $user->sentConnections->where('status', 'accepted')->count() : 0 }},
                                {{ $user->ecosystems ? $user->ecosystems->count() : 0 }},
                                {{ $user->activeCollectiveActions ? $user->activeCollectiveActions->count() : 0 }}
                            ],
                            backgroundColor: [
                                '#3B82F6', // Blue
                                '#8B5CF6', // Purple
                                '#F59E0B' // Orange
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
