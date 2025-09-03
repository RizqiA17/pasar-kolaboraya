@php
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
@endphp

<section class="space-y-4 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-14 h-14" opacity="opacity-10" />

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
        @if (!empty($searchResults))
            @forelse ($searchResults as $friend)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 relative"
                    data-user-id="{{ $friend['id'] }}">
                    <!-- SVG Accent for Connection Card -->
                    <x-svg-accent position="top-right" size="w-6 h-6" opacity="opacity-5" />
                    
                    {{-- Cover Image --}}
                    <x-ui.banner :user="App\Models\User::find($friend['id'])" height="h-24" class="rounded-t-xl" />

                    {{-- Profile Content --}}
                    <div class="p-4">
                        {{-- Avatar --}}
                        <div class="relative -mt-12 mb-3">
                            <x-ui.avatar :user="App\Models\User::find($friend['id'])" size="xl" class="ring-4 rounded-full ring-white" />
                        </div>

                        <div class="flex flex-col items-center text-center">

                            <h3 class="text-xl font-semibold text-gray-900 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                wire:click="$dispatch('showProfileCard', { userId: {{ $friend['id'] }} })">
                                {{ $friend['name'] }}
                            </h3>

                            <a href="{{ route('profile.view', $friend['id']) }}"
                                class="text-sm text-blue-600 hover:text-blue-800 transition-colors mb-4">
                                Lihat Profile Lengkap
                            </a>

                            <div class="flex items-center justify-center gap-4 text-gray-600 text-sm mb-6">
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['connections_count'] }}</div>
                                    <div>Koneksi</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['collaborations_count'] }}</div>
                                    <div>Kolaborasi</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['events_count'] }}</div>
                                    <div>Organisasi</div>
                                </div>
                            </div>

                            <div class="flex items-center flex-wrap gap-3 w-full">
                                @if($collaborationsEnabled || $isSuperAdmin)
                                    <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                        <flux:button variant="primary" size="sm" icon="plus"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <span class="font-medium">Buat Kolaborasi</span>
                                            </div>
                                        </flux:button>
                                    </flux:modal.trigger>
                                @else
                                    <button disabled
                                        class="flex-1 px-3 py-2 w-full bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-1.5">
                                        <span class="font-medium">Kolaborasi Dinonaktifkan</span>
                                    </button>
                                @endif

                                @if($connectionsEnabled || $isSuperAdmin)
                                    <button onclick="handleDisconnectWithValidation({{ $friend['id'] }})"
                                        class="px-4 py-2 w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Putuskan
                                    </button>
                                @else
                                    <button disabled
                                        class="px-4 py-2 w-full bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Fitur Dinonaktifkan
                                    </button>
                                @endif
                            </div>
                    </div>

                    <flux:modal name="create-collaboration-{{ $friend['id'] }}" variant="flyout">
                        <livewire:collaborations.new-collaboration :friend-id="$friend['id']" />
                    </flux:modal>
                </div>
            @empty
                <div class="col-span-full text-center py-12 px-4">
                    <div
                        class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-50 to-purple-50 border-2 border-blue-100/50 flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Hasil yang Cocok</h3>
                    <p class="text-gray-600 max-w-sm mx-auto leading-relaxed">
                        Coba ganti pencarian Anda.
                    </p>
                </div>
            @endforelse
        @else
            @forelse ($friends as $friend)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 relative"
                    data-user-id="{{ $friend['id'] }}">
                    <!-- SVG Accent for Connection Card -->
                    <x-svg-accent position="top-right" size="w-6 h-6" opacity="opacity-5" />
                    
                    {{-- Cover Image --}}
                    <x-ui.banner :user="App\Models\User::find($friend['id'])" height="h-24" class="rounded-t-xl" />

                    {{-- Profile Content --}}
                    <div class="p-4">
                        {{-- Avatar --}}
                        <div class="relative -mt-12 mb-3">
                            <x-ui.avatar :user="App\Models\User::find($friend['id'])" size="xl" class="ring-4 rounded-full ring-white" />
                        </div>

                        <div class="flex flex-col items-center text-center">

                            <h3 class="text-xl font-semibold text-gray-900 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                wire:click="$dispatch('showProfileCard', { userId: {{ $friend['id'] }} })">
                                {{ $friend['name'] }}</h3>

                            <a href="{{ route('profile.view', $friend['id']) }}"
                                class="text-sm text-blue-600 hover:text-blue-800 transition-colors mb-4">
                                Lihat Profile Lengkap
                            </a>

                            <div class="flex items-center justify-center gap-4 text-gray-600 text-sm mb-6">
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['connections_count'] }}</div>
                                    <div>Koneksi</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['collaborations_count'] }}</div>
                                    <div>Kolaborasi</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">{{ $friend['events_count'] }}</div>
                                    <div>Organisasi</div>
                                </div>
                            </div>

                            <div class="flex items-center flex-wrap gap-3 w-full">
                                @if($collaborationsEnabled || $isSuperAdmin)
                                    <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                        <flux:button variant="primary" size="sm" icon="plus"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <span class="font-medium">Buat Kolaborasi</span>
                                            </div>
                                        </flux:button>
                                    </flux:modal.trigger>
                                @else
                                    <button disabled
                                        class="flex-1 px-3 py-2 w-full bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-1.5">
                                        <span class="font-medium">Kolaborasi Dinonaktifkan</span>
                                    </button>
                                @endif

                                @if($connectionsEnabled || $isSuperAdmin)
                                    <button onclick="handleDisconnectWithValidation({{ $friend['id'] }})"
                                        class="px-4 py-2 w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Putuskan
                                    </button>
                                @else
                                    <button disabled
                                        class="px-4 py-2 w-full bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Fitur Dinonaktifkan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <flux:modal name="create-collaboration-{{ $friend['id'] }}" variant="flyout">
                        <livewire:collaborations.new-collaboration :friend-id="$friend['id']" />
                    </flux:modal>
                </div>
            @empty
                <div class="col-span-full text-center py-12 px-4">
                    <div
                        class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-50 to-purple-50 border-2 border-blue-100/50 flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Koneksi</h3>
                    <p class="text-gray-600 max-w-sm mx-auto leading-relaxed">
                        Mulai terhubung dengan pengguna lain untuk membangun jaringan kolaborasi Anda.
                    </p>
                </div>
            @endforelse
    </div>
    @endif
