<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
<title>{{ 'Kolaboraya - ' . ($title ?? '') }}</title>

<link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@if(file_exists(public_path('build/manifest.json')))
    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
        $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp
    @if($cssFile)
        <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    @endif
    @if($jsFile)
        <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
    @endif
@else
    {{-- Fallback to Vite for development --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif
@fluxAppearance
