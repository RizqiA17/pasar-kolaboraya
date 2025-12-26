<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    @if ($title)
        {{ 'Kolaboraya - ' . ($title ?? '') }}
    @else
        {{ config('app.name') }}
    @endif
</title>

<link rel="icon" type="image/webp" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

@fluxAppearance

<meta name="csrf-token" content="{{ csrf_token() }}">

@livewireStyles

@livewireScripts
