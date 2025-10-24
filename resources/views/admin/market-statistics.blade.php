<x-admin.layout title="Statistik Pasar">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Statistik Pasar Kolaboraya</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Rekap data lengkap dari sesi pasar yang dibuka</p>
            </div>
            <div class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">
                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
            </div>
        </div>

        <!-- Market Selector -->
        @if($pasarKolaborayaList->isNotEmpty())
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <label for="pasar-selector" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">
                Pilih Pasar Kolaboraya
            </label>
            <select id="pasar-selector" 
                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary-blue dark:focus:ring-secondary-green focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100"
                    onchange="window.location.href='{{ route('admin.market.statistics') }}?pasar_id=' + this.value">
                @foreach($pasarKolaborayaList as $pasar)
                    <option value="{{ $pasar->id }}" {{ $selectedPasar && $selectedPasar->id == $pasar->id ? 'selected' : '' }}>
                        {{ $pasar->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        @if($selectedPasar)
        <!-- Total Statistics Cards -->
        <div>
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4">Total Data</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Connections -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Koneksi</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['connections']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Ecosystems -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total Ekosistem</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['ecosystems']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users in Ecosystems -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">User Gabung Ekosistem</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['users_in_ecosystems']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users Contributed in Ecosystems -->
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-teal-100 text-sm font-medium">User Kontribusi Ekosistem</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['users_contributed_ecosystems']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Collective Actions -->
                <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-pink-100 text-sm font-medium">Total Aksi Kolektif</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['collective_actions']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users in Actions -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">User Gabung Aksi</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['users_in_actions']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ecosystems in Actions -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium">Ekosistem Gabung Aksi</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['ecosystems_in_actions']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Contributions in Actions -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">Total Kontribusi Aksi</p>
                            <p class="text-3xl font-bold mt-1">{{ number_format($stats['totals']['contributions_in_actions']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Connection Top Scores -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Top Score Koneksi
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Most Connections -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Koneksi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_connections']['most_connections'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $item['count'] }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Diverse by Role -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Koneksi Paling Bervariasi (Peran)</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_connections']['most_diverse_by_role'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $item['count'] }} peran</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ecosystems Most Diverse Roles -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Ekosistem Paling Bervariasi (Peran)</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_connections']['ecosystems_most_diverse_roles'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['ecosystem']->ecosystem_title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['ecosystem']->organization_name }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $item['count'] }} peran</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Ecosystem Top Scores -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Top Score Ekosistem
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Most Members -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Ekosistem dengan Anggota Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_ecosystems']['most_members'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['ecosystem']->ecosystem_title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['ecosystem']->organization_name }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $item['count'] }} anggota</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Contributions -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Ekosistem dengan Kontribusi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_ecosystems']['most_contributions'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['ecosystem']->ecosystem_title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['ecosystem']->organization_name }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $item['count'] }} kontribusi</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Ecosystem Contribution Top Scores -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Top Score Kontribusi Ekosistem
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Most Given Type -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Kontribusi Paling Banyak Diberikan</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_ecosystem_contributions']['most_given_type'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-teal-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item->name }}</p>
                                </div>
                                <span class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $item->count }}×</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Contributors -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Kontribusi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_ecosystem_contributions']['most_contributors'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $item['count'] }} kontribusi</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Users with Most Ecosystems -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Ekosistem Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_ecosystem_contributions']['users_with_most_ecosystems'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $item['count'] }} ekosistem</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Collective Action Top Scores -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Top Score Aksi Kolektif
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Most Members -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Aksi dengan Anggota Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_actions']['most_members'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-pink-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['action']->title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['action']->scale }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ $item['count'] }} anggota</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Diverse by Role -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Aksi Paling Bervariasi (Peran)</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_actions']['most_diverse_by_role'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['action']->title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['action']->scale }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $item['count'] }} peran</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Ecosystems -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Aksi dengan Ekosistem Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_actions']['most_ecosystems'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-indigo-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['action']->title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['action']->scale }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $item['count'] }} ekosistem</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Contributions -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Aksi dengan Kontribusi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_actions']['most_contributions'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ Str::limit($item['action']->title, 30) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['action']->scale }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $item['count'] }} kontribusi</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Contribution Top Scores -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h2 class="text-xl font-bold text-primary-blue dark:text-secondary-green mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Top Score Kontribusi Aksi
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Most Given Type -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">Kontribusi Paling Sering Diberikan</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_action_contributions']['most_given_type'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-yellow-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item->name }}</p>
                                </div>
                                <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $item->count }}×</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Contributors -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Kontribusi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_action_contributions']['most_contributors'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-cyan-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $item['count'] }} kontribusi</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Users with Most Actions -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-3">User dengan Aksi Terbanyak</h3>
                    <div class="space-y-2">
                        @forelse($stats['top_action_contributions']['users_with_most_actions'] as $index => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-lime-500 text-white rounded-full font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-slate-100">{{ $item['user']->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $item['user']->assigned_role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-lime-600 dark:text-lime-400">{{ $item['count'] }} aksi</span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-slate-400 text-sm">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-300 mb-2">Tidak ada Pasar Kolaboraya yang aktif</h3>
                <p class="text-gray-600 dark:text-slate-400">Silakan buat Pasar Kolaboraya terlebih dahulu untuk melihat statistik.</p>
            </div>
        @endif
    </div>
</x-admin.layout>

