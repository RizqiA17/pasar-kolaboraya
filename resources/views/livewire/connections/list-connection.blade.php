<section>
    {{-- Modals --}}
    <flux:modal name="create-collaboration" variant="flyout">
        <livewire:collaborations.new-collaboration :friend-id="null" />
    </flux:modal>

    {{-- Connection List --}}
    <div class="grid gap-4">
        @forelse ($friends as $friend)
            <div class="bg-white rounded-xl border border-neutral-100 p-4 flex items-center justify-between hover:border-sky-100 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-100 to-blue-50 flex items-center justify-center text-sky-700 font-medium text-lg border border-sky-100">
                            {{ substr($friend['name'], 0, 2) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="font-medium text-neutral-900">{{ $friend['name'] }}</h3>
                        <p class="text-sm text-neutral-500">1 mutual friends</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button variant="outline" size="sm" class="text-neutral-700 border-neutral-200">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Chat
                        </div>
                    </flux:button>

                    <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}">
                        <flux:button variant="primary" size="sm" class="bg-sky-500 hover:bg-sky-600">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Kolaborasi
                            </div>
                        </flux:button>
                    </flux:modal.trigger>
                </div>

                <flux:modal name="create-collaboration-{{ $friend['id'] }}" variant="flyout">
                    <livewire:collaborations.new-collaboration :friend-id="$friend['id']" />
                </flux:modal>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 mb-1">Belum Ada Koneksi</h3>
                <p class="text-neutral-500 max-w-sm mx-auto">Mulai terhubung dengan kreator perubahan lainnya untuk berkolaborasi dan menciptakan dampak yang lebih besar.</p>
            </div>
        @endforelse
    </div>
</section>
