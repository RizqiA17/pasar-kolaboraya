<div class="relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-20 h-20" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-14 h-14" opacity="opacity-10" />
    
    <div class="space-y-6">
        {{-- {{ json_encode($searchResults) }} --}}
        @if (!empty($searchResults))
            <div class="bg-white rounded-xl shadow-sm overflow-hidden relative">
                <!-- SVG Accent for Search Results -->
                <x-svg-accent position="top-right" size="w-10 h-10" opacity="opacity-5" />
                
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Hasil Pencarian Anda</h3>
                            <p class="text-sm text-gray-500">Kreator yang cocok dengan pencarian Anda</p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                        @forelse($searchResults as $user)
                            <div
                                class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-200 relative">
                                <!-- SVG Accent for User Card -->
                                <x-svg-accent position="top-right" size="w-6 h-6" opacity="opacity-5" />
                                
                                {{-- Cover Image --}}
                                <div class="h-24 bg-gradient-to-r from-green-100 to-teal-100"></div>

                                {{-- Profile Content --}}
                                <div class="p-4">
                                    {{-- Avatar --}}
                                    <div class="relative -mt-12 mb-3">
                                        <div
                                            class="w-20 h-20 mx-auto rounded-full ring-4 ring-white bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white text-xl font-semibold shadow-md">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="text-center mb-4">
                                        <h4 class="font-medium text-gray-900 hover:text-blue-600 cursor-pointer"
                                            wire:click="$dispatch('showProfileCard', { userId: {{ $user->id }} })">
                                            {{ $user->name }}
                                        </h4>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="space-y-2">
                                        <x-connection-card-button :userId="$user->id" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak Ada Kreator yang Cocok</h3>
                                <p class="text-gray-500 max-w-sm mx-auto">
                                    Coba ganti pencarian Anda.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            {{-- Mutual Friends Recommendations --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden relative">
                <!-- SVG Accent for Mutual Friends -->
                <x-svg-accent position="top-right" size="w-10 h-10" opacity="opacity-5" />
                
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Kreator yang Mungkin Anda Kenal</h3>
                            <p class="text-sm text-gray-500">Berdasarkan koneksi yang sama</p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @forelse($mutualFriendsRecommendations as $user)
                            <div
                                class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-200 relative">
                                <!-- SVG Accent for User Card -->
                                <x-svg-accent position="top-right" size="w-6 h-6" opacity="opacity-5" />
                                
                                {{-- Cover Image --}}
                                <div class="h-24 bg-gradient-to-r from-blue-100 to-purple-100"></div>

                                {{-- Profile Content --}}
                                <div class="p-4">
                                    {{-- Avatar --}}
                                    <div class="relative -mt-12 mb-3">
                                        <div
                                            class="w-20 h-20 mx-auto rounded-full ring-4 ring-white bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl font-semibold shadow-md">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="text-center mb-4">
                                        <h4 class="font-medium text-gray-900 hover:text-blue-600 cursor-pointer"
                                            wire:click="$dispatch('showProfileCard', { userId: {{ $user->id }} })">
                                            {{ $user->name }}
                                        </h4>
                                        <div class="mt-1 flex items-center justify-center gap-1 text-sm text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            <span>{{ $user->connections_count }} koneksi yang sama</span>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="space-y-2">
                                        <x-connection-card-button :userId="$user->id" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Rekomendasi</h3>
                                <p class="text-gray-500 max-w-sm mx-auto">
                                    Mulai terhubung dengan lebih banyak kreator untuk mendapatkan rekomendasi yang lebih
                                    baik.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Interest-based Recommendations --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Rekomendasi Berdasarkan Minat</h3>
                            <p class="text-sm text-gray-500">Kreator dengan minat yang serupa</p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                        @forelse($interestRecommendations as $user)
                            <div
                                class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-200">
                                {{-- Cover Image --}}
                                <div class="h-24 bg-gradient-to-r from-green-100 to-teal-100"></div>

                                {{-- Profile Content --}}
                                <div class="p-4">
                                    {{-- Avatar --}}
                                    <div class="relative -mt-12 mb-3">
                                        <div
                                            class="w-20 h-20 mx-auto rounded-full ring-4 ring-white bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white text-xl font-semibold shadow-md">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="text-center mb-4">
                                        <h4 class="font-medium text-gray-900 hover:text-blue-600 cursor-pointer"
                                            wire:click="$dispatch('showProfileCard', { userId: {{ $user->id }} })">
                                            {{ $user->name }}
                                        </h4>
                                        <div class="mt-1 flex items-center justify-center gap-1 text-sm text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $user->interests_count }} minat yang sama</span>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="space-y-2">
                                        <x-connection-card-button :userId="$user->id" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Rekomendasi</h3>
                                <p class="text-gray-500 max-w-sm mx-auto">
                                    Tambahkan minat Anda untuk mendapatkan rekomendasi yang lebih relevan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Rekomendasi Berdasarkan Aksi --}}
            {{-- <div class="bg-white rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Dari Aksi yang Sama</h3>
                    <p class="text-sm text-gray-600">Kreator yang pernah mengikuti aksi yang sama dengan Anda</p>
                </div>
                <div class="p-4">
                    <div class="grid gap-4">
                        @forelse($eventRecommendations as $user)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-medium text-lg">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 cursor-pointer hover:text-blue-600"
                                            wire:click="$dispatch('showProfileCard', { userId: {{ $user->id }} })">
                                            {{ $user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $user->events_count }} aksi yang sama</p>
                                    </div>
                                </div>
                                <x-connection-button :userId="$user->id" size="small" />
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Rekomendasi</h3>
                                <p class="text-gray-500">Belum ada rekomendasi dari aksi yang sama</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div> --}}
        @endif
    </div>
    {{-- Profile Card Popup --}}
    <livewire:profile.profile-card />
