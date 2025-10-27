{{-- Decorative SVG Elements Component (Optimized for iOS & Android) --}}
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0 opacity-50 select-none" aria-hidden="true">
    @php
        $decorImages = [
            ['top-0 left-0 w-64 h-64', '1-1'],
            ['top-32 left-32 w-48 h-48', '2-1'],
            ['top-64 left-16 w-40 h-40', '3-1'],
            ['top-1/3 left-8 w-32 h-32', '4-1'],
            ['bottom-0 left-0 w-56 h-56', '5-1'],
            ['bottom-32 left-24 w-44 h-44', '6-1'],
            ['top-0 right-0 w-64 h-64', '7-1'],
            ['top-32 right-32 w-48 h-48', '8-1'],
            ['top-64 right-16 w-40 h-40', '9-1'],
            ['top-1/3 right-8 w-32 h-32', '10-1'],
            ['bottom-0 right-0 w-56 h-56', '11-1'],
            ['bottom-32 right-24 w-44 h-44', '12-1'],
            ['top-16 left-1/2 -translate-x-1/2 w-40 h-40', '13-1'],
            ['bottom-16 left-1/2 -translate-x-1/2 w-40 h-40', '14-1'],
        ];
    @endphp

    @foreach ($decorImages as [$position, $file])
        <div class="absolute {{ $position }} transform-gpu">
            <picture>
                {{-- WebP for modern browsers (iOS 16+, Android 9+) --}}
                <source srcset="{{ Storage::url("web/ASET VISUAL/WEBP/{$file}.webp") }}" type="image/webp">
                {{-- JPG fallback for older browsers (Android 6–8, iOS < 14) --}}
                <img 
                    src="{{ Storage::url("web/ASET VISUAL/JPG/{$file}.jpg") }}" 
                    alt="" 
                    loading="lazy" 
                    decoding="async"
                    width="256" 
                    height="256"
                    class="w-full h-full object-contain will-change-transform"
                >
            </picture>
        </div>
    @endforeach
</div>
