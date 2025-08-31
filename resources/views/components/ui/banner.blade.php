@props([
    'user' => null,
    'height' => 'h-40',
    'class' => '',
    'showOverlay' => false,
    'overlayContent' => null
])

<div class="relative {{ $height }} w-full overflow-hidden {{ $class }}">
    @if($user && $user->profile?->banner)
        <img 
            src="{{ asset('storage/' . $user->profile->banner) }}" 
            alt="{{ $user->name }}'s banner"
            class="w-full h-full object-cover"
        >
    @else
        <div class="w-full h-full bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600 flex items-center justify-center">
            <div class="text-center text-white">
                <svg class="mx-auto h-12 w-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <p class="text-sm font-medium opacity-75">Belum ada banner</p>
            </div>
        </div>
    @endif
    
    @if($showOverlay && $overlayContent)
        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
            {{ $overlayContent }}
        </div>
    @endif
</div>
