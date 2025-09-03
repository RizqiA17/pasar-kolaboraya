<x-admin.layout title="Detail Acara - {{ $event->title }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Acara</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">{{ $event->title }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.events') }}" 
                   class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors">
                    Kembali ke Acara
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
                            <p class="text-slate-800 dark:text-slate-200">{{ $event->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Deskripsi</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $event->description }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal Mulai</label>
                                <p class="text-slate-800 dark:text-slate-200">
                                    {{ $event->start_date ? $event->start_date->format('M d, Y H:i') : 'TBD' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Tanggal Selesai</label>
                                <p class="text-slate-800 dark:text-slate-200">
                                    {{ $event->end_date ? $event->end_date->format('M d, Y H:i') : 'TBD' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Lokasi</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $event->location ?: 'TBD' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Dibuat</label>
                                <p class="text-slate-800 dark:text-slate-200">{{ $event->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembuat Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Pembuat</h3>
                    <div class="flex items-center space-x-4">
                        <x-ui.avatar :user="$event->creator" size="lg" />
                        <div>
                            <div class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $event->creator->name }}</div>
                            <div class="text-slate-600 dark:text-slate-400">{{ $event->creator->email }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Bergabung {{ $event->creator->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Peserta -->
                @if($event->participants->count() > 0)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Peserta ({{ $event->participants->count() }})</h3>
                        <div class="space-y-3">
                            @foreach($event->participants->take(10) as $participant)
                                <div class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                    <x-ui.avatar :user="$participant" size="sm" />
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $participant->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $participant->email }}</div>
                                    </div>
                                </div>
                            @endforeach
                            @if($event->participants->count() > 10)
                                <p class="text-sm text-slate-500 dark:text-slate-400">... and {{ $event->participants->count() - 10 }} peserta lainnya</p>
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
                            <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $event->participants->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Peserta</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $event->categories->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Kategori</div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.events.delete', $event) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Hapus Acara
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
