<div>
    @if($showModal && $selectedUser)
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" 
             wire:click="closeModal">
            
            <!-- Modal Content -->
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto relative" 
                 wire:click.stop>
                
                <!-- SVG Accent for Modal -->
                <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-10" />
                
                <!-- Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Profil Pengguna</h3>
                        <button wire:click="closeModal" 
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-6">
                    <!-- Cover Image -->
                    <x-ui.banner :user="$selectedUser" height="h-24" />
                    
                    <!-- Avatar -->
                    <div class="relative -mt-16 mb-4">
                        <x-ui.avatar :user="$selectedUser" size="2xl" class="ring-4 rounded-full ring-white" />
                    </div>

                    <!-- User Info -->
                    <div class="text-center mb-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-1">{{ $selectedUser->name }}</h4>
                        <p class="text-gray-500 text-sm">{{ $selectedUser->email }}</p>
                        
                        @if($selectedUser->profile?->organization)
                            <div class="flex items-center justify-center gap-2 mt-2 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm">{{ $selectedUser->profile->organization }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Skills -->
                    @if($selectedUser->profile?->skills && $selectedUser->profile->skills->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Keahlian</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedUser->profile->skills->take(5) as $skill)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                                @if($selectedUser->profile->skills->count() > 5)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        +{{ $selectedUser->profile->skills->count() - 5 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Interests -->
                    @if($selectedUser->profile?->interests && $selectedUser->profile->interests->count() > 0)
                        <div class="mb-6">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Minat</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedUser->profile->interests->take(5) as $interest)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                        {{ $interest->name }}
                                    </span>
                                @endforeach
                                @if($selectedUser->profile->interests->count() > 5)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        +{{ $selectedUser->profile->interests->count() - 5 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Vision -->
                    @if($selectedUser->profile?->vision)
                        <div class="mb-6">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Visi</h5>
                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                {{ $selectedUser->profile->vision }}
                            </p>
                        </div>
                    @endif

                    <!-- View Full Profile Button -->
                    <div class="border-t border-gray-100 pt-4 mb-4">
                        <a href="{{ route('profile.view', $selectedUser->id) }}" 
                           class="w-full py-3 px-4 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Profile Lengkap
                        </a>
                    </div>

                    <!-- Connection Status & Actions -->
                    <div class="border-t border-gray-100 pt-4">
                        @if($connectionStatus === 'not_connected')
                            <button wire:click="connect({{ $selectedUser->id }})" 
                                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Koneksi
                            </button>
                        @elseif($connectionStatus === 'pending_sent')
                            <button disabled 
                                    class="w-full py-3 px-4 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Konfirmasi
                            </button>
                        @elseif($connectionStatus === 'pending_received')
                            <div class="space-y-2">
                                <button wire:click="acceptConnection({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Terima Permintaan
                                </button>
                                <button wire:click="rejectConnection({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tolak Permintaan
                                </button>
                            </div>
                        @elseif($connectionStatus === 'connected')
                            <div class="space-y-2">
                                <button wire:click="startCollaboration({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Mulai Kolaborasi
                                </button>
                                <button wire:click="disconnect({{ $selectedUser->id }})" 
                                        class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Putuskan Koneksi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
