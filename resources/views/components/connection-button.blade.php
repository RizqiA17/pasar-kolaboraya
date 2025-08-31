@props(['userId', 'size' => 'default'])

@php
    $connectionStatus = auth()->user()->getConnectionStatus($userId);
    
    $sizeClasses = [
        'small' => 'px-3 py-1.5 text-xs',
        'default' => 'px-4 py-2 text-sm',
        'large' => 'px-6 py-3 text-base'
    ];
    
    $buttonClasses = $sizeClasses[$size] ?? $sizeClasses['default'];
@endphp

<div id="connection-button-{{ $userId }}" data-user-id="{{ $userId }}" data-status="{{ $connectionStatus }}" class="relative">
    {{-- Decorative SVG Elements --}}
    <x-decorative-svgs-subtle />
    
    @if($connectionStatus === 'not_connected')
        <button wire:click="connect({{ $userId }})" onclick="updateButtonAfterConnect({{ $userId }})"
            class="{{ $buttonClasses }} font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
            {{ $size === 'small' ? 'Hubungkan' : 'Tambah Koneksi' }}
        </button>
    @elseif($connectionStatus === 'pending_sent')
        <span class="{{ $buttonClasses }} font-medium text-gray-500 cursor-not-allowed">
            Menunggu Konfirmasi
        </span>
    @elseif($connectionStatus === 'pending_received')
        <div class="flex gap-2">
            <button wire:click="acceptConnection({{ $userId }})" onclick="updateButtonAfterAccept({{ $userId }})"
                class="{{ $size === 'small' ? 'px-2 py-1 text-xs' : 'px-3 py-2 text-sm' }} font-medium text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                Terima
            </button>
            <button wire:click="rejectConnection({{ $userId }})" onclick="updateButtonAfterReject({{ $userId }})"
                class="{{ $size === 'small' ? 'px-2 py-1 text-xs' : 'px-3 py-2 text-sm' }} font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                Tolak
            </button>
        </div>
    @elseif($connectionStatus === 'connected')
        <div class="flex gap-2">
            <button wire:click="startCollaboration({{ $userId }})"
                class="{{ $buttonClasses }} font-medium text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                Kolaborasi
            </button>
            <button wire:click="disconnect({{ $userId }})" onclick="updateButtonAfterDisconnect({{ $userId }})"
                class="{{ $buttonClasses }} font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                Putuskan
            </button>
        </div>
    @endif
</div>
