<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="halo-shell d-lg-flex">
        @include('layouts.navigation')
        <div class="flex-grow-1 min-w-0">
            @isset($header)
                <header class="halo-topbar px-3 px-lg-4 py-3">{{ $header }}</header>
            @endisset
            <main>{{ $slot }}</main>
            <div class="toast-container halo-notification-container position-fixed top-0 end-0 p-3 p-lg-4"
                data-live-notifications data-feed-url="{{ route('notifications.feed', absolute: false) }}"
                data-read-url="/notifications" aria-live="polite" aria-atomic="true"></div>
        </div>
    </div>
</body>

</html>
