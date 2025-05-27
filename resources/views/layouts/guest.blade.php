<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cube Billiard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-col min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
        @php
            $excludedRoutes = ['login', 'register', 'password.request', 'password.reset'];
        @endphp

        @if (!in_array(Route::currentRouteName(), $excludedRoutes))
            @include('layouts.user-navigation')
        @endif
        {{ $slot }}
    </div>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    @stack('scripts')
</body>

</html>
