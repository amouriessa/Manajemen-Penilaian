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

    <link
        href="https://fonts.googleapis.com/css2?
        family=Poppins:wght@400;500;600;700&
        family=Koulen&family=Manrope:wght@200..800&
        family=Cormorant:ital,wght@0,300..700;1,300..700&
        display=swap"
        rel="stylesheet">

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="overflow-hidden font-sans antialiased bg-[#E8E0D5]">

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
                class="flex items-center justify-between px-4 py-3 bg-[#FDFAF5] border-b md:hidden">

                <!-- LEFT: Sidebar Toggle + Greeting -->
                <div class="flex items-center gap-3">

                    @if (!empty($sidebar))
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 text-gray-700 rounded-md hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @endif

                    <div class="flex flex-col">
                        <p class="text-xs text-[#3A3028] leading-none">
                            Halo 👋
                        </p>
                        <p class="text-base font-semibold text-gray-900 truncate max-w-[120px]">
                            {{ Auth::user()->name }}
                        </p>
                    </div>
                </div>

                <!-- RIGHT: Avatar + Dropdown -->
                <div class="flex items-center gap-2">

                    <!-- Date small -->
                    <div class="hidden sm:block text-[10px] text-[#8C8070]">
                        {{ now()->translatedFormat('j M Y') }}
                    </div>

                    <x-dropdown align="right" width="40">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 focus:outline-none">

                                <!-- Avatar -->
                                <div class="w-9 h-9">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                            class="object-cover w-full h-full rounded-full">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-full h-full
                                            text-xs font-semibold text-white
                                            rounded-full bg-[#2D3F63]">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @unless (Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @endunless
                            <div class="px-4 py-2 border-b">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'User') }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    class="text-sm font-medium text-gray-900"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Logout') }}
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
            <main class="flex-1 px-4 py-6 overflow-y-auto sm:px-6 lg:px-8 overscroll-contain">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
    @stack('styles')
</body>

</html>
