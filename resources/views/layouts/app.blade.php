<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }" x-cloak>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tahfidz') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        @if (!empty($sidebar))
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-200 ease-in-out transform bg-white border-r dark:bg-gray-900 dark:border-gray-700 md:translate-x-0 md:static">
                {!! $sidebar !!}
            </aside>
        @endif

        <!-- Overlay (for mobile) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"></div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 w-0">

            <!-- Mobile Navbar -->
            <header
                class="flex items-center justify-between px-4 py-4 bg-white border-b md:hidden dark:bg-gray-800 dark:border-gray-700">
                @if (!empty($sidebar))
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 dark:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                @endif
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
                    </a>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">SMP ISLAMIYAH</h1>
                </div>

                <div class="flex items-center ms-6"> <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @unless (Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @endunless


                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>


            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                @include('layouts.navigation')
            </div>

            <!-- Page Header (optional) -->
            @isset($header)
                <header class="sticky top-0 z-10 bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content Scrollable -->
            <main class="flex-1 px-4 py-6 overflow-y-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
    @stack('styles')
</body>

</html>
