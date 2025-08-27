<section>

    {{-- Connection List --}}
    <div class="grid gap-4">
        @forelse ($friends as $friend)
            <div
                class="bg-white rounded-xl border border-gray-100 p-4 flex items-center justify-between hover:border-blue-100 hover:bg-blue-50/5 transition-all duration-200 group">

                <div class="flex items-center justify-between w-full shrink">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium text-lg shadow-inner">
                                {{ substr($friend['name'], 0, 2) }}
                            </div>
                        </div>
                        <div>
                            <h3
                                class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                {{ $friend['name'] }}</h3>
                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span>1 mutual friends</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:button variant="outline" size="sm"
                            class="text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 hover:border-gray-300 shadow-sm transition-all duration-150 px-3 py-1.5 rounded-lg">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span class="font-medium">Chat</span>
                            </div>
                        </flux:button>

                        <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}">
                            <flux:button variant="primary" size="sm"
                                class="bg-blue-500 hover:bg-blue-600 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-1.5 rounded-lg">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span class="font-medium">Kolaborasi</span>
                                </div>
                            </flux:button>
                        </flux:modal.trigger>
                    </div>
                </div>
                <flux:modal name="create-collaboration-{{ $friend['id'] }}" variant="flyout">
                    <livewire:collaborations.new-collaboration :friend-id="$friend['id']" />
                </flux:modal>
            </div>
        @empty
            <div class="text-center py-12 px-4">
                <div
                    class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-50 to-purple-50 border-2 border-blue-100/50 flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Koneksi</h3>
                <p class="text-gray-600 max-w-sm mx-auto leading-relaxed">
                    Mulai terhubung dengan kreator perubahan lainnya untuk berkolaborasi dan menciptakan dampak yang
                    lebih besar.
                </p>
                <div class="mt-8">
                    <a href="{{ route('connections') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Temukan Kreator
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</section>
