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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-6 sm:px-6 lg:px-8"
        style="background-image: url('{{ asset('images/bg-sekolah.jpeg') }}'); background-size: cover; background-position: center;">

        <div class="absolute inset-0 min-h-screen bg-black bg-opacity-10 backdrop-blur-md"></div>

        <div
            class="z-10 w-full max-w-sm overflow-hidden bg-white shadow-lg sm:max-w-md dark:bg-gray-800 sm:shadow-xl rounded-xl sm:rounded-2xl">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
