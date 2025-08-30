<div class="p-4">
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifikasi Kolaborasi</h3>
        @if($this->unreadCount > 0)
            <button wire:click="markAllAsRead" 
                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Tandai semua sudah dibaca
            </button>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-2 max-h-64 overflow-y-auto">
            @foreach($notifications as $notification)
                <div class="p-3 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-blue-50 dark:bg-blue-900/20' }} rounded-lg border {{ $notification->read_at ? 'border-gray-200 dark:border-gray-600' : 'border-blue-200 dark:border-blue-600' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm {{ $notification->read_at ? 'text-gray-600 dark:text-gray-400' : 'text-gray-900 dark:text-white' }} font-medium">
                                @if($notification->type === 'App\\Notifications\\CollaborationInvitation')
                                    Undangan Kolaborasi
                                @else
                                    Update Status Kolaborasi
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                {{ $notification->data['message'] ?? 'Notifikasi kolaborasi' }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->read_at)
                            <button wire:click="markAsRead('{{ $notification->id }}')"
                                    class="ml-2 text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                Tandai dibaca
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4">
            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-5 5v-5zM4 19h6a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi kolaborasi</p>
        </div>
    @endif

    @if($this->unreadCount > 0)
        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center justify-center">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $this->unreadCount }} belum dibaca
                </span>
            </div>
        </div>
    @endif
</div>
