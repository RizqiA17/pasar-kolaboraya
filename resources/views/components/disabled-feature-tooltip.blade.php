@props([
    'message' => 'Fitur sedang dinonaktifkan oleh administrator',
    'position' => 'top',
    'size' => 'sm'
])

@php
    $positionClasses = [
        'top' => 'bottom-full left-1/2 transform -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 transform -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 transform -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 transform -translate-y-1/2 ml-2'
    ];
    
    $sizeClasses = [
        'sm' => 'text-xs px-2 py-1',
        'md' => 'text-sm px-3 py-2',
        'lg' => 'text-base px-4 py-3'
    ];
    
    $arrowClasses = [
        'top' => 'absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900',
        'bottom' => 'absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900',
        'left' => 'absolute left-full top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-l-4 border-transparent border-l-gray-900',
        'right' => 'absolute right-full top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-r-4 border-transparent border-r-gray-900'
    ];
@endphp

<div class="group relative inline-block" 
     x-data="{ tooltip: false }" 
     @mouseenter="tooltip = true" 
     @mouseleave="tooltip = false">
    
    {{ $slot }}
    
    <!-- Tooltip -->
    <div x-show="tooltip" 
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95" 
         class="absolute {{ $positionClasses[$position] }} {{ $sizeClasses[$size] }} bg-gray-900 text-white rounded-lg shadow-lg whitespace-nowrap z-50">
        {{ $message }}
        <div class="{{ $arrowClasses[$position] }}"></div>
    </div>
</div>
