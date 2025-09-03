<x-admin.layout title="Detail Pengguna - {{ $user->name }}">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200">Detail Pengguna</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">{{ $user->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Pengguna
                </a>
                <a href="{{ route('admin.users') }}" 
                   class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors">
                    Kembali ke Pengguna
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Nama</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Email</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Peran</label>
                            @php
                                $roleColors = [
                                    'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                    'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                    'super_admin' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Email Terverifikasi</label>
                            <p class="text-slate-800 dark:text-slate-200">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">Ya</span> ({{ $user->email_verified_at->format('M d, Y H:i') }})
                                @else
                                    <span class="text-red-600 dark:text-red-400">Tidak</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Bergabung</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Terakhir Diperbarui</label>
                            <p class="text-slate-800 dark:text-slate-200">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Profil -->
                @if($user->profile)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Informasi Profil</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($user->profile->organization)
                                <div>
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Organisasi</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->organization }}</p>
                                </div>
                            @endif
                            @if($user->profile->phone)
                                <div>
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Telepon</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->phone }}</p>
                                </div>
                            @endif
                            @if($user->profile->vision)
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Visi</label>
                                    <p class="text-slate-800 dark:text-slate-200">{{ $user->profile->vision }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Koneksi -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Koneksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $user->sentKoneksi->where('status', 'accepted')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Accepted Koneksi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $user->sentKoneksi->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Dikirim</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $user->receivedKoneksi->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Menunggu Diterima</div>
                        </div>
                    </div>
                </div>

                <!-- Kolaborasi -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Kolaborasi</h3>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $user->collaborations->count() }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">Active Kolaborasi</div>
                    </div>
                </div>

                <!-- Acara -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Acara</h3>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $user->events->count() }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">Participating Acara</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Avatar -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
                    <x-ui.avatar :user="$user" size="xl" class="mx-auto mb-4" />
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $user->name }}</h3>
                    <p class="text-slate-600 dark:text-slate-400">{{ $user->email }}</p>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="block w-full px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Pengguna
                        </a>
                        @if(!$user->isSuperAdmin() || User::where('role', 'super_admin')->count() > 1)
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="block w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Hapus Pengguna
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
