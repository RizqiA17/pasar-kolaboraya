<x-admin.layout title="Manajemen Aksi Kolektif">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Manajemen Aksi Kolektif</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Kelola semua aksi kolektif dalam sistem</p>
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
                            placeholder="Cari aksi kolektif berdasarkan judul..." 
                            value="{{ request('search') }}"
                            class="w-full"
                        />
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="lg:w-48">
                        <flux:select name="status" placeholder="Filter berdasarkan status">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="planning" {{ request('status') === 'planning' ? 'selected' : '' }}>Perencanaan</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
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
                        <a href="{{ route('admin.collective-actions') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green">Hapus</a>
                    @endif
                </div>
                
                <!-- Active Filters Display -->
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-gray-600 dark:text-slate-300">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                                Pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('status'))
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 rounded-full">
                                Status: {{ ucfirst(request('status')) }}
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
            </form>
        </div>

        <!-- Collective Actions Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($collectiveActions as $collectiveAction)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $collectiveAction->title }}</div>
                                <div class="text-xs text-gray-600 dark:text-slate-300 mt-1">{{ Str::limit($collectiveAction->description, 80) }}</div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <x-ui.avatar :user="$collectiveAction->creator" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">{{ $collectiveAction->creator->name }}</div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">{{ $collectiveAction->creator->email }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
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
                                <div class="text-xs text-gray-500 dark:text-slate-400">
                                    {{ $collectiveAction->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <a href="{{ route('admin.collective-actions.show', $collectiveAction) }}" 
                                   class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-xs font-medium">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.collective-actions.delete', $collectiveAction) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this collective action? This action cannot be undone.')">
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
                        <div class="text-gray-600 dark:text-slate-300">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada aksi kolektif ditemukan</p>
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
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Aksi Kolektif</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Pembuat</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Skala</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($collectiveActions as $collectiveAction)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $collectiveAction->title }}</div>
                                        <div class="text-sm text-gray-600 dark:text-slate-300 truncate max-w-xs">{{ Str::limit($collectiveAction->description, 60) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$collectiveAction->creator" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $collectiveAction->creator->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">{{ $collectiveAction->creator->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-full">
                                        {{ ucfirst($collectiveAction->scale) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ $collectiveAction->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.collective-actions.show', $collectiveAction) }}" 
                                           class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-sm font-medium">
                                            Lihat
                                        </a>
                                        <form method="POST" action="{{ route('admin.collective-actions.delete', $collectiveAction) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this collective action? This action cannot be undone.')">
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-600 dark:text-slate-300">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada aksi kolektif ditemukan</p>
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
        @if($collectiveActions->hasPages())
            <div class="flex justify-center">
                {{ $collectiveActions->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
