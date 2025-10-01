<x-admin.layout title="Manajemen Pengguna">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Manajemen Pengguna</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola semua pengguna dalam sistem</p>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="space-y-4">
                <div class="space-y-4">
                    <!-- Search Input -->
                    <div>
                        <flux:input 
                            name="search" 
                            placeholder="Cari pengguna berdasarkan nama atau email..." 
                            value="{{ request('search') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Filter Row 1 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Role Filter -->
                        <div>
                        <flux:select name="role" placeholder="Filter berdasarkan peran">
                            <option value="">Semua Role</option>
                            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Pengguna</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </flux:select>
                    </div>
                    
                    <!-- Peran Peserta Filter -->
                    <div>
                        <flux:select name="peran_peserta" placeholder="Filter berdasarkan peran peserta">
                            <option value="">Semua Peran Peserta</option>
                            <option value="ecosystem_builder" {{ request('peran_peserta') == 'ecosystem_builder' ? 'selected' : '' }}>Ekosistem Builder</option>
                            @foreach(\App\Models\Peran::get() as $peran)
                                <option value="{{ $peran->nama }}" {{ request('peran_peserta') == $peran->nama ? 'selected' : '' }}>{{ $peran->nama }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    
                    <!-- Status Filter -->
                        <div>
                        <flux:select name="status" placeholder="Filter berdasarkan status">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Belum Terverifikasi</option>
                        </flux:select>
                    </div>
                    
                    <!-- Date From -->
                        <div>
                        <flux:input 
                            name="date_from" 
                            type="date"
                            placeholder="Dari tanggal"
                            value="{{ request('date_from') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Date To -->
                        <div>
                        <flux:input 
                            name="date_to" 
                            type="date"
                            placeholder="Sampai tanggal"
                            value="{{ request('date_to') }}"
                            class="w-full"
                        />
                        </div>
                    </div>
                    
                    <!-- Filter Row 2 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Empty space for alignment -->
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary-blue text-white rounded-lg hover:bg-sky-700 transition-colors">Cari</button>
                    
                    <!-- Clear Filters -->
                    @if(request('search') || request('role') || request('peran_peserta') || request('status') || request('date_from') || request('date_to'))
                            <a href="{{ route('admin.users') }}" class="w-full sm:w-auto px-4 py-2 text-sm text-center text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Hapus Filter</a>
                    @endif
                    </div>
                </div>
                
                <!-- Active Filters Display -->
                @if(request('search') || request('role') || request('peran_peserta') || request('status') || request('date_from') || request('date_to'))
                    <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex flex-wrap gap-2">
                            <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 w-full sm:w-auto">Filter aktif:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                                    Pencarian: "{{ request('search') }}"
                                </span>
                            @endif
                            @if(request('role'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 rounded-full">
                                    Peran: {{ ucfirst(str_replace('_', ' ', request('role'))) }}
                                </span>
                            @endif
                            @if(request('peran_peserta'))
                                @php
                                    $peranName = request('peran_peserta') === 'ecosystem_builder' ? 'Ekosistem Builder' : request('peran_peserta');
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-full">
                                    Peran Peserta: {{ $peranName }}
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 rounded-full">
                                    Status: {{ request('status') === 'verified' ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                </span>
                            @endif
                            @if(request('date_from'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                    Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                                </span>
                            @endif
                            @if(request('date_to'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                    Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($users as $user)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="flex items-start space-x-3">
                            <x-ui.avatar :user="$user" size="md" />
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                    </div>
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
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                    @if($user->email_verified_at)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-secondary-green/10 text-secondary-green dark:bg-secondary-green/20 dark:text-secondary-green">
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-neutral-orange/10 text-neutral-orange dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                            Belum Terverifikasi
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @if($user->is_ecosystem_builder)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-neutral-purple/10 text-neutral-purple dark:bg-neutral-purple/20 dark:text-neutral-purple">
                                            Ekosistem Builder
                                        </span>
                                    @elseif($user->assigned_role)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-primary-blue/10 text-primary-blue dark:bg-primary-blue/20 dark:text-primary-blue">
                                            {{ $user->assigned_role }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800 dark:bg-slate-900/20 dark:text-slate-400">
                                            Belum Dipilih
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-3 flex items-center space-x-3">
                                    <a href="{{ route( 'admin.users.show', $user) }}" 
                                       class="text-primary-blue dark:text-blue-400 hover:text-sky-700 dark:hover:text-blue-300 text-xs font-medium">
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 text-xs font-medium">
                                        Edit
                                    </a>
                                    @if(!$user->isSuperAdmin() || $superAdminCount > 1)
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <p class="text-lg font-medium">Tidak ada pengguna ditemukan</p>
                            <p class="text-sm">Coba sesuaikan kriteria pencarian Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Peran</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Peran Peserta</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$user" size="md" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_ecosystem_builder)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-neutral-purple/10 text-neutral-purple dark:bg-neutral-purple/20 dark:text-neutral-purple">
                                            Ekosistem Builder
                                        </span>
                                    @elseif($user->assigned_role != '')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-primary-blue/10 text-primary-blue dark:bg-primary-blue/20 dark:text-primary-blue">
                                            {{ $user->assigned_role }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800 dark:bg-slate-900/20 dark:text-slate-400">
                                            Belum Dipilih
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-secondary-green/10 text-secondary-green dark:bg-secondary-green/20 dark:text-secondary-green">
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-neutral-orange/10 text-neutral-orange dark:bg-neutral-orange/20 dark:text-neutral-orange">
                                            Belum Terverifikasi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-primary-blue dark:text-blue-400 hover:text-sky-700 dark:hover:text-blue-300 text-sm font-medium">
                                            Lihat
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 text-sm font-medium">
                                            Edit
                                        </a>
                                        @if(!$user->isSuperAdmin() || $superAdminCount > 1)
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-slate-500 dark:text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada pengguna ditemukan</p>
                                        <p class="text-sm">Coba sesuaikan kriteria pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
