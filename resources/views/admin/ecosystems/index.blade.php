<x-admin.layout title="Manajemen Ekosistem">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Manajemen Ekosistem</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Kelola semua ekosistem dalam sistem</p>
            </div>
        </div>

        <!-- Filters and Cari -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <flux:input 
                            name="search" 
                            placeholder="Cari ekosistem berdasarkan judul..." 
                            value="{{ request('search') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="lg:w-48">
                        <flux:select name="status" placeholder="Filter berdasarkan status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
                    @if(request('search') || request('status') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.ecosystems') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-slate-300 hover:text-gray-800 dark:hover:text-slate-200">Hapus</a>
                    @endif
                </div>
                
                <!-- Active Filters Display -->
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-gray-600 dark:text-slate-300">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                Pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full">
                                Status: {{ ucfirst(request('status')) }}
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

        <!-- Ecosystems Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($ecosystems as $ecosystem)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->ecosystem_title }}</div>
                                <div class="text-xs text-gray-600 dark:text-slate-300 mt-1">{{ Str::limit($ecosystem->description, 80) }}</div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <x-ui.avatar :user="$ecosystem->creator" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->creator->name }}</div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">{{ $ecosystem->creator->email }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @php
                                        $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                        $status = $ecosystem->is_active ? 'active' : 'inactive';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                        {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-slate-300">
                                    {{ $ecosystem->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <a href="{{ route('admin.ecosystems.show', $ecosystem) }}" 
                                   class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-xs font-medium">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.ecosystems.delete', $ecosystem) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this ecosystem? This action cannot be undone.')">
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
                        <flux:icon.clipboard-document-list class="size-16 text-gray-400 mx-auto mb-4" />
                        <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green mb-2">Tidak ada ekosistem ditemukan</h3>
                        <p class="text-gray-600 dark:text-slate-300 mb-4">Coba sesuaikan kriteria pencarian Anda</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Ekosistem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Pembuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($ecosystems as $ecosystem)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->ecosystem_title }}</div>
                                        <div class="text-sm text-gray-600 dark:text-slate-300 truncate max-w-xs">{{ Str::limit($ecosystem->description, 60) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$ecosystem->creator" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $ecosystem->creator->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">{{ $ecosystem->creator->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                        $status = $ecosystem->is_active ? 'active' : 'inactive';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                        {{ $ecosystem->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-primary-blue dark:text-secondary-green">
                                    {{ $ecosystem->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.ecosystems.show', $ecosystem) }}" 
                                           class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-sm font-medium">
                                            Lihat
                                        </a>
                                        <form method="POST" action="{{ route('admin.ecosystems.delete', $ecosystem) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this ecosystem? This action cannot be undone.')">
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <flux:icon.clipboard-document-list class="size-16 text-gray-400 mx-auto mb-4" />
                                    <h3 class="text-lg font-medium text-primary-blue dark:text-secondary-green mb-2">Tidak ada ekosistem ditemukan</h3>
                                    <p class="text-gray-600 dark:text-slate-300">Coba sesuaikan kriteria pencarian Anda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($ecosystems->hasPages())
            <div class="flex justify-center">
                {{ $ecosystems->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
