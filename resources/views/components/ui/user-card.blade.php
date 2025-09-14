    @props([
    'user' => null,
    'showBanner' => true,
    'showAvatar' => true,
    'avatarSize' => 'lg',
    'bannerHeight' => 'h-24',
    'showStats' => false,
    'showActions' => false,
    'actions' => [],
    'class' => ''
])

@if($user)
<div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden {{ $class }}">
    @if($showBanner)
        <x-ui.banner :user="$user" :height="$bannerHeight" />
    @endif
    
    <div class="p-6">
        @if($showAvatar)
            <div class="flex items-center justify-center -mt-16 mb-4">
                <x-ui.avatar :user="$user" :size="$avatarSize" :showStatus="true" />
            </div>
        @endif
        
        <!-- User Info -->
        <div class="text-center mb-6">
            <h4 class="text-xl font-semibold text-gray-900 mb-1">{{ $user->name }}</h4>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            
            @if($user->profile?->organization)
                <div class="flex items-center justify-center gap-2 mt-2 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-sm">{{ $user->profile->organization }}</span>
                </div>
            @endif
        </div>
        
        @if($showStats)
            <!-- Stats -->
            <div class="flex items-center justify-center gap-4 text-gray-600 text-sm mb-6">
                <div class="text-center">
                    <div class="font-semibold">{{ $user->connections()->count() }}</div>
                    <div>Koneksi</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold">{{ $user->collaborations()->count() }}</div>
                    <div>Kolaborasi</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold">{{ $user->events()->count() }}</div>
                    <div>Event</div>
                </div>
            </div>
        @endif
        
        @if($showActions && !empty($actions))
            <!-- Actions -->
            <div class="space-y-2">
                @foreach($actions as $action)
                    <button 
                        type="button"
                        class="w-full py-2 px-4 {{ $action['class'] ?? 'bg-blue-600 hover:bg-blue-700 text-white' }} text-sm font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                        wire:click="{{ $action['action'] }}"
                    >
                        @if(isset($action['icon']))
                            {!! $action['icon'] !!}
                        @endif
                        {{ $action['label'] }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endif
