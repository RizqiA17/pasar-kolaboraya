<x-admin.layout title="Events Management">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200">Events Management</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Manage all events in the system</p>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <flux:input 
                        name="search" 
                        placeholder="Search events by title..." 
                        value="{{ request('search') }}"
                        class="w-full"
                    />
                </div>
                <div class="md:w-48">
                    <flux:select name="status" placeholder="Filter by status">
                        <option value="">All Status</option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </flux:select>
                </div>
                <flux:button type="submit" variant="primary">Search</flux:button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.events') }}" class="px-4 py-2 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">Clear</a>
                @endif
            </form>
        </div>

        <!-- Events Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-white/20 dark:border-slate-700/50 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Event</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Creator</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($events as $event)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $event->title }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400 truncate max-w-xs">{{ Str::limit($event->description, 60) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <x-ui.avatar :user="$event->creator" size="sm" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $event->creator->name }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $event->creator->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-800 dark:text-slate-200">
                                        {{ $event->start_date ? $event->start_date->format('M d, Y') : 'TBD' }}
                                    </div>
                                    @if($event->start_date && $event->end_date)
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            to {{ $event->end_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $event->location ?: 'TBD' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.events.show', $event) }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                            View
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.delete', $event) }}" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No events found</p>
                                        <p class="text-sm">Try adjusting your search criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>
