<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-admin />
        </x-slot>
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header title="Kelola User" subtitle="Kelola semua pengguna sistem" :route="route('admin.users.create')"
                    buttonText="Tambah User" />

                <x-flash-message />

                <x-search-filter-admin action="{{ route('admin.users.index') }}" :search="request('search')" :sortOptions="[
                    'name_asc' => 'Nama (A-Z)',
                    'name_desc' => 'Nama (Z-A)',
                    'newest' => 'Terbaru',
                    'oldest' => 'Terlama',
                ]" />

                <!-- User Stats -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('admin.users.index', array_merge(request()->except(['page', 'role']))) }}"
                       class="block p-4 transition duration-150 ease-in-out bg-white border-l-4 border-indigo-500 rounded-lg shadow-sm dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div
                                class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-400 dark:bg-indigo-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $totalUsers ?? $users->total() }}</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', array_merge(request()->except(['page', 'role']), ['role' => 'admin'])) }}"
                       class="block p-4 transition duration-150 ease-in-out bg-white border-l-4 border-indigo-500 rounded-lg shadow-sm dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div
                                class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-400 dark:bg-indigo-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Admin</p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $adminsCount ?? 0 }}</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', array_merge(request()->except(['page', 'role']), ['role' => 'teacher'])) }}"
                       class="block p-4 transition duration-150 ease-in-out bg-white border-l-4 border-yellow-500 rounded-lg shadow-sm dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div
                                class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-400 dark:bg-yellow-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Guru</p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $teachersCount ?? 0 }}</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index', array_merge(request()->except(['page', 'role']), ['role' => 'student'])) }}"
                       class="block p-4 transition duration-150 ease-in-out bg-white border-l-4 border-purple-500 rounded-lg shadow-sm dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div
                                class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-400 dark:bg-purple-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Siswa</p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $studentsCount ?? 0 }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- User Table with Hover Effects -->
                <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                    @if ($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            No.
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Nama Lengkap
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Email
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                            Role
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($users as $user)
                                        <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        @if ($user->avatar)
                                                            @php
                                                                $avatarUrl = URL::signedRoute('admin.avatar.show', [
                                                                    'path' => $user->avatar,
                                                                ]);
                                                            @endphp
                                                            <img class="object-cover w-10 h-10 rounded-full"
                                                                src="{{ $avatarUrl }}" alt="{{ $user->name }}">
                                                        @else
                                                            <div
                                                                class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-full dark:bg-indigo-900">
                                                                <span
                                                                    class="text-sm font-medium text-indigo-800 dark:text-indigo-200">
                                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $user->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center align-middle whitespace-nowrap">
                                                @php
                                                    $role = $user->getRoleNames()->first();
                                                    $bgColor = 'bg-gray-100 text-gray-800';
                                                    $darkBgColor = 'dark:bg-gray-700 dark:text-gray-300';

                                                    $roleDisplay = ucfirst($role ?? 'User');

                                                    if ($role === 'admin') {
                                                        $bgColor = 'bg-indigo-100 text-indigo-800';
                                                        $darkBgColor = 'dark:bg-indigo-900 dark:text-indigo-300';
                                                        $roleDisplay = 'Admin';
                                                    } elseif ($role === 'teacher') {
                                                        $bgColor = 'bg-yellow-100 text-yellow-800';
                                                        $darkBgColor = 'dark:bg-yellow-900 dark:text-yellow-300';
                                                        $roleDisplay = 'Guru';
                                                    } elseif ($role === 'student') {
                                                        $bgColor = 'bg-purple-100 text-purple-800';
                                                        $darkBgColor = 'dark:bg-purple-900 dark:text-purple-300';
                                                        $roleDisplay = 'Siswa';
                                                    }
                                                @endphp

                                                <span
                                                    class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $bgColor }} {{ $darkBgColor }}">
                                                    {{ $roleDisplay }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center align-middle whitespace-nowrap">
                                                @php
                                                    $bgColor = $user->is_logged_in
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                                @endphp
                                                <span
                                                    class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $bgColor }}">
                                                    {{ $user->status }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('admin.users.show', $user) }}"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <button onclick="confirmDelete('{{ $user->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>

                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('admin.users.destroy', $user) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada data user</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                @if (request('search'))
                                    Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                @elseif (request('role'))
                                    Tidak ada user dengan role {{ request('role') }}
                                @else
                                    Belum ada user yang terdaftar dalam sistem
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.users.create') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambahkan User
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- Pagination -->
                    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <!-- Info halaman dan total data -->
                            <div class="flex flex-col items-center gap-2 text-sm text-gray-700 sm:flex-row">
                                <span>
                                    Menampilkan
                                    <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium">{{ $users->total() }}</span>
                                    hasil
                                </span>
                                <span class="hidden text-gray-400 sm:inline">•</span>
                                <span>
                                    Halaman
                                    <span class="font-medium">{{ $users->currentPage() }}</span>
                                    dari
                                    <span class="font-medium">{{ $users->lastPage() }}</span>
                                </span>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex items-center space-x-2">
                                @if ($users->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                <div class="items-center hidden space-x-1 sm:flex">
                                    @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                                        @if ($page == $users->currentPage())
                                            <span
                                                class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 border border-indigo-600 rounded-md">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">

                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">

                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Mobile page selector -->
                        <div class="mt-3 sm:hidden">
                            <select onchange="window.location.href=this.value"
                                class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    <option value="{{ $users->url($i) }}"
                                        {{ $i == $users->currentPage() ? 'selected' : '' }}>
                                        Halaman {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <x-delete-modal title="Hapus User"
        description="Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan dan semua data yang terkait dengan user ini juga akan dihapus." />
</x-app-layout>
