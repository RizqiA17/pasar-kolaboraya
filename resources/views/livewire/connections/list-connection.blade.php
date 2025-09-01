<section class="space-y-4 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-14 h-14" opacity="opacity-10" />

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
        @if (!empty($searchResults))
            @forelse ($searchResults as $friend)
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-blue-100 hover:shadow-sm transition-all duration-200 relative"
                    data-user-id="{{ $friend['id'] }}">
                    <!-- SVG Accent for Connection Card -->
                    <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-5" />

                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4">
                            <x-ui.avatar :user="App\Models\User::find($friend['id'])" size="2xl" />
                        </div>

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

                        <div class="flex items-center gap-3 w-full">
                            <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                <flux:button variant="primary" size="sm" icon="plus"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="font-medium">Buat Kolaborasi</span>
                                    </div>
                                </flux:button>
                            </flux:modal.trigger>

                            <button onclick="handleDisconnectWithValidation({{ $friend['id'] }})"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
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
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-blue-100 hover:shadow-sm transition-all duration-200 relative"
                    data-user-id="{{ $friend['id'] }}">
                    <!-- SVG Accent for Connection Card -->
                    <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-5" />

                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4">
                            <x-ui.avatar :user="App\Models\User::find($friend['id'])" size="2xl" />
                        </div>

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

                        <div class="flex items-center gap-3 w-full">
                            <flux:modal.trigger name="create-collaboration-{{ $friend['id'] }}" class="flex-1">
                                <flux:button variant="primary" size="sm" icon="plus"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all duration-150 px-3 py-2 rounded-lg">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="font-medium">Buat Kolaborasi</span>
                                    </div>
                                </flux:button>
                            </flux:modal.trigger>

                            <button onclick="handleDisconnectWithValidation({{ $friend['id'] }})"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
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
