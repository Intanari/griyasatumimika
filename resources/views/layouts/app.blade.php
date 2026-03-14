<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Griya Satu Mimika') - Donasi Rehabilitasi ODGJ</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @include('components.landing.styles')
    @include('partials.public-web-settings-dynamic')
    @stack('styles')
</head>
<body class="public-layout">
    @include('components.navbar')
    <div class="public-main">
        <div class="public-content">@yield('content')</div>
        @include('components.footer')
    </div>
    @include('components.landing.scripts')
    @stack('scripts')
</body>
</html>

