{{-- SVG Accent Component for Specific Page Sections --}}
@props(['position' => 'top-right', 'size' => 'w-24 h-24', 'opacity' => 'opacity-30'])

@php
    $positionClasses = match($position) {
        'top-left' => 'absolute top-0 left-0',
        'top-right' => 'absolute top-0 right-0',
        'bottom-left' => 'absolute bottom-0 left-0',
        'bottom-right' => 'absolute bottom-0 right-0',
        'center-left' => 'absolute top-1/2 left-0 transform -translate-y-1/2',
        'center-right' => 'absolute top-1/2 right-0 transform -translate-y-1/2',
        'center-top' => 'absolute top-0 left-1/2 transform -translate-x-1/2',
        'center-bottom' => 'absolute bottom-0 left-1/2 transform -translate-x-1/2',
        default => 'absolute top-0 right-0'
    };
@endphp

<div class="{{ $positionClasses }} {{ $size }} {{ $opacity }} pointer-events-none">
    @switch($position)
        @case('top-left')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/1.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('top-right')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/7.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('bottom-left')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/5.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('bottom-right')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/11.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('center-left')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/4.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('center-right')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/10.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('center-top')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/13.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @case('center-bottom')
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/14.svg') }}" alt="" class="w-full h-full object-contain">
            @break
        @default
            <img src="{{ Storage::url('web/ASET VISUAL/SVG/7.svg') }}" alt="" class="w-full h-full object-contain">
    @endswitch
</div>
