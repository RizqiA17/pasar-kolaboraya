<section class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($collaborations as $collaboration)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $collaboration->collaboration->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $collaboration->collaboration->description }}</p>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-50 to-sky-50 border border-sky-100 flex items-center justify-center">
                                <span class="text-sky-700 font-medium">{{ substr($collaboration->user->name, 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $collaboration->user->name }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $collaboration->collaboration->created_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('collaboration.todos', $collaboration->collaboration_id) }}"
                            class="inline-flex items-center px-3 py-2 bg-sky-500 text-white rounded-lg text-sm font-medium hover:bg-sky-600 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Lihat Todo
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">Belum ada kolaborasi</p>
                <p class="text-gray-400 text-sm mt-1">Mulai berkolaborasi dengan teman Anda</p>
            </div>
        @endforelse
    </div>
</section>
