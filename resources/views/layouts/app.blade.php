<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    <style>
        .pagination svg {
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            gap: 0.3rem;
        }
    </style>


</head>

<body>
    <div id="app">
        @include('layouts.navbar')
        <div class="mt-4"></div>
        <main class="py-4 mt-lg-7">
            <div class="mt-4"></div>
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>
    @stack('scripts')




</body>

</html>
