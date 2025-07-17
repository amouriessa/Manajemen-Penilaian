<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-guru />
        </x-slot>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div
                    class="flex flex-col gap-4 p-6 bg-white border-l-4 border-indigo-500 shadow-md rounded-xl dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800 dark:text-white md:text-xl">Laporan Penilaian</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Laporan hafalan per siswa beserta nilai
                            dan surah yang dinilai</p>
                    </div>
                </div>

                {{-- Flash Messages --}}
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

                {{-- Filter Card --}}
                <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Filter Laporan</h3>

                    <form method="GET" action="{{ route('teacher.laporan.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- Filter Kelas --}}
                            {{-- <div>
                                <label for="kelas_id"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Pilih Kelas
                                </label>
                                <select name="kelas_id" id="kelas_id"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}"
                                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- Filter Kelas --}}
                            <div>
                                <label for="kelas_id" class="block text-sm font-medium">Kelas Tahfidz</label>
                                <select name="kelas_id" id="kelas_id" class="w-full border-gray-300 rounded">
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Tahun Ajaran --}}
                            <div>
                                <label for="tahun_ajaran_id" class="block text-sm font-medium">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                                    class="w-full text-sm border-gray-300 rounded">
                                    @foreach ($tahunAjaranList as $tahun)
                                        <option value="{{ $tahun->id }}"
                                            {{ request('tahun_ajaran_id') == $tahun->id ? 'selected' : '' }}>
                                            {{ $tahun->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Siswa dengan Tom Select --}}
                            {{-- <div>
                                <label for="student_id"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Cari Nama Siswa
                                </label>
                                <select name="student_id" id="student_id"
                                    class="block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Ketik untuk mencari siswa --</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}"
                                            {{ request('student_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- Filter Siswa --}}
                            <div>
                                <label for="student_id" class="block text-sm font-medium">Nama Siswa (Opsional)</label>
                                <select name="student_id" id="student_id" class="w-full text-sm border-gray-300 rounded">
                                    <option value="">-- Semua Siswa --</option>
                                    @foreach ($studentList as $student)
                                        <option value="{{ $student->id }}"
                                            {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Periode --}}
                            <div>
                                <label for="periode" class="block text-sm font-medium">Filter Periode</label>
                                <select name="periode" id="periode" class="w-full text-sm border-gray-300 rounded"
                                    onchange="togglePeriodeInputs(this.value)">
                                    <option value="">-- Pilih Periode --</option>
                                    <option value="tanggal" {{ request('periode') == 'tanggal' ? 'selected' : '' }}>Per
                                        Tanggal</option>
                                    <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Per
                                        Bulan</option>
                                    <option value="semester" {{ request('periode') == 'semester' ? 'selected' : '' }}>
                                        Per Semester</option>
                                    <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>
                                        Custom</option>
                                </select>
                            </div>

                            {{-- Input untuk Periode --}}
                            <div id="input-tanggal" class="hidden">
                                <label class="block text-sm font-medium">Tanggal</label>
                                <input type="date" name="dari_tanggal" class="border-gray-300 rounded"
                                    value="{{ request('dari_tanggal') }}">
                                <input type="date" name="sampai_tanggal" class="border-gray-300 rounded"
                                    value="{{ request('sampai_tanggal') }}">
                            </div>

                            <div id="input-bulan" class="hidden">
                                <label class="block text-sm font-medium">Bulan & Tahun</label>
                                <select name="bulan" class="border-gray-300 rounded">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                                <input type="number" name="tahun" class="border-gray-300 rounded"
                                    value="{{ request('tahun') ?? now()->year }}">
                            </div>

                            <div id="input-semester" class="hidden">
                                <label class="block text-sm font-medium">Semester & Tahun</label>
                                <select name="semester" class="border-gray-300 rounded">
                                    <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>
                                        Ganjil (Jul–Des)</option>
                                    <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>
                                        Genap (Jan–Jun)</option>
                                </select>
                                <input type="number" name="tahun" class="border-gray-300 rounded"
                                    value="{{ request('tahun') ?? now()->year }}">
                            </div>

                            <div id="input-custom" class="hidden">
                                <label class="block text-sm font-medium">Custom</label>
                                <input type="date" name="custom_dari" class="border-gray-300 rounded"
                                    value="{{ request('custom_dari') }}">
                                <input type="date" name="custom_sampai" class="border-gray-300 rounded"
                                    value="{{ request('custom_sampai') }}">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3 pt-4">
                            <button type="submit"
                                class="px-6 py-2 text-sm font-medium text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Tampilkan Laporan
                            </button>

                            @if (request('student_id') || request('kelas_id'))
                                <a href="{{ route('teacher.laporan.index') }}"
                                    class="px-6 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if ($selectedStudent)
                    {{-- Student Information Card --}}
                    <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                                    {{ $selectedStudent->user->name }}</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $selectedStudent->user->email }}
                                </p>
                                @if ($selectedStudent->kelas)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Kelas:
                                        {{ $selectedStudent->kelas->nama }}</p>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-3">
                                {{-- Tombol Cetak --}}
                                <a href="{{ route('teacher.laporan.cetak', request()->all()) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Cetak Laporan
                                </a>

                                {{-- Tombol Pilih Siswa Lain --}}
                                <a href="{{ route('teacher.laporan.index') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                    Pilih Siswa Lain
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Assessment Report Table --}}
                    <div class="bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Riwayat Penilaian</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Daftar penilaian hafalan siswa</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            No</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Surah & Ayat</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Jenis Penilaian</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Jenis Hafalan</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Tanggal</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                            Tajwid</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                            Harakat</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                            Makhraj</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                            Total</th>
                                        <th
                                            class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">
                                            Predikat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @php $rowNumber = 1; @endphp
                                    @forelse ($penilaian as $item)
                                        {{-- Inisialisasi variabel untuk menampung surah-surah --}}
                                        @php
                                            $surahsToDisplay = collect(); // Menggunakan koleksi untuk kemudahan
                                            if ($item->jenis_penilaian == 'langsung') {
                                                $surahsToDisplay = $item->surahHafalanPenilaian;
                                            } elseif ($item->jenis_penilaian == 'pengumpulan' && $item->tugasHafalan) {
                                                // Pastikan tugasHafalan ada sebelum mencoba mengakses surahHafalan
                                                $surahsToDisplay = $item->tugasHafalan->surahHafalan;
                                            }
                                        @endphp

                                        {{-- Jika ada surah yang perlu ditampilkan, loop di sini --}}
                                        @if ($surahsToDisplay->isNotEmpty())
                                            @foreach ($surahsToDisplay as $surahHafalan)
                                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td
                                                        class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                        {{ $rowNumber++ }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                        <div class="font-medium">
                                                            {{ $surahHafalan->surah->nama ?? 'N/A' }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">Ayat
                                                            {{ $surahHafalan->ayat_awal }}–{{ $surahHafalan->ayat_akhir }}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-gray-900 capitalize dark:text-gray-100">
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                            @if ($item->jenis_penilaian == 'langsung') bg-blue-100 text-blue-800
                                                            @elseif($item->jenis_penilaian == 'pengumpulan')
                                                                bg-purple-100 text-purple-800
                                                            @else
                                                                bg-gray-100 text-gray-800 @endif">
                                                            {{ $item->jenis_penilaian }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-gray-900 capitalize dark:text-gray-100">
                                                        <span class="font-medium">{{ $item->jenis_hafalan }}</span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($item->assessed_at)->format('d M Y') }}
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                        <span class="font-medium">{{ $item->nilai_tajwid }}</span>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                        <span class="font-medium">{{ $item->nilai_harakat }}</span>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                        <span class="font-medium">{{ $item->nilai_makhraj }}</span>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                        <span
                                                            class="font-bold text-indigo-600 dark:text-indigo-400">{{ $item->nilai_total }}</span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-center">
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                            @if ($item->nilai_total >= 90) bg-green-100 text-green-800
                                                            @elseif($item->nilai_total >= 80) bg-blue-100 text-blue-800
                                                            @elseif($item->nilai_total >= 70) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ $item->predikat_label }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            {{-- Ini akan tampil jika tidak ada surah yang ditemukan untuk penilaian tersebut (baik langsung maupun pengumpulan) --}}
                                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td
                                                    class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                    {{ $rowNumber++ }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400"
                                                    colspan="1">
                                                    Surah tidak tersedia
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-gray-900 capitalize dark:text-gray-100">
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                        @if ($item->jenis_penilaian == 'langsung') bg-blue-100 text-blue-800
                                                        @elseif($item->jenis_penilaian == 'pengumpulan')
                                                            bg-purple-100 text-purple-800
                                                        @else
                                                            bg-gray-100 text-gray-800 @endif">
                                                        {{ $item->jenis_penilaian }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($item->assessed_at)->format('d M Y') }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                    <span class="font-medium">{{ $item->nilai_tajwid }}</span>
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                    <span class="font-medium">{{ $item->nilai_harakat }}</span>
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                    <span class="font-medium">{{ $item->nilai_makhraj }}</span>
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                                    <span
                                                        class="font-bold text-indigo-600 dark:text-indigo-400">{{ $item->nilai_total }}</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-center">
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                        @if ($item->nilai_total >= 90) bg-green-100 text-green-800
                                                        @elseif($item->nilai_total >= 80) bg-blue-100 text-blue-800
                                                        @elseif($item->nilai_total >= 70) bg-yellow-100 text-yellow-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                        {{ $item->predikat_label }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="9"
                                                class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 mb-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-lg font-medium">Belum ada data penilaian</p>
                                                    <p class="text-sm">Siswa ini belum memiliki riwayat penilaian</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="p-8 text-center bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Pilih Siswa untuk
                                Melihat Laporan</h3>
                            <p class="text-gray-600 dark:text-gray-400">Gunakan filter di atas untuk memilih siswa dan
                                melihat laporan penilaian hafalan</p>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tom Select for student selection
            new TomSelect('#student_id', {
                placeholder: 'Ketik nama siswa untuk mencari...',
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                searchField: ['text'],
                dropdownParent: 'body',
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Tidak ada siswa yang ditemukan</div>';
                    }
                }
            });
        });

        function togglePeriodeInputs(selected) {
            document.getElementById('input-tanggal').style.display = 'none';
            document.getElementById('input-bulan').style.display = 'none';
            document.getElementById('input-semester').style.display = 'none';
            document.getElementById('input-custom').style.display = 'none';

            if (selected === 'tanggal') {
                document.getElementById('input-tanggal').style.display = 'block';
            } else if (selected === 'bulan') {
                document.getElementById('input-bulan').style.display = 'block';
            } else if (selected === 'semester') {
                document.getElementById('input-semester').style.display = 'block';
            } else if (selected === 'custom') {
                document.getElementById('input-custom').style.display = 'block';
            }
        }

        // Auto trigger saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            togglePeriodeInputs(document.getElementById('periode').value);
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectEl = document.getElementById('student_id');
            const url = selectEl.dataset.url;
            const selectedId = selectEl.dataset.selected;
            const kelasSelect = document.getElementById('kelas_id');

            let studentSelect = new TomSelect(selectEl, {
                placeholder: 'Ketik nama siswa...',
                allowEmptyOption: true,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                load: function (query, callback) {
                    let kelasId = kelasSelect.value;

                    if (!kelasId) {
                        return callback(); // tidak load siswa jika kelas belum dipilih
                    }

                    fetch(`${url}?kelas_id=${kelasId}&search=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => callback(data))
                        .catch(() => callback());
                },
            });

            // Trigger refresh when kelas_id changes
            kelasSelect.addEventListener('change', () => {
                studentSelect.clearOptions();
                studentSelect.clear(true); // reset selected value
            });

            // Load selected value (jika ada)
            if (selectedId) {
                fetch(`${url}?selected_id=${selectedId}`)
                    .then(res => res.json())
                    .then(data => {
                        studentSelect.addOption(data);
                        studentSelect.setValue(data.id);
                    });
            }
        });
    </script> --}}
</x-app-layout>
