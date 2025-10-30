<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pasar Kolaboraya') }}</title>

    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);

        $legacyJs = $manifest['resources/js/app-legacy.js']['file'] ?? null;
        $legacyCss = $manifest['resources/css/app-legacy.css']['file'] ?? null;
    @endphp

    @if ($legacyCss)
        <link rel="stylesheet" href="{{ asset('build/' . $legacyCss) }}">
    @endif

    @if ($legacyJs)
        <script nomodule src="{{ asset('build/' . $legacyJs) }}"></script>
    @endif

</head>

<body
    class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">

    {{-- Decorative SVG Elements --}}
    {{-- <x-decorative-svgs /> --}}

    {{ $slot }}
</body>

</html>
