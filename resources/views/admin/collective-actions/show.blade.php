<x-admin.layout title="Detail Aksi Kolektif - {{ $collectiveAction->title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Aksi Kolektif</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $collectiveAction->title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.collective-actions') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Kembali ke Aksi Kolektif
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Judul Aksi Kolektif</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Deskripsi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->description }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tujuan</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->goals }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
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
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Skala</label>
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-full">
                                    {{ ucfirst($collectiveAction->scale) }}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Lingkup</label>
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 rounded-full">
                                    {{ ucfirst($collectiveAction->scope) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Minimal Ekosistem</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->min_ecosystems }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal Mulai</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->start_date ? $collectiveAction->start_date->format('d M Y') : 'Tidak ditentukan' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal Selesai</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->end_date ? $collectiveAction->end_date->format('d M Y') : 'Tidak ditentukan' }}</p>
                            </div>
                        </div>
                        @if($collectiveAction->location)
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Lokasi</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->location }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Dibuat</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$collectiveAction->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $collectiveAction->creator->name }}</div>
                            <div class="text-slate-600 dark:text-slate-400">{{ $collectiveAction->creator->email }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Bergabung {{ $collectiveAction->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Required Resources -->
                @if($collectiveAction->required_resources && count($collectiveAction->required_resources) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Sumber Daya yang Dibutuhkan</h3>
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
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Syarat Kolaborasi</h3>
                        <p class="text-slate-800 dark:text-slate-200">{{ $collectiveAction->collaboration_terms }}</p>
                    </div>
                @endif

                <!-- Participating Ecosystems -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Ekosistem yang Berpartisipasi ({{ $collectiveAction->participatingEcosystems->count() }})</h3>
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
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $ecosystem->ecosystem_title }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $ecosystem->organization_name }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    Berpartisipasi
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400">Tidak ada ekosistem yang berpartisipasi.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Contributors -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Kontributor ({{ $collectiveAction->contributors->count() }})</h3>
                    <div class="space-y-3">
                        @forelse($collectiveAction->contributors as $contributor)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <x-ui.avatar :user="$contributor" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $contributor->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $contributor->email }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ ucfirst($contributor->pivot->contribution_type) }}</div>
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
                            <p class="text-slate-500 dark:text-slate-400">Tidak ada kontributor ditemukan.</p>
                        @endforelse
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
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $collectiveAction->participatingEcosystems->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Ekosistem Berpartisipasi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $collectiveAction->contributors->where('pivot.status', 'accepted')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Kontributor Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $collectiveAction->contributors->where('pivot.status', 'offered')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Persetujuan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $collectiveAction->min_ecosystems }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Minimal Ekosistem</div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
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
</x-admin.layout>
