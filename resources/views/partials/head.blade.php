<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
<title>{{ 'Kolaboraya - ' . ($title ?? '') }}</title>

<link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script nomodule src="{{ asset('build/legacy.js') }}"></script>
<link rel="stylesheet" href="{{ asset('build/legacy.css') }}">

@fluxAppearance
