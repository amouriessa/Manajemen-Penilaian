<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-guru />
        </x-slot>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <!-- Header Section -->
                <div
                    class="flex flex-col gap-4 p-6 transition-all duration-300 ease-in-out bg-white border-l-4 border-indigo-500 shadow-md fade-in-up rounded-xl dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800 dark:text-white md:text-xl">Penilaian Langsung
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau penilaian hafalan
                            siswa secara langsung</p>
                    </div>
                    <a href="{{ route('teacher.penilaian.langsung.create') }}"
                        class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white transition duration-200 bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:scale-110" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Penilaian
                    </a>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div id="success-alert"
                        class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-md dark:bg-green-900 dark:text-green-100 dark:border-green-600">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                            <div class="pl-3 ml-auto">
                                <div class="-mx-1.5 -my-1.5">
                                    <button onclick="document.getElementById('success-alert').remove()"
                                        class="inline-flex p-1.5 text-green-500 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-alert"
                        class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-md dark:bg-red-900 dark:text-red-100 dark:border-red-600">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                            <div class="pl-3 ml-auto">
                                <div class="-mx-1.5 -my-1.5">
                                    <button onclick="document.getElementById('error-alert').remove()"
                                        class="inline-flex p-1.5 text-red-500 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <!-- Filters and Search Section -->
                <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <!-- Search Form -->
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <form method="GET" action="{{ route('teacher.penilaian.langsung.index') }}"
                                class="relative">
                                <div class="flex items-center">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari data..."
                                        class="w-full py-2.5 pl-10 pr-4 border border-gray-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                    @if (request('search'))
                                        <a href="{{ route('teacher.penilaian.langsung.index') }}"
                                            class="absolute text-xs text-gray-500 right-16 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                            Reset
                                        </a>
                                    @endif
                                    <button type="submit"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-indigo-600 dark:text-indigo-400">
                                        <span class="text-sm font-medium">Cari</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Sorting and Display Options -->
                        <form method="GET" action="{{ route('teacher.penilaian.langsung.index') }}">
                            <div class="flex flex-wrap items-center gap-3">

                                <div class="w-full sm:w-auto">
                                    <select name="filter" onchange="this.form.submit()"
                                        class="text-sm mr-5 block w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        <optgroup label="Urutkan">
                                            <option value="sort:newest"
                                                {{ request('filter') == 'sort:newest' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="sort:oldest"
                                                {{ request('filter') == 'sort:oldest' ? 'selected' : '' }}>Terlama
                                            </option>
                                        </optgroup>

                                        @php
                                            $predikatOptions = [
                                                'mumtaz' => 'Mumtaz',
                                                'jayyid_jiddan' => 'Jayyid Jiddan',
                                                'jiddan' => 'Jiddan',
                                            ];
                                        @endphp

                                        <optgroup label="Predikat">
                                            @foreach ($predikatOptions as $predikat => $predikat_label)
                                                <option value="predikat:{{ $predikat }}"
                                                    @selected(request('predikat') === $predikat)>
                                                    {{ $predikat_label }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                    </select>
                                </div>

                                <!-- Tombol Reset -->
                                @if (request('filter') || request('status'))
                                    <a href="{{ route('teacher.penilaian.langsung.index') }}"
                                        class="inline-flex items-center px-3 py-2.5 text-sm text-gray-500 hover:text-red-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        Reset
                                    </a>
                                @endif

                                <div class="w-full sm:w-auto">
                                    <select name="perPage" id="perPage" onchange="this.form.submit()"
                                        class="text-sm mr-5 block w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10
                                            per halaman</option>
                                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25
                                            per
                                            halaman</option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50
                                            per
                                            halaman</option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>
                                            100
                                            per halaman</option>
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                    <div
                        class="p-6 transition-shadow duration-300 bg-white border-l-4 border-indigo-500 shadow-lg rounded-xl hover:shadow-xl">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-400 dark:bg-indigo-900">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600">Total Penilaian</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $penilaian->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-6 transition-shadow duration-300 bg-white border-l-4 border-green-500 shadow-lg rounded-xl hover:shadow-xl">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-400 dark:bg-green-900">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600">Penilaian Hari Ini</h3>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $penilaian->where('assessed_at', '>=', today())->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-6 transition-shadow duration-300 bg-white border-l-4 border-purple-500 shadow-lg rounded-xl hover:shadow-xl">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-400 dark:bg-purple-900">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-600">Siswa Dinilai</h3>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $penilaian->pluck('student_id')->unique()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- penilaian Table -->
                <div class="overflow-hidden bg-white border border-gray-200 shadow-lg rounded-xl">
                    {{-- <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Daftar Penilaian Langsung</h2>
                    </div> --}}


                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        No.</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Siswa</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Guru</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Tugas Hafalan</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nilai</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Predikat</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($penilaian as $assessment)
                                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ ($penilaian->currentPage() - 1) * $penilaian->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    @if ($assessment->avatar)
                                                        <img class="object-cover w-10 h-10 rounded-full"
                                                            src="{{ asset('storage/' . $assessment->siswa->user->avatar) }}"
                                                            alt="{{ $assessment->siswa->user->name }}">
                                                    @else
                                                        <div
                                                            class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-full dark:bg-indigo-900">
                                                            <span
                                                                class="text-sm font-medium text-indigo-800 dark:text-indigo-200">{{ substr($assessment->siswa->user->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $assessment->siswa->user->name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $assessment->siswa->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $assessment->guru->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            @forelse ($assessment->surahHafalanPenilaian as $surah)
                                                <div>
                                                    {{ $surah->surah->nama }}: Ayat
                                                    {{ $surah->ayat_awal }}–{{ $surah->ayat_akhir }}
                                                </div>
                                            @empty
                                                <span class="italic text-gray-400">Tidak ada surah dicatat</span>
                                            @endforelse
                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">Tajwid:</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $assessment->nilai_tajwid }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">Harakat:</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $assessment->nilai_harakat }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">Makhraj:</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $assessment->nilai_makhraj }}</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">Nilai Total:</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $assessment->nilai_total }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                {{ $assessment->predikat_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($assessment->assessed_at)->translatedFormat('d M Y') }}
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($assessment->assessed_at)->timezone('Asia/Jakarta')->translatedFormat('H:i') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('teacher.penilaian.langsung.edit', $assessment) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-white bg-indigo-600 hover:bg-indigo-700 text-xs font-medium rounded-md transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <a href="{{ route('teacher.penilaian.langsung.show', $assessment) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-white bg-gray-600 hover:bg-gray-700 text-xs font-medium rounded-md transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Detail
                                                </a>

                                                <button onclick="confirmDelete('{{ $assessment->id }}')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>

                                                <form id="delete-form-{{ $assessment->id }}"
                                                    action="{{ route('teacher.penilaian.langsung.destroy', $assessment) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')

                                                </form>

                                                {{-- <form
                                                    action="{{ route('teacher.penilaian.langsung.destroy', $assessment) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus penilaian ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-md transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center p-6 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-16 h-16 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                                                    Belum ada penilaian langsung</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    @if (request('search'))
                                                        Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                                    @elseif (request('filter'))
                                                        Tidak ada data yang cocok dengan filter "<span
                                                            class="font-semibold">{{ request('filter') }}</span>"
                                                    @else
                                                        Belum ada penilaian langsung yang ditambahkan ke dalam sistem
                                                    @endif
                                                </p>
                                                <div class="mt-6">
                                                    <a href="{{ route('teacher.penilaian.langsung.create') }}"
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg class="w-5 h-5 mr-2 -ml-1"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        Tambah Penilaian Langsung
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
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $penilaian->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Apply fade-in animation to other elements
        document.querySelectorAll('.fade-in-up').forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('show');
            }, 100 * (index + 1));
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('#success-alert, #error-alert');
            alerts.forEach(alert => {
                if (alert) {
                    alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }
            });
        }, 5000);
    </script>

    <style>
        /* Animation classes */
        .fade-in {
            transition: opacity 0.5s ease-in-out;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .fade-in-up.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <x-delete-modal title="Konfirmasi Hapus"
        description="Apakah Anda yakin ingin menghapus data penilaian ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait penilaian tersebut." />

</x-app-layout>