</div>


<script>
    // Function untuk update button setelah connect
    function updateButtonAfterConnect(userId) {
        setTimeout(() => {
            const buttonContainer = document.getElementById(`connection-button-${userId}`);
            if (buttonContainer) {
                buttonContainer.innerHTML = `
                    <button disabled class="w-full py-1.5 px-4 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu Konfirmasi
                    </button>
                `;
                buttonContainer.setAttribute('data-status', 'pending_sent');
            }
        }, 100);
    }

    // Function untuk update button setelah accept connection
    function updateButtonAfterAccept(userId) {
        setTimeout(() => {
            const buttonContainer = document.getElementById(`connection-button-${userId}`);
            if (buttonContainer) {
                buttonContainer.innerHTML = `
                    <div class="space-y-2">
                        <button wire:click="startCollaboration(${userId})" class="w-full py-1.5 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Kolaborasi
                        </button>
                        <button wire:click="disconnect(${userId})" onclick="updateButtonAfterDisconnect(${userId})" class="w-full py-1.5 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Putuskan
                        </button>
                    </div>
                `;
                buttonContainer.setAttribute('data-status', 'connected');
            }
        }, 100);
    }

    // Function untuk update button setelah reject connection
    function updateButtonAfterReject(userId) {
        setTimeout(() => {
            const buttonContainer = document.getElementById(`connection-button-${userId}`);
            if (buttonContainer) {
                buttonContainer.innerHTML = `
                    <button wire:click="connect(${userId})" onclick="updateButtonAfterConnect(${userId})" class="w-full py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Koneksi
                    </button>
                `;
                buttonContainer.setAttribute('data-status', 'not_connected');
            }
        }, 100);
    }

    // Function untuk update button setelah disconnect
    function updateButtonAfterDisconnect(userId) {
        setTimeout(() => {
            const buttonContainer = document.getElementById(`connection-button-${userId}`);
            if (buttonContainer) {
                buttonContainer.innerHTML = `
                    <button wire:click="connect(${userId})" onclick="updateButtonAfterConnect(${userId})" class="w-full py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Koneksi
                    </button>
                `;
                buttonContainer.setAttribute('data-status', 'not_connected');
            }
        }, 100);
    }

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
        notification.className =
            `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';

        notification.innerHTML = `
            <div class="flex items-center gap-3 text-white">
                <span class="text-lg font-bold">${icon}</span>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        notification.classList.add(bgColor);
        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove setelah 3 detik
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 3000);
    }
</script>
