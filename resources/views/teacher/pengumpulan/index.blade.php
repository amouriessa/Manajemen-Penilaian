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
                        <h1 class="text-lg font-bold text-gray-800 dark:text-white md:text-xl">Daftar Pengumpulan Siswa
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola dan review file pengumpulan dari
                            siswa</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="px-4 py-2 bg-blue-100 rounded-full dark:bg-blue-900/30">
                            <span class="text-xs font-medium text-blue-800 dark:text-blue-200">
                                Total: {{ $pengumpulans->count() }} pengumpulan
                            </span>
                        </div>

                        <div class="px-4 py-2 bg-yellow-100 rounded-full dark:bg-yellow-900/30">
                            <span class="text-xs font-medium text-yellow-800 dark:text-yellow-200">
                                Belum dinilai: {{ $totalBelumDinilai }}
                            </span>
                        </div>
                    </div>
                </div>

                <x-flash-message />

                <!-- Filters and Search Section -->
                <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <!-- Search Form -->
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <form method="GET" action="{{ route('teacher.pengumpulan.index') }}" class="relative">
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
                                        <a href="{{ route('teacher.pengumpulan.index') }}"
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
                        <form method="GET" action="{{ route('teacher.pengumpulan.index') }}">
                            <div class="flex flex-wrap items-center gap-3">
                                @php
                                    $statusTexts = [
                                        'dikumpulkan' => 'Belum Dinilai',
                                        'dinilai' => 'Dinilai',
                                        'ditolak' => 'Ditolak',
                                        'mengulang' => 'Mengulang',
                                        'telat' => 'Terlambat',

                                    ];
                                @endphp
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

                                        <optgroup label="Status">
                                            @foreach ($statusTexts as $status => $label)
                                                <option value="status:{{ $status }}" @selected(request('status') === $status)>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <!-- Tombol Reset -->
                                @if (request('filter') || request('status'))
                                    <a href="{{ route('teacher.pengumpulan.index') }}"
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

                <!-- pengumpulan Table/Cards -->
                <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                    @if ($pengumpulans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                                id="pengumpulanTable">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            No.
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Siswa
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Tugas & File
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Status
                                        </th>
                                        {{-- <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        Tenggat Waktu
                                    </th> --}}
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Tanggal Submit
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Penilaian
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($pengumpulans as $pengumpulan)
                                        <tr class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            data-status="{{ $pengumpulan->status }}"
                                            data-student="{{ strtolower($pengumpulan->siswa->user->name ?? '') }}"
                                            data-task="{{ strtolower($pengumpulan->tugasHafalan->nama ?? '') }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        @if ($pengumpulan->avatar)
                                                            <img class="object-cover w-10 h-10 rounded-full"
                                                                src="{{ asset('storage/' . $pengumpulan->siswa->user->avatar) }}"
                                                                alt="{{ $pengumpulan->siswa->user->name }}">
                                                        @else
                                                            <div
                                                                class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-full dark:bg-indigo-900">
                                                                <span
                                                                    class="text-sm font-medium text-indigo-800 dark:text-indigo-200">{{ substr($pengumpulan->siswa->user->name, 0, 2) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $pengumpulan->siswa->user->name ?? 'Nama tidak tersedia' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $pengumpulan->siswa->user->email ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    <div class="mb-1 font-medium">
                                                        {{-- {{ $pengumpulan->tugasHafalan->surah->name ?? 'Tugas tidak tersedia' }}
                                                    @if ($pengumpulan->tugasHafalan->ayat_awal && $pengumpulan->tugasHafalan->ayat_akhir)
                                                        ({{ $pengumpulan->tugasHafalan->ayat_awal }}–{{ $pengumpulan->tugasHafalan->ayat_akhir }})
                                                    @endif --}}
                                                        @foreach ($pengumpulan->tugasHafalan->surahHafalan as $surahHafalanItem)
                                                            {{ $surahHafalanItem->surah->nama }}
                                                            ({{ $surahHafalanItem->ayat_awal }}-{{ $surahHafalanItem->ayat_akhir }})
                                                            <br>
                                                        @endforeach

                                                    </div>
                                                    <div
                                                        class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $pengumpulan->file_pengumpulan ? 'File terupload' : 'Tidak ada file' }}
                                                    </div>
                                                    @if ($pengumpulan->tugasHafalan && $pengumpulan->tugasHafalan->tenggat_waktu)
                                                        <div
                                                            class="flex items-center mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Deadline:
                                                            {{ \Carbon\Carbon::parse($pengumpulan->tugasHafalan->tenggat_waktu)->translatedFormat('d M Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'dikumpulkan' =>
                                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                        'dinilai' =>
                                                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                        'ditolak' =>
                                                            'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                        'mengulang' =>
                                                            'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                        'telat' =>
                                                            'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',

                                                    ];
                                                    $statusTexts = [
                                                        'dikumpulkan' => 'Belum Dinilai',
                                                        'dinilai' => 'Dinilai',
                                                        'ditolak' => 'Ditolak',
                                                        'mengulang' => 'Mengulang',
                                                        'telat' => 'Terlambat',

                                                    ];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$pengumpulan->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                    {{ $statusTexts[$pengumpulan->status] ?? ucfirst($pengumpulan->status) }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="font-medium">
                                                    {{ \Carbon\Carbon::parse($pengumpulan->submitted_at ?? $pengumpulan->created_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($pengumpulan->submitted_at ?? $pengumpulan->created_at)->timezone('Asia/Jakarta')->format('H:i') }}
                                                </div>
                                            </td>

                                            {{-- Kolom Penilaian --}}
                                            <td
                                                class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                                @if ($pengumpulan->penilaian)
                                                    <div class="flex flex-col space-y-1">
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Tajwid:</span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $pengumpulan->penilaian->nilai_tajwid ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Harakat:</span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $pengumpulan->penilaian->nilai_harakat ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Makhraj:</span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $pengumpulan->penilaian->nilai_makhraj ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Nilai Total:</span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $pengumpulan->penilaian->nilai_total ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs text-gray-500">Predikat:</span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900">{{ $pengumpulan->penilaian->predikat_label ?? '-' }}</span>
                                                        </div>
                                                        @if ($pengumpulan->penilaian->catatan)
                                                            <span
                                                                class="text-xs italic text-gray-500 dark:text-gray-400">Catatan:
                                                                {{ Str::limit($pengumpulan->penilaian->catatan, 30) }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">Belum
                                                        dinilai</span>
                                                @endif
                                            </td>
                                            {{-- Kolom Aksi --}}
                                            <td
                                                class="px-6 py-4 text-sm font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex justify-center space-x-2">
                                                    {{-- Tombol Penilaian --}}
                                                    @if ($pengumpulan->penilaian)
                                                        {{-- Jika sudah dinilai, tombol untuk melihat/mengedit penilaian --}}
                                                        <a href="{{ route('teacher.penilaian.pengumpulan.edit', $pengumpulan) }}"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150"
                                                            title="Lihat & Edit Penilaian">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit Nilai
                                                        </a>
                                                    @else
                                                        {{-- Jika belum dinilai, tombol untuk menilai --}}
                                                        <a href="{{ route('teacher.penilaian.pengumpulan.create', $pengumpulan) }}"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                            <svg class="h-3.5 w-3.5 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            Nilai
                                                        </a>
                                                    @endif

                                                    {{-- Tombol Download --}}
                                                    @if ($pengumpulan->file_pengumpulan)
                                                        <a href="{{ route('teacher.pengumpulan.download', $pengumpulan) }}"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150"
                                                            title="Download File">
                                                            <svg class="h-3.5 w-3.5 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- @empty
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
                                                    Belum ada pengumpulan</h3>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    @if (request('search'))
                                                        Tidak ada hasil untuk pencarian
                                                        "{{ request('search') }}"
                                                    @else
                                                        File pengumpulan siswa akan muncul di sini setelah
                                                        mereka
                                                        mengumpulkan tugas.
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse --}}
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
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak
                                ada
                                data</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                @if (request('search'))
                                    Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                @elseif (request('filter'))
                                    Tidak ada data yang cocok dengan filter "<span
                                        class="font-semibold">{{ request('filter') }}</span>"
                                @else
                                    Belum ada pengumpulan dari siswa
                                @endif
                            </p>
                        </div>
                        {{-- </div> --}}
                    @endif
                    <!-- Pagination -->
                    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <!-- Info halaman dan total data -->
                            <div class="flex flex-col items-center gap-2 text-sm text-gray-700 sm:flex-row">
                                <span>
                                    Menampilkan
                                    <span class="font-medium">{{ $pengumpulans->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span class="font-medium">{{ $pengumpulans->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium">{{ $pengumpulans->total() }}</span>
                                    hasil
                                </span>
                                <span class="hidden text-gray-400 sm:inline">•</span>
                                <span>
                                    Halaman
                                    <span class="font-medium">{{ $pengumpulans->currentPage() }}</span>
                                    dari
                                    <span class="font-medium">{{ $pengumpulans->lastPage() }}</span>
                                </span>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex items-center space-x-2">
                                @if ($pengumpulans->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </span>
                                @else
                                    <a href="{{ $pengumpulans->previousPageUrl() }}"
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
                                    @foreach ($pengumpulans->getUrlRange(max(1, $pengumpulans->currentPage() - 2), min($pengumpulans->lastPage(), $pengumpulans->currentPage() + 2)) as $page => $url)
                                        @if ($page == $pengumpulans->currentPage())
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

                                @if ($pengumpulans->hasMorePages())
                                    <a href="{{ $pengumpulans->nextPageUrl() }}"
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
                                @for ($i = 1; $i <= $pengumpulans->lastPage(); $i++)
                                    <option value="{{ $pengumpulans->url($i) }}"
                                        {{ $i == $pengumpulans->currentPage() ? 'selected' : '' }}>
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
</x-app-layout>
