<x-admin.layout title="Manajemen Peran">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Manajemen Peran</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Kelola semua peran dalam sistem</p>
            </div>
            <button onclick="openCreateModal()" class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors">
                Tambah Peran Baru
            </button>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <flux:input 
                            name="search" 
                            placeholder="Cari peran berdasarkan nama atau deskripsi..." 
                            value="{{ request('search') }}"
                            class="w-full"
                        />
                    </div>
                    
                    
                    <!-- Usage Filter -->
                    <div class="lg:w-48">
                        <flux:select name="usage" placeholder="Filter berdasarkan penggunaan">
                            <option value="">Semua Penggunaan</option>
                            <option value="used" {{ request('usage') === 'used' ? 'selected' : '' }}>Digunakan</option>
                            <option value="unused" {{ request('usage') === 'unused' ? 'selected' : '' }}>Tidak Digunakan</option>
                        </flux:select>
                    </div>
                    
                    <!-- Date From -->
                    <div class="lg:w-48">
                        <flux:input 
                            name="date_from" 
                            type="date"
                            placeholder="Dari tanggal"
                            value="{{ request('date_from') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Date To -->
                    <div class="lg:w-48">
                        <flux:input 
                            name="date_to" 
                            type="date"
                            placeholder="Sampai tanggal"
                            value="{{ request('date_to') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Filter Button -->
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors">Cari</button>
                    
                    <!-- Clear Filters -->
                    @if(request('search') || request('usage') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.peran') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green">Hapus</a>
                    @endif
                </div>
                
                <!-- Active Filters Display -->
                @if(request('search') || request('usage') || request('date_from') || request('date_to'))
                    <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-gray-600 dark:text-slate-300">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                Pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('usage'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full">
                                Penggunaan: {{ request('usage') === 'used' ? 'Digunakan' : 'Tidak Digunakan' }}
                            </span>
                        @endif
                        @if(request('date_from'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                            </span>
                        @endif
                        @if(request('date_to'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                            </span>
                        @endif
                    </div>
                @endif
            </form>
        </div>

        <!-- Peran Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($peran as $role)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $role->nama }}</div>
                                    <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 line-clamp-2">{{ Str::limit($role->deskripsi, 80) }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $role->profiles_count }} pengguna
                                    </span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-slate-400">
                                    {{ $role->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <button onclick="openEditModal({{ $role->id }}, '{{ $role->nama }}', '{{ addslashes($role->deskripsi) }}')" 
                                        class="text-accent-orange hover:text-orange-700 dark:text-accent-orange-400 dark:hover:text-orange-400 text-xs font-medium">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.peran.delete', $role) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-accent-red hover:text-red-700 dark:text-accent-red-400 dark:hover:text-red-400 text-xs font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-gray-600 dark:text-slate-300">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada peran ditemukan</p>
                            <p class="text-sm">Tambah peran pertama Anda untuk memulai</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Peran</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Jumlah Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($peran as $role)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $role->nama }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 dark:text-slate-300 max-w-xs">
                                        {{ Str::limit($role->deskripsi, 100) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $role->profiles_count }} pengguna
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ $role->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick="openEditModal({{ $role->id }}, '{{ $role->nama }}', '{{ addslashes($role->deskripsi) }}')" 
                                                class="text-accent-orange hover:text-orange-700 dark:text-accent-orange-400 dark:hover:text-orange-400 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.peran.delete', $role) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-accent-red hover:text-red-700 dark:text-accent-red-400 dark:hover:text-red-400 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-600 dark:text-slate-300">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada peran ditemukan</p>
                                        <p class="text-sm">Tambah peran pertama Anda untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($peran->hasPages())
            <div class="flex justify-center">
                {{ $peran->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black/50 hidden z-50 lg:max-h-svh max-h-[calc(100svh_-_104px)]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 w-full max-w-md mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Tambah Peran Baru</h3>
                <form method="POST" action="{{ route('admin.peran.create') }}">
                    @csrf
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Nama Peran</flux:label>
                            <flux:input name="nama" placeholder="Masukkan nama peran..." required />
                            @error('nama')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Deskripsi</flux:label>
                            <flux:textarea name="deskripsi" placeholder="Masukkan deskripsi peran..." rows="3" required></flux:textarea>
                            @error('deskripsi')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-4 py-2 text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors">
                            Tambah Peran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden z-50 lg:max-h-svh max-h-[calc(100svh_-_104px)]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 w-full max-w-md mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-primary-blue dark:text-secondary-green mb-4">Edit Peran</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Nama Peran</flux:label>
                            <flux:input id="editNama" name="nama" placeholder="Masukkan nama peran..." required />
                            @error('nama')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Deskripsi</flux:label>
                            <flux:textarea id="editDeskripsi" name="deskripsi" placeholder="Masukkan deskripsi peran..." rows="3" required></flux:textarea>
                            @error('deskripsi')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-4 py-2 text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors">
                            Perbarui Peran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(id, nama, deskripsi) {
            document.getElementById('editNama').value = nama;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editForm').action = `/admin/peran/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) closeCreateModal();
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
    </script>
</x-admin.layout>
