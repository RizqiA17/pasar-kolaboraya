<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => $title])
</head>

<body class="min-h-screen bg-primary-light-blue block! dark:bg-gray-900/50">

    <component:decorative-svgs-subtle />
    
    <x-navbar />

    <main class="h-[calc(100svh_-_56px)]">
        @yield('content')
    </main>

</body>

</html>