</section>

<script>
    // Function untuk putuskan koneksi dengan validasi dan animasi hilang (untuk list connection)
    function handleDisconnectWithValidation(userId) {
        // Tampilkan konfirmasi
        if (confirm('Apakah Anda yakin ingin memutuskan koneksi dengan user ini?')) {
            // Cari card koneksi dan hilangkan dengan animasi
            const connectionCard = document.querySelector(`[data-user-id="${userId}"]`);
            if (connectionCard) {
                // Tambahkan class untuk animasi
                connectionCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                connectionCard.style.transform = 'scale(0.8) translateY(20px)';
                connectionCard.style.opacity = '0';
                connectionCard.style.filter = 'blur(2px)';

                // Hilangkan card setelah animasi selesai
                setTimeout(() => {
                    connectionCard.remove();

                    // Tampilkan notifikasi sukses
                    showNotification('Koneksi berhasil diputuskan', 'success');
                }, 400);
            }

            // Panggil method Livewire untuk disconnect
            @this.call('disconnect', userId);
        }
    }

    // Function untuk menampilkan notifikasi
    function showNotification(message, type = 'info') {
        // Hapus notifikasi yang sudah ada
        const existingNotification = document.querySelector('.notification-toast');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Buat notifikasi baru
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        // Set warna berdasarkan type
        switch (type) {
            case 'success':
                notification.className += ' bg-green-500 text-white';
                break;
            case 'error':
                notification.className += ' bg-red-500 text-white';
                break;
            case 'warning':
                notification.className += ' bg-yellow-500 text-white';
                break;
            default:
                notification.className += ' bg-blue-500 text-white';
        }

        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    ${type === 'success' ? 
                        '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' :
                        '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
                    }
                </div>
                <div class="flex-1">
                    <p class="font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-2 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;

        // Tambahkan ke body
        document.body.appendChild(notification);

        // Animasikan masuk
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove setelah 5 detik
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
</script>
