@props([
    'user' => null,
    'size' => 'md',
    'showStatus' => false,
    'statusColor' => 'green',
    'class' => ''
])

@php
    $sizeClasses = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl',
        '2xl' => 'w-20 h-20 text-2xl',
        '3xl' => 'w-24 h-24 text-3xl',
        '4xl' => 'w-32 h-32 text-4xl'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div class="relative {{ $sizeClass }} {{ $class }}">
    @if($user && $user->profile?->profile_photo)
        <img 
            src="{{ asset('storage/' . $user->profile->profile_photo) }}" 
            alt="{{ $user->name }}'s profile photo"
            class="w-full h-full rounded-full object-cover shadow-lg"
        >
    @else
        <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold shadow-lg">
            {{ $user ? $user->initials() : 'U' }}
        </div>
    @endif
    
    @if($showStatus)
        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-{{ $statusColor }}-500 rounded-full border-2 border-white dark:border-slate-900"></div>
    @endif
</div>
