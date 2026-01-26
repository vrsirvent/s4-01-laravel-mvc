<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Mono:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/">
                    <div class="text-center">
                        <h1 class="auth-logo-title">
                            JUKEBOX
                        </h1>
                        <p class="auth-logo-subtitle">
                            Retro Music Collection
                        </p>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 auth-container">
                {{ $slot }}
            </div>

            <div class="mt-6 text-center">
                <p class="auth-footer-text">
                    © 2024 Jukebox App | All rights reserved
                </p>
            </div>
        </div>
    </body>
</html>
