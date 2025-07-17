<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-guru />
        </x-slot>
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header title="Daftar Tugas Hafalan"
                    subtitle="Kelola dan pantau tugas hafalan untuk semua siswa dan kelas tahfidz" :route="route('teacher.tugas_hafalan.create')"
                    buttonText="Tambah Tugas" />

                <x-flash-message />

                <div class="w-full md:w-1/2 lg:w-1/3">
                    <form action="{{ route('teacher.tugas_hafalan.index') }}" method="GET" class="relative">
                        {{-- <div class="flex-grow">
                            <label for="search" class="sr-only">Cari Tugas...</label>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                placeholder="Cari berdasarkan nama tugas, surah, atau siswa..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 transition duration-200 ease-in-out border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-2 font-semibold text-white transition duration-200 ease-in-out bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Cari
                        </button>
                        <!-- Tombol untuk mereset pencarian (opsional) -->
                        @if (request('search'))
                            <a href="{{ route('teacher.tugas_hafalan.index') }}"
                            class="px-6 py-2 font-semibold text-center text-white transition duration-200 ease-in-out bg-red-500 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            >
                                Reset
                            </a>
                        @endif --}}

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
                                <a href="{{ route('teacher.tugas_hafalan.index') }}"
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

                <!-- Task Sections with Tabs -->
                <div class="overflow-hidden bg-white shadow-md rounded-xl dark:bg-gray-800" id="task-container">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="flex -mb-px" aria-label="Tabs">
                            <button id="active-tab" onclick="switchTab('active')"
                                class="flex-1 px-6 py-4 text-sm font-medium text-center text-indigo-600 border-b-2 border-indigo-500 tab-active dark:text-indigo-400 sm:flex-none">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tugas Aktif
                                </span>
                            </button>
                            <button id="archived-tab" onclick="switchTab('archived')"
                                class="flex-1 px-6 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 sm:flex-none">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                    Tugas Arsip
                                </span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tugas Aktif -->
                    <div id="active-tasks" class="p-6 fade-in">
                        <h2 class="sr-only">Tugas Aktif</h2>

                        @if ($activeTasks && $activeTasks->isEmpty())
                            <div class="py-8 text-center">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Belum ada tugas
                                    aktif</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan menambahkan tugas
                                    baru untuk siswa</p>
                                <div class="mt-6">
                                    <a href="{{ route('teacher.tugas_hafalan.create') }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Tambah Tugas Baru
                                    </a>
                                </div>
                            </div>
                        @else
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
                                                Nama Tugas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Surah Hafalan
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Ditujukan Kepada
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Tenggat waktu
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @if ($activeTasks)
                                            @foreach ($activeTasks as $task)
                                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                        {{ ($activeTasks->currentPage() - 1) * $activeTasks->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ $task->nama ?? '-' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            @foreach ($task->surahHafalan as $surahHafalanItem)
                                                                {{ $surahHafalanItem->surah->nama }}
                                                                ({{ $surahHafalanItem->ayat_awal }}-{{ $surahHafalanItem->ayat_akhir }})
                                                                @unless ($loop->last)
                                                                    <br>
                                                                @endunless
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{-- Tampilkan daftar siswa (student) yang dituju --}}
                                                            @if ($task->is_for_all_student)
                                                                {{-- Jika tugas ini untuk semua siswa di kelas (berdasarkan 'is_for_all_student') --}}
                                                                @if ($task->kelasTahfidz)
                                                                    {{-- Pastikan relasi kelasTahfidz sudah dimuat dan tidak null --}}
                                                                    Kelas: {{ $task->kelasTahfidz->tingkatan_label }} -
                                                                    {{ $task->kelasTahfidz->nama ?? 'Nama Kelas Tidak Ada' }}
                                                                @else
                                                                    Kelas tidak ditemukan.
                                                                @endif
                                                            @else
                                                                {{-- Jika tugas ini untuk siswa individu --}}
                                                                @if ($task->siswa->isNotEmpty())
                                                                    @foreach ($task->siswa as $student)
                                                                        {{ $student->user->name ?? 'Nama Tidak Ada' }}
                                                                        (@if ($student->kelasTahfidz->isNotEmpty())
                                                                            @foreach ($student->kelasTahfidz as $kelas)
                                                                                {{ $kelas->tingkatan_label }} -
                                                                                {{ $kelas->nama ?? 'N/A' }}@unless ($loop->last)
                                                                                ,
                                                                            @endunless
                                                                        @endforeach
                                                                    @else
                                                                        Tidak ada Kelas
                                                                    @endif)
                                                                    @unless ($loop->last)
                                                                        ,
                                                                    @endunless
                                                                @endforeach
                                                            @else
                                                                Tidak ada siswa dituju. {{-- Ini akan muncul jika is_for_all_student false tapi siswa kosong --}}
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($task->tenggat_waktu)->format('d M Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($task->tenggat_waktu)->timezone('Asia/Jakarta')->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($task->is_archived)
                                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-purple-800 bg-purple-100 rounded-full">
                                                            Diarsipkan
                                                        </span>
                                                    @else
                                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                            Aktif
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex justify-center gap-2">
                                                        <a href="{{ route('teacher.tugas_hafalan.edit', $task) }}"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </a>

                                                        <button type="button"
                                                            onclick="confirmArchive({{ $task->id }}, {{ $task->is_archived ? 'true' : 'false' }})"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                            </svg>
                                                            {{ $task->is_archived ? 'Pulihkan' : 'Arsip' }}
                                                        </button>


                                                        <button onclick="confirmDelete('{{ $task->id }}')"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>

                                                        <form id="archive-form-{{ $task->id }}"
                                                            action="{{ route('teacher.tugas_hafalan.toggle-archive', $task) }}"
                                                            method="POST" class="hidden">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>

                                                        <form id="delete-form-{{ $task->id }}"
                                                            action="{{ route('teacher.tugas_hafalan.destroy', $task) }}"
                                                            method="POST" class="hidden">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($activeTasks)
                            <div
                                class="p-4 bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Halaman {{ $activeTasks->currentPage() }} dari
                                        {{ $activeTasks->lastPage() }}
                                    </div>
                                    <div>
                                        {{ $activeTasks->onEachSide(1)->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Tugas Arsip -->
                <div id="archived-tasks" class="hidden p-6 fade-in">
                    <h2 class="sr-only">Tugas Diarsipkan</h2>

                    @if ($archivedTasks && $archivedTasks->isEmpty())
                        <div class="py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Belum ada tugas
                                yang diarsipkan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tugas yang diarsipkan akan
                                muncul di sini</p>
                        </div>
                    @else
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
                                            Nama Tugas
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Surah Hafalan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Ditujukan Kepada
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Tenggat waktu
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @if ($archivedTasks)
                                        @foreach ($archivedTasks as $task)
                                            <tr>
                                                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                    {{ ($archivedTasks->currentPage() - 1) * $archivedTasks->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        {{ $task->nama ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        @foreach ($task->surahHafalan as $surahHafalanItem)
                                                            {{ $surahHafalanItem->surah->nama }}
                                                            ({{ $surahHafalanItem->ayat_awal }}-{{ $surahHafalanItem->ayat_akhir }})
                                                            @unless ($loop->last)
                                                                <br>
                                                            @endunless
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        @if ($task->is_for_all_student)
                                                            {{-- Jika tugas ini untuk semua siswa di kelas (berdasarkan 'is_for_all_student') --}}
                                                            @if ($task->kelasTahfidz)
                                                                {{-- Pastikan relasi kelasTahfidz sudah dimuat dan tidak null --}}
                                                                Kelas: {{ $task->kelasTahfidz->tingkatan_label }} -
                                                                {{ $task->kelasTahfidz->nama ?? 'Nama Kelas Tidak Ada' }}
                                                            @else
                                                                Kelas tidak ditemukan.
                                                            @endif
                                                        @else
                                                            {{-- Jika tugas ini untuk siswa individu --}}
                                                            @if ($task->siswa->isNotEmpty())
                                                                @foreach ($task->siswa as $student)
                                                                    {{ $student->user->name ?? 'Nama Tidak Ada' }}
                                                                    (@if ($student->kelasTahfidz->isNotEmpty())
                                                                        @foreach ($student->kelasTahfidz as $kelas)
                                                                            {{ $kelas->tingkatan_label }} -
                                                                            {{ $kelas->nama ?? 'N/A' }}@unless ($loop->last)
                                                                            ,
                                                                        @endunless
                                                                    @endforeach
                                                                @else
                                                                    Tidak ada Kelas
                                                                @endif)
                                                                @unless ($loop->last)
                                                                    ,
                                                                @endunless
                                                            @endforeach
                                                        @else
                                                            Tidak ada siswa dituju. {{-- Ini akan muncul jika is_for_all_student false tapi siswa kosong --}}
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::parse($task->tenggat_waktu)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($task->is_archived)
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-purple-800 bg-purple-100 rounded-full">
                                                        Diarsipkan
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex justify-center gap-2">
                                                    <button onclick="confirmRestore('{{ $task->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        Pulihkan
                                                    </button>

                                                    <button onclick="confirmDelete('{{ $task->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>

                                                    <form id="restore-form-{{ $task->id }}"
                                                        action="{{ route('teacher.tugas_hafalan.toggle-archive', $task) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>

                                                    <form id="delete-form-{{ $task->id }}"
                                                        action="{{ route('teacher.tugas_hafalan.destroy', $task) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if ($archivedTasks)
                        <div
                            class="p-4 bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Halaman {{ $archivedTasks->currentPage() }} dari
                                    {{ $archivedTasks->lastPage() }}
                                </div>
                                <div>
                                    {{ $archivedTasks->onEachSide(1)->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
    </main>
</div>
</div>

<!-- Archive Confirmation Modal -->
<div id="archiveModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
<div class="absolute inset-0 transition-opacity bg-black bg-opacity-50 backdrop-blur-sm"></div>
<div
    class="relative z-10 w-full max-w-md p-6 mx-auto transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="sm:flex sm:items-start">
        <div
            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-indigo-100 rounded-full sm:mx-0 sm:h-10 sm:w-10 dark:bg-indigo-900">
            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
        </div>
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                Arsipkan Tugas
            </h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin mengarsipkan tugas ini? Tugas yang diarsipkan tidak akan ditampilkan
                    kepada siswa, tetapi dapat dipulihkan kembali jika diperlukan.
                </p>
            </div>
        </div>
    </div>
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirmArchiveBtn"
            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
            Arsipkan
        </button>
        <button type="button" onclick="closeArchiveModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
            Batal
        </button>
    </div>
</div>
</div>

<!-- Restore Confirmation Modal -->
<div id="restoreModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
<div class="absolute inset-0 transition-opacity bg-black bg-opacity-50 backdrop-blur-sm"></div>
<div
    class="relative z-10 w-full max-w-md p-6 mx-auto transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="sm:flex sm:items-start">
        <div
            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0 sm:h-10 sm:w-10 dark:bg-green-900">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </div>
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                Pulihkan Tugas
            </h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin memulihkan tugas ini? Tugas yang dipulihkan akan aktif kembali dan
                    dapat dilihat oleh siswa.
                </p>
            </div>
        </div>
    </div>
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirmRestoreBtn"
            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            Pulihkan
        </button>
        <button type="button" onclick="closeRestoreModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
            Batal
        </button>
    </div>
</div>
</div>

<x-delete-modal title="Konfirmasi Hapus"
description="Apakah Anda yakin ingin menghapus data tugas ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait tugas tersebut." />

<script>
    // Task Variables
    let currentTaskId = null;

    // Tab Switching Functions
    function switchTab(tabName) {
        const activeTasks = document.getElementById('active-tasks');
        const archivedTasks = document.getElementById('archived-tasks');
        const activeTab = document.getElementById('active-tab');
        const archivedTab = document.getElementById('archived-tab');

        if (tabName === 'active') {
            activeTasks.classList.remove('hidden');
            archivedTasks.classList.add('hidden');
            activeTab.classList.add('tab-active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                'hover:border-gray-300');
            archivedTab.classList.remove('tab-active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            archivedTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                'hover:border-gray-300');
        } else {
            activeTasks.classList.add('hidden');
            archivedTasks.classList.remove('hidden');
            activeTab.classList.remove('tab-active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            activeTab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                'hover:border-gray-300');
            archivedTab.classList.add('tab-active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            archivedTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                'hover:border-gray-300');
        }

        // Apply fade-in animation to visible task list
        const visibleTaskList = tabName === 'active' ? activeTasks : archivedTasks;
        visibleTaskList.classList.add('animate-fade-in');
        setTimeout(() => {
            visibleTaskList.classList.remove('animate-fade-in');
        }, 500);
    }

    // Search Functionality
    document.getElementById('search').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const taskCards = document.querySelectorAll('.task-card');

        taskCards.forEach(card => {
            const taskText = card.textContent.toLowerCase();
            if (taskText.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Status Filter Functionality
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const filter = e.target.value;

        if (filter === 'active') {
            switchTab('active');
        } else if (filter === 'archived') {
            switchTab('archived');
        } else {
            // Show both (custom implementation if needed)
            switchTab('active');
        }
    });

    // Archive Functions
    function confirmArchive(taskId) {
        currentTaskId = taskId;
        document.getElementById('archiveModal').classList.remove('hidden');
        document.getElementById('confirmArchiveBtn').addEventListener('click', executeArchive);
    }

    function closeArchiveModal() {
        document.getElementById('archiveModal').classList.add('hidden');
        document.getElementById('confirmArchiveBtn').removeEventListener('click', executeArchive);
        currentTaskId = null;
    }

    function executeArchive() {
        if (currentTaskId) {
            document.getElementById(`archive-form-${currentTaskId}`).submit();
        }
        closeArchiveModal();
    }

    // Restore Functions
    function confirmRestore(taskId) {
        currentTaskId = taskId;
        document.getElementById('restoreModal').classList.remove('hidden');
        document.getElementById('confirmRestoreBtn').addEventListener('click', executeRestore);
    }

    function closeRestoreModal() {
        document.getElementById('restoreModal').classList.add('hidden');
        document.getElementById('confirmRestoreBtn').removeEventListener('click', executeRestore);
        currentTaskId = null;
    }

    function executeRestore() {
        if (currentTaskId) {
            document.getElementById(`restore-form-${currentTaskId}`).submit();
        }
        closeRestoreModal();
    }
</script>
</x-app-layout>
