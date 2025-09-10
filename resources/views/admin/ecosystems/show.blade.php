<x-admin.layout title="Detail Ekosistem - {{ $ecosystem->ecosystem_title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Ekosistem</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $ecosystem->ecosystem_title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.ecosystems') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Kembali ke Ekosistem
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
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Judul Ekosistem</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->ecosystem_title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Nama Organisasi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->organization_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Deskripsi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->description }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Wilayah Kerja</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->work_region }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                        'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                    ];
                                    $status = $ecosystem->is_active ? 'active' : 'inactive';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Maksimal Anggota</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->max_users ?: 'Tidak terbatas' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Auto Join Aksi Kolektif</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->auto_join_collective_actions ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Dibuat</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $ecosystem->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$ecosystem->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $ecosystem->creator->name }}</div>
                            <div class="text-slate-600 dark:text-slate-400">{{ $ecosystem->creator->email }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Bergabung {{ $ecosystem->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Issues Addressed -->
                @if($ecosystem->issues_addressed && count($ecosystem->issues_addressed) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Isu yang Ditangani</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->issues_addressed as $issue)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                                    {{ $issue }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Existing Roles -->
                @if($ecosystem->existing_roles && count($ecosystem->existing_roles) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Peran yang Sudah Ada</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->existing_roles as $role)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Needed Roles -->
                @if($ecosystem->needed_roles && count($ecosystem->needed_roles) > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Peran yang Dibutuhkan</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($ecosystem->needed_roles as $role)
                                <span class="inline-flex px-3 py-1 text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 rounded-full">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Anggota -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Anggota ({{ $ecosystem->users->count() }})</h3>
                    <div class="space-y-3">
                        @forelse($ecosystem->users as $user)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <x-ui.avatar :user="$user" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->pivot->status === 'accepted' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                       ($user->pivot->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                                    {{ ucfirst($user->pivot->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400">Tidak ada anggota ditemukan.</p>
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
</x-admin.layout>
