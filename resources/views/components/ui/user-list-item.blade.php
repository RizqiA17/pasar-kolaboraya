@props([
    'user' => null,
    'avatarSize' => 'md',
    'showAvatar' => true,
    'showEmail' => true,
    'showOrganization' => true,
    'showActions' => false,
    'actions' => [],
    'clickable' => false,
    'onClick' => null,
    'class' => ''
])

@if($user)
<div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-100 hover:border-gray-200 transition-all duration-200 {{ $class }} {{ $clickable ? 'cursor-pointer hover:shadow-sm' : '' }}"
     @if($clickable && $onClick) wire:click="{{ $onClick }}" @endif>
    
    <div class="flex items-center space-x-4">
        @if($showAvatar)
            <x-ui.avatar :user="$user" :size="$avatarSize" />
        @endif
        
        <div class="flex-1 min-w-0">
            <h4 class="text-sm font-medium text-gray-900 truncate">
                {{ $user->name }}
            </h4>
            
            @if($showEmail)
                <p class="text-sm text-gray-500 truncate">
                    {{ $user->email }}
                </p>
            @endif
            
            @if($showOrganization && $user->profile?->organization)
                <p class="text-xs text-gray-400 truncate">
                    {{ $user->profile->organization }}
                </p>
            @endif
        </div>
    </div>
    
    @if($showActions && !empty($actions))
        <div class="flex items-center space-x-2">
            @foreach($actions as $action)
                <button 
                    type="button"
                    class="p-2 {{ $action['class'] ?? 'text-gray-400 hover:text-gray-600' }} rounded-lg hover:bg-gray-100 transition-colors duration-200"
                    wire:click.stop="{{ $action['action'] }}"
                    title="{{ $action['label'] }}"
                >
                    @if(isset($action['icon']))
                        {!! $action['icon'] !!}
                    @endif
                </button>
            @endforeach
        </div>
    @endif
</div>
@endif
