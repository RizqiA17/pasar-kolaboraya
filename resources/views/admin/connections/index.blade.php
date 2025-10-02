<x-admin.layout title="Manajemen Koneksi">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-blue dark:text-secondary-green">Manajemen Koneksi</h1>
                <p class="text-gray-600 dark:text-slate-300 mt-1 text-sm sm:text-base">Kelola semua koneksi pengguna dalam sistem</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Status Filter -->
                    <div class="lg:w-48">
                        <flux:select name="status" placeholder="Filter berdasarkan status">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Ditolak</option>
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
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary-blue dark:bg-secondary-green text-white rounded-lg hover:bg-sky-800 dark:hover:bg-teal-600 transition-colors">Filter</button>
                    
                    <!-- Clear Filters -->
                    @if(request('status') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.connections') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-slate-300 hover:text-primary-blue dark:hover:text-secondary-green">Hapus</a>
                    @endif
                </div>
                
                <!-- Active Filters Display -->
                @if(request('status') || request('date_from') || request('date_to'))
                    <div class="flex flex-wrap gap-2 pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-gray-600 dark:text-slate-300">Filter aktif:</span>
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

        <!-- Connections Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <!-- Mobile Card View (hidden on larger screens) -->
            <div class="block lg:hidden">
                @forelse($connections as $connection)
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 last:border-b-0">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <x-ui.avatar :user="$connection->requester" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">{{ $connection->requester->name }}</div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">{{ $connection->requester->email }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <x-ui.avatar :user="$connection->receiver" size="sm" />
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-primary-blue dark:text-secondary-green">{{ $connection->receiver->name }}</div>
                                    <div class="text-xs text-gray-600 dark:text-slate-300">{{ $connection->receiver->email }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'declined' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$connection->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ ucfirst($connection->status) }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-slate-300">
                                    {{ $connection->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-2">
                                <a href="{{ route('admin.connections.show', $connection) }}" 
                                   class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-xs font-medium">
                                    Lihat
                                </a>
                                <form method="POST" action="{{ route('admin.connections.delete', $connection) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-accent-red dark:text-accent-red hover:text-red-700 dark:hover:text-red-300 text-xs font-medium">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada koneksi ditemukan</p>
                            <p class="text-sm">Coba sesuaikan kriteria filter Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Peminta</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Penerima</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Diminta</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-primary-blue/60 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($connections as $connection)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$connection->requester" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $connection->requester->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">{{ $connection->requester->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$connection->receiver" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-primary-blue dark:text-secondary-green">{{ $connection->receiver->name }}</div>
                                            <div class="text-sm text-gray-600 dark:text-slate-300">{{ $connection->receiver->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'declined' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$connection->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                        {{ ucfirst($connection->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-300">
                                    {{ $connection->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.connections.show', $connection) }}" 
                                           class="text-primary-blue dark:text-secondary-green hover:text-sky-800 dark:hover:text-teal-400 text-sm font-medium">
                                            Lihat
                                        </a>
                                        <form method="POST" action="{{ route('admin.connections.delete', $connection) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-accent-red dark:text-accent-red hover:text-red-700 dark:hover:text-red-300 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-600 dark:text-slate-300">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-primary-blue dark:text-secondary-green">Tidak ada koneksi ditemukan</p>
                                        <p class="text-sm">Coba sesuaikan kriteria filter Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($connections->hasPages())
            <div class="flex justify-center">
                {{ $connections->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
