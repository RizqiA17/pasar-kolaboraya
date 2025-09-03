@php
    $connectionsEnabled = \App\Models\SystemSetting::isConnectionsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
@endphp

<div wire:poll.3s="loadRequests" wire:poll.stop="!pollingState" class="w-full relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-12 h-12" opacity="opacity-10" />
    <x-svg-accent position="bottom-right" size="w-8 h-8" opacity="opacity-10" />
    
    @if ($isContent)
        <div class="p-4 border-b border-neutral-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Permintaan Koneksi</h2>
        </div>
    @else
        <div class="flex items-center justify-between px-3 py-2 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Permintaan Koneksi</h2>
            @if (count($requests) > 0)
                <span
                    class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 rounded-full">
                    {{ count($requests) }}
                </span>
            @endif
        </div>
    @endif

    <div
        class="overflow-y-auto @if($isContent) h-full @else max-h-[280px] @endif scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent">
        @forelse ($requests as $req)
            <div class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150 relative">
                <!-- SVG Accent for Request Item -->
                <x-svg-accent position="top-right" size="w-4 h-4" opacity="opacity-5" />
                
                <div class="p-3 flex items-center gap-3">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        @if ($req['sender']['profile_photo'])
                            <img src="{{ asset('storage/' . $req['sender']['profile_photo']) }}" 
                                 alt="{{ $req['sender']['name'] }}"
                                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-medium shadow-inner border-2 border-gray-200 dark:border-gray-700">
                                {{ $req['sender']['initials'] }}
                            </div>
                        @endif
                    </div>

                    <!-- Konten -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                            {{ $req['sender']['name'] }}
                        </p>
                        @if ($req['sender']['organization'])
                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                {{ $req['sender']['organization'] }}
                            </p>
                        @endif
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                            <span class="flex">Ingin terhubung dengan Anda <p class="max-md:hidden">&nbsp; Pada {{ Carbon\Carbon::parse($req['sender']['created_at'])->diffForHumans() }}</p>
                            </span>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="flex items-center gap-1.5">
                        @if($connectionsEnabled || $isSuperAdmin)
                            <flux:button wire:click="accept({{ $req['id'] }})"
                                class="p-1.5 hover:bg-green-50 text-green-600! rounded-full transition-colors duration-150 hover:shadow-sm"
                                title="Terima"
                                icon:trailing="check">
                                Terima
                            </flux:button>
                            <flux:button wire:click="reject({{ $req['id'] }})"
                                class="p-1.5 hover:bg-red-50 text-red-600! rounded-full transition-colors duration-150 hover:shadow-sm"
                                title="Tolak"
                                icon:trailing="x-mark">
                                Tolak
                            </flux:button>
                        @else
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs text-gray-400 px-2 py-1 bg-gray-100 rounded-full">
                                    Fitur Dinonaktifkan
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">Tidak ada permintaan pertemanan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Semua permintaan koneksi akan muncul di sini</p>
            </div>
        @endforelse
    </div>
</div>
