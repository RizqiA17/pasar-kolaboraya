<section>
    {{-- Connection List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6 bg-cream">
        @if (!empty($searchResults))
            @forelse ($searchResults as $friend)
                <div
                    class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-blue-100 hover:shadow-sm transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium text-2xl shadow-inner mb-4">
                            {{ substr($friend['name'], 0, 2) }}
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $friend['name'] }}</h3>

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

                        <div class="flex items-center gap-3 w-full">
                            <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                <flux:button variant="primary" size="sm"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="font-medium">Kolaborasi</span>
                                    </div>
                                </flux:button>
                            </flux:modal.trigger>
                            
                            <button wire:click="disconnect({{ $friend['id'] }})" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Putuskan
                            </button>
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
                <div
                    class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-blue-100 hover:shadow-sm transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium text-2xl shadow-inner mb-4">
                            {{ substr($friend['name'], 0, 2) }}
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $friend['name'] }}</h3>

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

                        <div class="flex items-center gap-3 w-full">
                            <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                <flux:button variant="primary" size="sm"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="font-medium">Kolaborasi</span>
                                    </div>
                                </flux:button>
                            </flux:modal.trigger>
                            
                            <button wire:click="disconnect({{ $friend['id'] }})" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Putuskan
                            </button>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                    d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Temukan Kreator
                        </a>
                    </div>
                </div>
            @endforelse
        @endif
    </div>
</section>

<script>
    // Function untuk putuskan koneksi dengan validasi dan animasi hilang
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
            return true; // Lanjutkan dengan wire:click
        }
        return false; // Batalkan wire:click
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
        notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
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
