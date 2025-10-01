<x-admin.layout title="Analisis Sesi Pasar">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-primary-blue">Analisis Sesi Pasar</h1>
                <p class="text-primary-blue/70 dark:text-primary-blue/70 mt-1 text-sm sm:text-base">Kesehatan dan performa ekosistem kolaborasi</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari sesi pasar..." 
                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white">
                </div>
                
                <div class="md:col-span-2 lg:col-span-4 flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-primary-blue text-white rounded-lg hover:bg-sky-700 transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('admin.market-analysis') }}" class="px-4 py-2 bg-primary-blue/60 text-white rounded-lg hover:bg-primary-blue/70 transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Sessions List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($sessions as $session)
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg hover:shadow-xl transition-shadow">
                    <!-- Session Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-primary-blue dark:text-primary-blue mb-1">
                                {{ $session->name }}
                            </h3>
                            <p class="text-sm text-primary-blue/70 dark:text-primary-blue/70">
                                Dibuat oleh {{ $session->creator->name }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($session->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                            @elseif($session->status === 'inactive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                            @endif">
                            {{ $session->status_label }}
                        </span>
                    </div>

                    <!-- Session Description -->
                    @if($session->description)
                        <p class="text-sm text-primary-blue/70 dark:text-primary-blue/70 mb-4 line-clamp-2">
                            {{ $session->description }}
                        </p>
                    @endif

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary-blue dark:text-primary-blue">
                                {{ $session->acceptedUsers->count() }}
                            </div>
                            <div class="text-xs text-primary-blue/70 dark:text-primary-blue/70">Pengguna</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neutral-purple dark:text-neutral-purple">
                                {{ $session->ecosystems->count() }}
                            </div>
                            <div class="text-xs text-primary-blue/70 dark:text-primary-blue/70">Ekosistem</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-accent-red dark:text-accent-red">
                                {{ $session->collectiveActions->count() }}
                            </div>
                            <div class="text-xs text-primary-blue/70 dark:text-primary-blue/70">Aksi Kolektif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary-green dark:text-secondary-green">
                                @php
                                    $daysSinceStart = $session->created_at->diffInDays(now());
                                @endphp
                                @if($daysSinceStart < 1)
                                    {{ round($session->created_at->diffInHours(now())) }} jam
                                @elseif($daysSinceStart < 7)
                                    {{ $daysSinceStart }} hari
                                @elseif($daysSinceStart < 30)
                                    {{ round($daysSinceStart / 7, 1) }} minggu
                                @else
                                    {{ round($daysSinceStart / 30, 1) }} bulan
                                @endif
                            </div>
                            <div class="text-xs text-primary-blue/70 dark:text-primary-blue/70">
                                @if($daysSinceStart < 1)
                                    Aktif
                                @else
                                    Hari
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Session Dates -->
                    <div class="text-xs text-primary-blue/60 dark:text-primary-blue/60 mb-4">
                        <div>Dibuat: {{ $session->created_at->format('d M Y H:i') }}</div>
                        @if($session->started_at)
                            <div>Dimulai: {{ $session->started_at->format('d M Y H:i') }}</div>
                        @endif
                        @if($session->ended_at)
                            <div>Berakhir: {{ $session->ended_at->format('d M Y H:i') }}</div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('admin.market-analysis.show', $session) }}" 
                       class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                        Lihat Analisis Detail
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-slate-400 dark:text-slate-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-primary-blue/70 dark:text-primary-blue/70 mb-2">Tidak ada sesi pasar</h3>
                    <p class="text-slate-500 dark:text-slate-500">Belum ada sesi pasar yang tersedia untuk dianalisis.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages())
            <div class="mt-6">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
