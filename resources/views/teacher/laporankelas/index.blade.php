@php
    $filterAktif =
        request()->has('kelas_id') ||
        request()->has('surah_id') ||
        request()->has('student_id') ||
        request()->has('periode') ||
        request()->has('tahun_ajaran_id');
@endphp


<x-app-layout>
    <x-slot name="sidebar">
        <x-sidebar-guru />
    </x-slot>

    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Penilaian Hafalan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola dan lihat laporan penilaian hafalan siswa</p>
        </div>

        <!-- Filter Section -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Filter Laporan</h2>

            <form method="GET" action="{{ route('teacher.laporankelas.index') }}" class="space-y-4">
                <!-- Row 1 -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="tahun_ajaran_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Tahun Ajaran
                        </label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($tahunAjaranList as $tahun)
                                <option value="{{ $tahun->id }}"
                                    {{ request('tahun_ajaran_id', $tahunAjaranAktifId) == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun_ajaran }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label for="kelas_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Kelas
                        </label>
                        <select name="kelas_id" id="kelas_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="student_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Siswa (Opsional)
                        </label>
                        <select name="student_id" id="student_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Siswa</option>
                            @foreach ($studentList as $student)
                                <option value="{{ $student->id }}"
                                    {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="surah_id" class="block mb-2 text-sm font-medium text-gray-700">
                            Surah
                        </label>
                        <select name="surah_id" id="surah_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Surah</option>
                            @foreach ($surahs as $surah)
                                <option value="{{ $surah->id }}"
                                    {{ request('surah_id') == $surah->id ? 'selected' : '' }}>
                                    {{ $surah->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="periode" class="block mb-2 text-sm font-medium text-gray-700">
                            Periode
                        </label>
                        <select name="periode" id="periode"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tahun Ini</option>
                            <option value="tanggal" {{ request('periode') == 'tanggal' ? 'selected' : '' }}>Tanggal
                            </option>
                            <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                            <option value="semester" {{ request('periode') == 'semester' ? 'selected' : '' }}>Semester
                            </option>
                            <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>Custom
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="dari_tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                            Dari Tanggal
                        </label>
                        <input type="date" name="dari_tanggal" id="dari_tanggal"
                            value="{{ request('dari_tanggal') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <div>
                        <label for="sampai_tanggal" class="block mb-2 text-sm font-medium text-gray-700">
                            Sampai Tanggal
                        </label>
                        <input type="date" name="sampai_tanggal" id="sampai_tanggal"
                            value="{{ request('sampai_tanggal') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    {{-- <div class="flex items-end">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="mr-2 fas fa-search"></i>Tampilkan Laporan
                        </button>
                    </div> --}}

                    <div class="flex flex-col gap-2 mt-4 sm:flex-row sm:items-end sm:space-x-2">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md shadow-sm sm:w-auto hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="mr-2 fas fa-search"></i>Tampilkan Laporan
                        </button>

                        @if ($filterAktif)
                            <a href="{{ route('teacher.laporankelas.index') }}"
                                class="w-full px-4 py-2 text-sm font-medium text-center text-gray-700 transition-colors duration-200 bg-gray-200 rounded-md shadow-sm sm:w-auto hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                <i class="mr-2 fas fa-undo-alt"></i>Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200 rounded-t-lg bg-gray-50">
                @if ($selectedSurahId)
                    <h2 class="text-lg font-semibold text-gray-800">
                        Laporan Surah: {{ $surahs->firstWhere('id', $selectedSurahId)?->nama ?? '-' }}
                    </h2>
                @else
                    <h2 class="text-lg font-semibold text-gray-800">Riwayat Penilaian</h2>
                @endif
                <p class="mt-1 text-sm text-gray-600">Daftar Penilaian Hafalan Siswa</p>
            </div>

            @if ($filterAktif)
                {{-- Tampilkan tabel jika sudah submit filter --}}
                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-medium text-left text-gray-700 border-r border-gray-200">
                                    No
                                </th>
                                <th class="px-4 py-3 font-medium text-left text-gray-700 border-r border-gray-200">
                                    Nama Siswa
                                </th>
                                <th class="px-4 py-3 font-medium text-left text-gray-700 border-r border-gray-200">
                                    Surah
                                </th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Jenis Penilaian</th>
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                    Jenis Hafalan</th>
                                <th class="px-4 py-3 font-medium text-left text-gray-700 border-r border-gray-200">
                                    Tanggal
                                </th>
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
                                <th class="px-4 py-3 font-medium text-left text-gray-700">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($penilaian as $i => $p)
                                <tr class="transition-colors duration-150 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200">
                                        {{ $i + 1 }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800 border-r border-gray-200">
                                        {{ $p->siswa->user->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200">
                                        {{ optional($p->surahHafalanPenilaian->first()?->surah)->nama ??
                                            (optional($p->tugasHafalan->surahHafalan->first()?->surah)->nama ?? '-') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 capitalize dark:text-gray-100">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                            @if ($p->jenis_penilaian == 'langsung') bg-blue-100 text-blue-800
                                                            @elseif($p->jenis_penilaian == 'pengumpulan')
                                                                bg-purple-100 text-purple-800
                                                            @else
                                                                bg-gray-100 text-gray-800 @endif">
                                            {{ $p->jenis_penilaian }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 capitalize dark:text-gray-100">
                                        <span class="font-medium">{{ $p->jenis_hafalan }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200">
                                        {{ $p->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">{{ $p->nilai_tajwid }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">{{ $p->nilai_harakat }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">{{ $p->nilai_makhraj }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-gray-100">
                                        <span
                                            class="font-bold text-indigo-600 dark:text-indigo-400">{{ $p->nilai_total }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                            @if ($p->nilai_total >= 90) bg-green-100 text-green-800
                                                            @elseif($p->nilai_total >= 80) bg-blue-100 text-blue-800
                                                            @elseif($p->nilai_total >= 70) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $p->predikat_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $p->catatan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="mb-4 text-4xl text-gray-300 fas fa-search"></i>
                                            <p class="text-lg font-medium text-gray-400">Tidak ada data penilaian
                                                ditemukan
                                            </p>
                                            <p class="mt-1 text-sm text-gray-400">Silakan ubah filter untuk melihat
                                                data
                                                yang berbeda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Kalau belum filter, bisa tampilkan pesan atau biarkan kosong --}}
                <div class="mt-8 italic text-center text-gray-500">
                    Silakan gunakan filter di atas dan klik "Tampilkan Laporan" untuk melihat data.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
