<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <x-slot name="sidebar">
            <x-sidebar-guru />
        </x-slot>

        <div class="flex-1 overflow-y-auto">
            <main class="p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="flex flex-col gap-4 p-6 bg-white border-l-4 border-indigo-600 shadow-md rounded-xl dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800 dark:text-white md:text-xl">Laporan Penilaian</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Laporan hafalan per siswa beserta nilai dan surah yang dinilai</p>
                    </div>
                </div>

                {{-- Flash / Validation Errors --}}
                @if (session('error'))
                    <div class="p-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-md">
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-md">
                        <p class="mb-1 text-sm font-semibold">Filter belum lengkap:</p>
                        <ul class="text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Filter Card --}}
                <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Filter Laporan</h3>

                    <form method="GET" action="{{ route('teacher.laporan.index') }}" id="form-laporan" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            {{-- Filter Kelas --}}
                            <div>
                                <label for="kelas_tahfidz_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kelas Tahfidz <span class="text-red-500">*</span>
                                </label>
                                <select name="kelas_tahfidz_id" id="kelas_tahfidz_id"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasList as $kelas)
                                        {{-- Tampilkan tingkatan + nama: misal "Kelas 7 - A" atau sesuai field yang ada --}}
                                        <option value="{{ $kelas->id }}" {{ request('kelas_tahfidz_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->tingkatan ? 'Kelas ' . $kelas->tingkatan . ' - ' . $kelas->nama : $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Tahun Ajaran --}}
                            <div>
                                <label for="tahun_ajaran_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach ($tahunAjaranList as $tahun)
                                        <option value="{{ $tahun->id }}" {{ request('tahun_ajaran_id') == $tahun->id ? 'selected' : '' }}>
                                            {{ $tahun->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Siswa — di-populate via AJAX berdasarkan kelas --}}
                            <div>
                                <label for="student_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Siswa <span class="text-red-500">*</span>
                                </label>
                                <select name="student_id" id="student_id"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">-- Pilih kelas dahulu --</option>
                                    {{-- Jika sudah ada filter sebelumnya, tampilkan siswa sesuai kelas --}}
                                    @if (request('kelas_tahfidz_id'))
                                        @foreach ($studentList as $student)
                                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->user->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Filter Periode — hanya Tanggal & Bulan --}}
                            <div>
                                <label for="periode" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Filter Periode <span class="text-red-500">*</span>
                                </label>
                                <select name="periode" id="periode"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    onchange="togglePeriodeInputs(this.value)">
                                    <option value="">-- Pilih Periode --</option>
                                    <option value="tanggal" {{ request('periode') == 'tanggal' ? 'selected' : '' }}>Per Tanggal</option>
                                    <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Per Bulan</option>
                                </select>
                            </div>

                            {{-- Input Per Tanggal --}}
                            <div id="input-tanggal" class="hidden md:col-span-2">
                                <div class="flex flex-wrap gap-4">
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                        <input type="date" name="dari_tanggal"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            value="{{ request('dari_tanggal') }}">
                                    </div>
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                        <input type="date" name="sampai_tanggal"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            value="{{ request('sampai_tanggal') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Input Per Bulan --}}
                            <div id="input-bulan" class="hidden md:col-span-2">
                                <div class="flex flex-wrap gap-4">
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                                        <select name="bulan"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                            <option value="">-- Pilih Bulan --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="flex-1 min-w-[200px]">
                                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                                        <input type="number" name="tahun" min="2020" max="2099"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            value="{{ request('tahun', now()->year) }}">
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3 pt-4">
                            <button type="submit"
                                class="px-6 py-2 text-sm font-medium text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                Tampilkan Laporan
                            </button>
                            @if (request()->hasAny(['student_id', 'kelas_tahfidz_id', 'periode']))
                                <a href="{{ route('teacher.laporan.index') }}"
                                    class="px-6 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if ($selectedStudent)
                    {{-- Student Info Card --}}
                    <div class="p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                                    {{ $selectedStudent->user->name }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedStudent->user->email }}</p>
                                @if ($selectedStudent->kelas)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Kelas:
                                        {{ $selectedStudent->kelas->tingkatan ? 'Kelas ' . $selectedStudent->kelas->tingkatan . ' - ' . $selectedStudent->kelas->nama : $selectedStudent->kelas->nama }}
                                    </p>
                                @endif
                                @if (request('periode'))
                                    <p class="mt-1 text-xs text-indigo-600 dark:text-indigo-400">
                                        Periode:
                                        @if (request('periode') == 'bulan')
                                            {{ \Carbon\Carbon::create()->month(request('bulan'))->translatedFormat('F') }} {{ request('tahun') }}
                                        @elseif (request('periode') == 'tanggal')
                                            {{ \Carbon\Carbon::parse(request('dari_tanggal'))->format('d M Y') }} &ndash;
                                            {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->format('d M Y') }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('teacher.laporan.cetak', request()->all()) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Cetak Laporan (PDF)
                                </a>
                                <a href="{{ route('teacher.laporan.index') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300">
                                    Pilih Siswa Lain
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Assessment Table --}}
                    <div class="bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Riwayat Penilaian</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Total: {{ $penilaian->count() }} penilaian
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="w-10 px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Surah & Ayat</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Jenis Penilaian</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Jenis Hafalan</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Tanggal</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">Tajwid</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">Harakat</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">Makhraj</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">Total</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-400">Predikat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @php $rowNumber = 1; @endphp
                                    @forelse ($penilaian as $item)
                                        @php
                                            $surahsToDisplay = collect();
                                            if ($item->jenis_penilaian === 'langsung') {
                                                $surahsToDisplay = $item->surahHafalanPenilaian ?? collect();
                                            } elseif ($item->jenis_penilaian === 'pengumpulan' && $item->tugasHafalan) {
                                                $surahsToDisplay = $item->tugasHafalan->surahHafalan ?? collect();
                                            }
                                        @endphp

                                        @if ($surahsToDisplay->isNotEmpty())
                                            @foreach ($surahsToDisplay as $loop2 => $surahHafalan)
                                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    {{-- Nomor hanya ditampilkan di baris pertama per penilaian --}}
                                                    @if ($loop2 === 0)
                                                        <td class="px-4 py-3 text-sm text-center text-gray-500" rowspan="{{ $surahsToDisplay->count() }}">
                                                            {{ $rowNumber++ }}
                                                        </td>
                                                    @endif
                                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                                        <div class="font-medium">{{ $surahHafalan->surah->nama ?? 'N/A' }}</div>
                                                        <div class="text-xs text-gray-500">Ayat {{ $surahHafalan->ayat_awal }}–{{ $surahHafalan->ayat_akhir }}</div>
                                                    </td>
                                                    @if ($loop2 === 0)
                                                        <td class="px-4 py-3 text-sm capitalize" rowspan="{{ $surahsToDisplay->count() }}">
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                                @if ($item->jenis_penilaian === 'langsung') bg-blue-100 text-blue-800
                                                                @else bg-purple-100 text-purple-800 @endif">
                                                                {{ $item->jenis_penilaian }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-3 text-sm capitalize dark:text-gray-100" rowspan="{{ $surahsToDisplay->count() }}">
                                                            {{ $item->jenis_hafalan }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100" rowspan="{{ $surahsToDisplay->count() }}">
                                                            {{ \Carbon\Carbon::parse($item->assessed_at)->translatedFormat('d M Y') }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm font-medium text-center" rowspan="{{ $surahsToDisplay->count() }}">{{ $item->nilai_tajwid }}</td>
                                                        <td class="px-4 py-3 text-sm font-medium text-center" rowspan="{{ $surahsToDisplay->count() }}">{{ $item->nilai_harakat }}</td>
                                                        <td class="px-4 py-3 text-sm font-medium text-center" rowspan="{{ $surahsToDisplay->count() }}">{{ $item->nilai_makhraj }}</td>
                                                        <td class="px-4 py-3 text-sm font-bold text-center text-indigo-600" rowspan="{{ $surahsToDisplay->count() }}">{{ $item->nilai_total }}</td>
                                                        <td class="px-4 py-3 text-sm text-center" rowspan="{{ $surahsToDisplay->count() }}">
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                                @if ($item->nilai_total >= 90) bg-green-100 text-green-800
                                                                @elseif($item->nilai_total >= 80) bg-blue-100 text-blue-800
                                                                @elseif($item->nilai_total >= 70) bg-yellow-100 text-yellow-800
                                                                @else bg-red-100 text-red-800 @endif">
                                                                {{ $item->predikat_label }}
                                                            </span>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3 text-sm text-center text-gray-500">{{ $rowNumber++ }}</td>
                                                <td class="px-4 py-3 text-sm italic text-gray-400">Surah tidak tersedia</td>
                                                <td class="px-4 py-3 text-sm capitalize">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                        @if ($item->jenis_penilaian === 'langsung') bg-blue-100 text-blue-800
                                                        @else bg-purple-100 text-purple-800 @endif">
                                                        {{ $item->jenis_penilaian }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm capitalize">{{ $item->jenis_hafalan }}</td>
                                                <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($item->assessed_at)->translatedFormat('d M Y') }}</td>
                                                <td class="px-4 py-3 text-sm text-center">{{ $item->nilai_tajwid }}</td>
                                                <td class="px-4 py-3 text-sm text-center">{{ $item->nilai_harakat }}</td>
                                                <td class="px-4 py-3 text-sm text-center">{{ $item->nilai_makhraj }}</td>
                                                <td class="px-4 py-3 text-sm font-bold text-center text-indigo-600">{{ $item->nilai_total }}</td>
                                                <td class="px-4 py-3 text-sm text-center">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
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
                                            <td colspan="10" class="px-4 py-12 text-center text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="font-medium">Tidak ada data penilaian pada periode ini</p>
                                                <p class="text-sm">Coba ubah filter periode</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Ringkasan Statistik --}}
                    @if ($penilaian->isNotEmpty())
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            @php
                                $avgTotal = $penilaian->avg('nilai_total');
                                $maxTotal = $penilaian->max('nilai_total');
                                $minTotal = $penilaian->min('nilai_total');
                                $countA = $penilaian->filter(fn($p) => $p->nilai_total >= 90)->count();
                            @endphp
                            <div class="p-4 text-center bg-white shadow rounded-xl">
                                <div class="text-2xl font-bold text-indigo-600">{{ number_format($avgTotal, 1) }}</div>
                                <div class="mt-1 text-xs text-gray-500">Rata-rata Nilai</div>
                            </div>
                            <div class="p-4 text-center bg-white shadow rounded-xl">
                                <div class="text-2xl font-bold text-green-600">{{ $maxTotal }}</div>
                                <div class="mt-1 text-xs text-gray-500">Nilai Tertinggi</div>
                            </div>
                            <div class="p-4 text-center bg-white shadow rounded-xl">
                                <div class="text-2xl font-bold text-red-500">{{ $minTotal }}</div>
                                <div class="mt-1 text-xs text-gray-500">Nilai Terendah</div>
                            </div>
                            {{-- <div class="p-4 text-center bg-white shadow rounded-xl">
                                <div class="text-2xl font-bold text-yellow-600">{{ $countA }}</div>
                                <div class="mt-1 text-xs text-gray-500">Predikat A (≥90)</div>
                            </div> --}}
                        </div>
                    @endif

                @else
                    {{-- Empty State --}}
                    <div class="p-8 text-center bg-white shadow-md rounded-xl dark:bg-gray-800">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Pilih Siswa untuk Melihat Laporan</h3>
                        <p class="text-sm text-gray-500">Lengkapi semua filter di atas lalu klik <strong>Tampilkan Laporan</strong></p>
                    </div>
                @endif

            </main>
        </div>
    </div>

    <script>
        // =============================================
        // Toggle input periode — hanya tanggal & bulan
        // =============================================
        function togglePeriodeInputs(selected) {
            ['tanggal', 'bulan'].forEach(type => {
                const el = document.getElementById('input-' + type);
                if (el) el.classList.toggle('hidden', selected !== type);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            togglePeriodeInputs(document.getElementById('periode').value);

            // =============================================
            // AJAX: Load siswa berdasarkan kelas
            // =============================================
            const kelasSelect = document.getElementById('kelas_tahfidz_id');
            const studentSelect = document.getElementById('student_id');
            const selectedStudentId = "{{ request('student_id') }}";

            function loadSiswa(kelasId, preselectId) {
                studentSelect.innerHTML = '<option value="">Memuat siswa...</option>';
                studentSelect.disabled = true;

                if (!kelasId) {
                    studentSelect.innerHTML = '<option value="">-- Pilih kelas dahulu --</option>';
                    studentSelect.disabled = false;
                    return;
                }

                fetch(`{{ route('teacher.laporan.siswa-by-kelas') }}?kelas_tahfidz_id=${kelasId}`)
                    .then(res => res.json())
                    .then(data => {
                        studentSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                        data.forEach(siswa => {
                            const opt = document.createElement('option');
                            opt.value = siswa.id;
                            opt.textContent = siswa.name;
                            if (String(siswa.id) === String(preselectId)) opt.selected = true;
                            studentSelect.appendChild(opt);
                        });
                        studentSelect.disabled = false;
                    })
                    .catch(() => {
                        studentSelect.innerHTML = '<option value="">Gagal memuat siswa</option>';
                        studentSelect.disabled = false;
                    });
            }

            kelasSelect.addEventListener('change', function () {
                loadSiswa(this.value, null);
            });

            // Kalau halaman di-load dengan kelas sudah terpilih (dari request sebelumnya)
            if (kelasSelect.value) {
                loadSiswa(kelasSelect.value, selectedStudentId);
            }
        });
    </script>
</x-app-layout>
