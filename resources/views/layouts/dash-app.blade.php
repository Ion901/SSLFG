<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? "Dashboard" }}</title>

        <!-- Fonts -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Scripts -->
        @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-100 flex">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="w-[100%] transition-[margin] duration-500 ease-in-out">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
