<x-admin.layout title="Detail Kolaborasi - {{ $collaboration->title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Kolaborasi</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">{{ $collaboration->title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.collaborations') }}" 
                   class="w-full sm:w-auto px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-center">
                    Kembali ke Kolaborasi
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
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Judul</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collaboration->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Deskripsi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $collaboration->description }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Status</label>
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                        'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                        'paused' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$collaboration->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($collaboration->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Created</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $collaboration->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$collaboration->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $collaboration->creator->name }}</div>
                            <div class="text-slate-600 dark:text-slate-400">{{ $collaboration->creator->email }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Bergabung {{ $collaboration->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Anggota -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Anggota</h3>
                    <div class="space-y-3">
                        @forelse($collaboration->collaborationUsers as $collaborationUser)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <x-ui.avatar :user="$collaborationUser->user" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $collaborationUser->user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $collaborationUser->user->email }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $collaborationUser->status === 'accepted' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                       ($collaborationUser->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                        'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                                    {{ ucfirst($collaborationUser->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400">Tidak ada anggota ditemukan.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tugas -->
                @if($collaboration->todos->count() > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Tugas ({{ $collaboration->todos->count() }})</h3>
                        <div class="space-y-2">
                            @foreach($collaboration->todos->take(5) as $todo)
                                <div class="flex items-center space-x-3 p-2 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                    <div class="w-4 h-4 rounded border-2 {{ $todo->completed ? 'bg-green-500 border-green-500' : 'border-slate-300 dark:border-slate-600' }}"></div>
                                    <span class="text-sm {{ $todo->completed ? 'line-through text-slate-500 dark:text-slate-400' : 'text-slate-800 dark:text-slate-200' }}">
                                        {{ $todo->title }}
                                    </span>
                                </div>
                            @endforeach
                            @if($collaboration->todos->count() > 5)
                                <p class="text-sm text-slate-500 dark:text-slate-400">... and {{ $collaboration->todos->count() - 5 }} more</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistik Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Statistik Cepat</h3>
                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $collaboration->collaborationUsers->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Anggota</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $collaboration->collaborationUsers->where('status', 'accepted')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Active Anggota</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $collaboration->todos->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Tugas</div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.collaborations.delete', $collaboration) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this collaboration? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Hapus Kolaborasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
