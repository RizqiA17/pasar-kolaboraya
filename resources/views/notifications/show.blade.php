<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Back button -->
                    <div class="mb-6">
                        <a href="{{ route('notifications.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Notifikasi
                        </a>
                    </div>

                    <!-- Notification details -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if(!$notification->is_read)
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    @endif
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $notification->title ?? 'Notifikasi' }}
                                    </h1>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-500">
                                    {{ $notification->created_at->format('d M Y, H:i') }} 
                                    ({{ $notification->time_ago }})
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if(!$notification->is_read)
                                    <button onclick="markAsRead()" 
                                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                        Tandai Dibaca
                                    </button>
                                @endif
                                <button onclick="deleteNotification()" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $notification->message }}
                            </p>
                        </div>

                        @if($notification->redirect_url)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ $notification->redirect_url }}" 
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Buka Halaman Terkait
                                </a>
                            </div>
                        @endif

                        @if($notification->data && count($notification->data) > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">
                                    Data Tambahan
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4">
                                    <pre class="text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAsRead() {
            fetch(`/notifications/{{ $notification->id }}/mark-read`, {
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

        function deleteNotification() {
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                fetch(`/notifications/{{ $notification->id }}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("notifications.index") }}';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</x-layouts.app>
