<x-admin.layout title="Manajemen Kontribusi">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-slate-200">Manajemen Kontribusi</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm sm:text-base">Kelola semua kontribusi dalam sistem</p>
            </div>
            <button onclick="openCreateModal()" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Tambah Kontribusi Baru
            </button>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <flux:input 
                        name="search" 
                        placeholder="Cari kontribusi berdasarkan nama..." 
                        value="{{ request('search') }}"
                        class="w-full"
                    />
                </div>
                
                <!-- Status Filter -->
                <div class="md:w-48">
                    <flux:select name="status" placeholder="Filter berdasarkan status">
                        <option value="">Semua Status</option>
                        <option value="used" {{ request('status') === 'used' ? 'selected' : '' }}>Digunakan</option>
                        <option value="unused" {{ request('status') === 'unused' ? 'selected' : '' }}>Tidak Digunakan</option>
                    </flux:select>
                </div>
                
                <!-- Date From -->
                <div class="md:w-48">
                    <flux:input 
                        name="date_from" 
                        type="date"
                        placeholder="Dari tanggal"
                        value="{{ request('date_from') }}"
                        class="w-full"
                    />
                </div>
                
                <!-- Date To -->
                <div class="md:w-48">
                    <flux:input 
                        name="date_to" 
                        type="date"
                        placeholder="Sampai tanggal"
                        value="{{ request('date_to') }}"
                        class="w-full"
                    />
                </div>
                
                <!-- Filter Button -->
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Cari</button>
                
                <!-- Clear Filters -->
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <a href="{{ route('admin.contributions') }}" class="px-4 py-2 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">Hapus</a>
                @endif
            </form>
            
            <!-- Active Filters Display -->
            @if(request('search') || request('status') || request('date_from') || request('date_to'))
                <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Filter aktif:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                            Pencarian: "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('status'))
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 rounded-full">
                            Status: {{ request('status') === 'used' ? 'Digunakan' : 'Tidak Digunakan' }}
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
            @endif
        </div>

        <!-- Kontribusis Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($contributions as $contribution)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $contribution->name }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-primary-blue/10 text-primary-blue dark:bg-primary-blue/20 dark:text-primary-blue">
                                    {{ $contribution->profiles_count }} pengguna
                                </span>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $contribution->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <button onclick="openEditModal({{ $contribution->id }}, '{{ $contribution->name }}')" 
                                        class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 text-xs font-medium">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.contributions.delete', $contribution) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this contribution? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            @if(request('search') || request('date_from') || request('date_to'))
                                <p class="text-lg font-medium">Tidak ada kontribusi ditemukan</p>
                                <p class="text-sm">Coba sesuaikan kriteria filter Anda atau hapus filter untuk melihat semua kontribusi</p>
                            @else
                                <p class="text-lg font-medium">Tidak ada kontribusi ditemukan</p>
                                <p class="text-sm">Tambah kontribusi pertama Anda untuk memulai</p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kontribusi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jumlah Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($contributions as $contribution)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $contribution->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-primary-blue/10 text-primary-blue dark:bg-primary-blue/20 dark:text-primary-blue">
                                        {{ $contribution->profiles_count }} pengguna
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $contribution->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick="openEditModal({{ $contribution->id }}, '{{ $contribution->name }}')" 
                                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.contributions.delete', $contribution) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this contribution? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-slate-500 dark:text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        @if(request('search') || request('date_from') || request('date_to'))
                                            <p class="text-lg font-medium">Tidak ada kontribusi ditemukan</p>
                                            <p class="text-sm">Coba sesuaikan kriteria filter Anda atau hapus filter untuk melihat semua kontribusi</p>
                                        @else
                                            <p class="text-lg font-medium">Tidak ada kontribusi ditemukan</p>
                                            <p class="text-sm">Tambah kontribusi pertama Anda untuk memulai</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($contributions->hasPages())
            <div class="flex justify-center">
                {{ $contributions->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black/50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 w-full max-w-md mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Tambah Kontribusi Baru</h3>
                <form method="POST" action="{{ route('admin.contributions.create') }}">
                    @csrf
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Kontribusi Name</flux:label>
                            <flux:input name="name" placeholder="Masukkan nama kontribusi..." required />
                            @error('name')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Tambah Kontribusi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 w-full max-w-md mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Edit Kontribusi</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <flux:field>
                            <flux:label>Kontribusi Name</flux:label>
                            <flux:input id="editName" name="name" placeholder="Masukkan nama kontribusi..." required />
                            @error('name')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" 
                                class="px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Perbarui Kontribusi
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

        function openEditModal(id, name) {
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = `/admin/contributions/${id}`;
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
