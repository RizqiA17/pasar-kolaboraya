<div class="space-y-6">
    {{-- Mutual Friends Recommendations --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Orang yang Mungkin Anda Kenal</h3>
                    <p class="text-sm text-gray-500">Berdasarkan teman yang sama</p>
                </div>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($mutualFriendsRecommendations as $user)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-200">
                        {{-- Cover Image --}}
                        <div class="h-24 bg-gradient-to-r from-blue-100 to-purple-100"></div>
                        
                        {{-- Profile Content --}}
                        <div class="p-4">
                            {{-- Avatar --}}
                            <div class="relative -mt-12 mb-3">
                                <div class="w-20 h-20 mx-auto rounded-full ring-4 ring-white bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl font-semibold shadow-md">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="text-center mb-4">
                                <h4 class="font-medium text-gray-900 hover:text-blue-600 cursor-pointer">
                                    {{ $user->name }}
                                </h4>
                                <div class="mt-1 flex items-center justify-center gap-1 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span>{{ $user->connections_count }} teman yang sama</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="space-y-2">
                                <button wire:click="connect({{ $user->id }})" 
                                    class="w-full py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Koneksi
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Rekomendasi</h3>
                        <p class="text-gray-500 max-w-sm mx-auto">
                            Mulai terhubung dengan lebih banyak kreator untuk mendapatkan rekomendasi yang lebih baik.
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
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($interestRecommendations as $user)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-200">
                        {{-- Cover Image --}}
                        <div class="h-24 bg-gradient-to-r from-green-100 to-teal-100"></div>
                        
                        {{-- Profile Content --}}
                        <div class="p-4">
                            {{-- Avatar --}}
                            <div class="relative -mt-12 mb-3">
                                <div class="w-20 h-20 mx-auto rounded-full ring-4 ring-white bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white text-xl font-semibold shadow-md">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="text-center mb-4">
                                <h4 class="font-medium text-gray-900 hover:text-blue-600 cursor-pointer">
                                    {{ $user->name }}
                                </h4>
                                <div class="mt-1 flex items-center justify-center gap-1 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $user->interests_count }} minat yang sama</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="space-y-2">
                                <button wire:click="connect({{ $user->id }})" 
                                    class="w-full py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Koneksi
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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

    {{-- Skill-based Recommendations --}}
    <div class="bg-white rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Berdasarkan Keahlian yang Sama</h3>
            <p class="text-sm text-gray-600">Kreator dengan keahlian serupa yang bisa diajak berkolaborasi</p>
        </div>
        <div class="p-4">
            <div class="grid gap-4">
                @forelse($skillRecommendations as $user)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white font-medium text-lg">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $user->skills_count }} keahlian yang sama</p>
                            </div>
                        </div>
                        <button wire:click="connect({{ $user->id }})" class="px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            Hubungkan
                        </button>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">Belum ada rekomendasi berdasarkan keahlian</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Event-based Recommendations --}}
    <div class="bg-white rounded-lg overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Dari Event yang Sama</h3>
            <p class="text-sm text-gray-600">Kreator yang pernah mengikuti event yang sama dengan Anda</p>
        </div>
        <div class="p-4">
            <div class="grid gap-4">
                @forelse($eventRecommendations as $user)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-medium text-lg">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $user->events_count }} event yang sama</p>
                            </div>
                        </div>
                        <button wire:click="connect({{ $user->id }})" class="px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            Hubungkan
                        </button>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">Belum ada rekomendasi dari event yang sama</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>