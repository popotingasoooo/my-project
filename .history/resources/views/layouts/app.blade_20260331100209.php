<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/recycle-bin.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.18),_transparent_0,_transparent_35%),radial-gradient(circle_at_top_right,_rgba(16,185,129,0.14),_transparent_0,_transparent_30%),linear-gradient(to_bottom,_#f8fbff,_#f1f5f9)]">
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-r from-sky-500 via-cyan-400 to-emerald-400 opacity-10 blur-3xl"></div>

            @include('layouts.navigation')

            @isset($header)
                <header class="pt-6 sm:pt-8">
                    <div class="page-shell">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="pb-10 pt-6">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
