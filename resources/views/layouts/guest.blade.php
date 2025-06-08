<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cube Billiard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-col min-h-screen text-gray-900">
        @php
            $excludedRoutes = ['login', 'register', 'password.request', 'password.reset'];
        @endphp

        @if (!in_array(Route::currentRouteName(), $excludedRoutes))
            @include('layouts.user-navigation')
        @endif

        {{ $slot }}

        @if (!in_array(Route::currentRouteName(), $excludedRoutes))
            <x-user.footer></x-user.footer>
        @endif
    </div>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script>
        window.flashMessage = @json(session('success') ?? null);
    </script>

    @stack('scripts')
</body>

</html>
