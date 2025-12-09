<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header with actions -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Semua Notifikasi</h3>
                        <div class="flex space-x-2">
                            <button onclick="markAllAsRead()" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Tandai Semua Dibaca
                            </button>
                            <button onclick="deleteAllRead()" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                Hapus Semua yang Dibaca
                            </button>
                        </div>
                    </div>

                    <!-- Notifications list -->
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 
                            {{ $notification->is_read ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-slate-900 shadow-lg dark:border-t! dark:border-slate-700 border-l-4 border-l-blue-500' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                @if(!$notification->is_read)
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                @endif
                                                <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $notification->title ?? 'Notifikasi' }}
                                                </h4>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $notification->message }}
                                            </p>
                                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                                                {{ $notification->time_ago }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            @if($notification->redirect_url)
                                                <a href="{{ route('notifications.show', $notification) }}" 
                                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors">
                                                    Lihat
                                                </a>
                                            @endif
                                            @if(!$notification->is_read)
                                                <button onclick="markAsRead('{{ $notification->id }}')" 
                                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition-colors">
                                                    Tandai Dibaca
                                                </button>
                                            @endif
                                            <button onclick="deleteNotification('{{ $notification->id }}')" 
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition-colors">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 0 0-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 0 1 15 0v5z" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada notifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum memiliki notifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteNotification(notificationId) {
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function deleteAllRead() {
            if (confirm('Apakah Anda yakin ingin menghapus semua notifikasi yang sudah dibaca?')) {
                fetch('/notifications/read/all', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</x-layouts.app>
