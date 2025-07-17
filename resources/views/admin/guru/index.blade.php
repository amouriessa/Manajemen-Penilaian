<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-admin />
        </x-slot>
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header title="Data Guru" subtitle="Mengelola informasi dan seluruh data guru" :route="route('admin.guru.create')"
                    buttonText="Tambah Guru" />

                <x-flash-message />

                <x-search-filter-admin action="{{ route('admin.guru.index') }}" :search="request('search')" :sortOptions="[
                    'name_asc' => 'Nama (A-Z)',
                    'name_desc' => 'Nama (Z-A)',
                    'newest' => 'Terbaru',
                    'oldest' => 'Terlama',
                ]" />

                <!-- Data Card -->
                <div class="overflow-hidden bg-white rounded-lg shadow-md">


                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
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
                                        NIP
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Kontak
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
                                @forelse ($teachers as $teacher)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    @if ($teacher->user->avatar)
                                                        @php
                                                            $avatarUrl = URL::signedRoute('admin.avatar.show', [
                                                                'path' => $teacher->user->avatar,
                                                            ]);
                                                        @endphp
                                                        <img class="object-cover w-10 h-10 rounded-full"
                                                            src="{{ $avatarUrl }}" alt="{{ $teacher->user->name }}">
                                                    @else
                                                        <div
                                                            class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-full dark:bg-indigo-900">
                                                            <span
                                                                class="text-sm font-medium text-indigo-800 dark:text-indigo-200">
                                                                {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $teacher->user->name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $teacher->user->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $teacher->nip ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                +62{{ $teacher->nomor_telp ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center align-middle whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                            {{ $teacher->status ? 'text-green-800 bg-green-100 dark:text-green-200 dark:bg-green-900' : 'text-red-800 bg-red-100 dark:text-red-200 dark:bg-red-900' }}">
                                                {{ $teacher->status_label }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm font-medium text-center text-gray-900 dark:text-white whitespace-nowrap">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.guru.show', $teacher) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                <a href="{{ route('admin.guru.edit', $teacher) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button onclick="confirmDelete('{{ $teacher->id }}')" type="button"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                                <form id="delete-form-{{ $teacher->id }}"
                                                    action="{{ route('admin.guru.destroy', $teacher) }}" method="POST"
                                                    class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center p-6 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak
                                                    ada data guru</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    @if (request('search'))
                                                        Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                                    @else
                                                        Belum ada data guru yang ditambahkan ke dalam sistem
                                                    @endif
                                                </p>
                                                <div class="mt-6">
                                                    <a href="{{ route('admin.guru.create') }}"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg class="w-5 h-5 mr-2 -ml-1"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        Tambahkan Guru
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <!-- Info halaman dan total data -->
                            <div class="flex flex-col items-center gap-2 text-sm text-gray-700 sm:flex-row">
                                <span>
                                    Menampilkan
                                    <span class="font-medium">{{ $teachers->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span class="font-medium">{{ $teachers->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium">{{ $teachers->total() }}</span>
                                    hasil
                                </span>
                                <span class="hidden text-gray-400 sm:inline">•</span>
                                <span>
                                    Halaman
                                    <span class="font-medium">{{ $teachers->currentPage() }}</span>
                                    dari
                                    <span class="font-medium">{{ $teachers->lastPage() }}</span>
                                </span>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex items-center space-x-2">
                                @if ($teachers->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </span>
                                @else
                                    <a href="{{ $teachers->previousPageUrl() }}"
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
                                    @foreach ($teachers->getUrlRange(max(1, $teachers->currentPage() - 2), min($teachers->lastPage(), $teachers->currentPage() + 2)) as $page => $url)
                                        @if ($page == $teachers->currentPage())
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

                                @if ($teachers->hasMorePages())
                                    <a href="{{ $teachers->nextPageUrl() }}"
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
                                @for ($i = 1; $i <= $teachers->lastPage(); $i++)
                                    <option value="{{ $teachers->url($i) }}"
                                        {{ $i == $teachers->currentPage() ? 'selected' : '' }}>
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
    <x-delete-modal title="Konfirmasi Hapus"
        description="Apakah Anda yakin ingin menghapus data guru ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait guru tersebut." />
</x-app-layout>
