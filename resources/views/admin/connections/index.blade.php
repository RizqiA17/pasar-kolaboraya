<x-admin.layout title="Connections Management">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200">Connections Management</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Manage all user connections in the system</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="md:w-48">
                    <flux:select name="status" placeholder="Filter by status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                    </flux:select>
                </div>
                <flux:button type="submit" variant="primary">Filter</flux:button>
                @if(request('status'))
                    <a href="{{ route('admin.connections') }}" class="px-4 py-2 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">Clear</a>
                @endif
            </form>
        </div>

        <!-- Connections Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Requester</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Receiver</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Requested</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($connections as $connection)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$connection->requester" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $connection->requester->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $connection->requester->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$connection->receiver" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $connection->receiver->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $connection->receiver->email }}</div>
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
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $connection->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <form method="POST" action="{{ route('admin.connections.delete', $connection) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this connection? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-slate-500 dark:text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No connections found</p>
                                        <p class="text-sm">Try adjusting your filter criteria</p>
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
