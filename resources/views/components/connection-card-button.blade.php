@props(['userId'])

@php
    $connectionStatus = auth()->user()->getConnectionStatus($userId);
@endphp

<div id="connection-button-{{ $userId }}" data-user-id="{{ $userId }}" data-status="{{ $connectionStatus }}">
    @if($connectionStatus === 'not_connected')
        <button wire:click="connect({{ $userId }})" onclick="updateButtonAfterConnect({{ $userId }})"
            class="w-full py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Koneksi
        </button>
    @elseif($connectionStatus === 'pending_sent')
        <button disabled
            class="w-full py-1.5 px-4 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Menunggu Konfirmasi
        </button>
    @elseif($connectionStatus === 'pending_received')
        <div class="space-y-2">
            <button wire:click="acceptConnection({{ $userId }})" onclick="updateButtonAfterAccept({{ $userId }})"
                class="w-full py-1.5 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Terima Koneksi
            </button>
            <button wire:click="rejectConnection({{ $userId }})" onclick="updateButtonAfterReject({{ $userId }})"
                class="w-full py-1.5 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Tolak
            </button>
        </div>
    @elseif($connectionStatus === 'connected')
        <div class="space-y-2">
            <button wire:click="startCollaboration({{ $userId }})"
                class="w-full py-1.5 px-4 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Kolaborasi
            </button>
            <button wire:click="disconnect({{ $userId }})" onclick="updateButtonAfterDisconnect({{ $userId }})"
                class="w-full py-1.5 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Putuskan
            </button>
        </div>
    @endif
</div>
