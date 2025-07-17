<x-app-layout>
    <div class="flex min-h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-guru />
        </x-slot>

        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-y-auto md:p-6">
            <div class="mx-auto max-w-7xl">
                <!-- Header Section -->
                <div class="flex flex-col items-start justify-between gap-4 mb-10 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800 md:text-2xl">Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">Kelola tugas hafalan, penilaian, dan laporan siswa Anda.
                        </p>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="p-4 text-white transition transform shadow-md sm:p-5 rounded-xl bg-gradient-to-r from-indigo-300 to-indigo-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Tugas Hafalan Aktif</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $totalTugasAktif }}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 opacity-50" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-gradient-to-r from-yellow-300 to-yellow-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Pengumpulan Hari Ini</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $totalPengumpulanHariIni }}</p>
                            </div>
                            <div>
                                <svg class="w-10 h-10 opacity-50" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-gradient-to-r from-red-300 to-red-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Penilaian Tertunda</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $totalPenilaianTertunda }}</p>
                            </div>
                            <div>
                                <svg class="w-10 h-10 opacity-50" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2" />
                                    <rect x="9" y="3" width="6" height="4" rx="2" />
                                    <path d="M9 14l2 2l4 -4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="bg-white shadow rounded-xl">
                    <div class="p-5 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Pengumpulan Hari Ini</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Siswa</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Kelas</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Tugas</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Waktu Submit</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pengumpulanHariIni as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $submission->siswa->user->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if ($submission->is_for_all_student)
                                                    {{-- Jika tugas ini untuk semua siswa di kelas (berdasarkan 'is_for_all_student') --}}
                                                    @if ($submission->kelasTahfidz)
                                                        {{-- Pastikan relasi kelasTahfidz sudah dimuat dan tidak null --}}
                                                        Kelas: {{ $submission->kelasTahfidz->tingkatan_label }} -
                                                        {{ $submission->kelasTahfidz->nama ?? 'Nama Kelas Tidak Ada' }}
                                                    @else
                                                        Kelas tidak ditemukan.
                                                    @endif
                                                    @else
                                                    {{-- Jika tugas ini untuk siswa individu --}}
                                                    {{-- CHANGE THIS LINE: from $submission->siswa->isNotEmpty() to $submission->siswa --}}
                                                    @if ($submission->siswa) {{-- Check if the student model exists (is not null) --}}
                                                        {{-- If $submission->siswa is a single Student model, then remove the @foreach here too --}}
                                                        {{-- The outer @foreach ($submission->siswa as $student) loop should only exist if $submission->siswa is a collection --}}

                                                        {{-- Scenario 1: $submission->siswa is a single Student model --}}
                                                        {{-- If 'siswa' is a belongsTo relationship (one submission belongs to one student) --}}
                                                        {{ $submission->siswa->user->name ?? 'Nama Tidak Ada' }}
                                                        @if ($submission->siswa->kelasTahfidz->isNotEmpty()) {{-- Assuming kelasTahfidz is a hasMany/belongsToMany relationship on Student --}}
                                                            (@foreach ($submission->siswa->kelasTahfidz as $kelas)
                                                                {{ $kelas->tingkatan_label }} -
                                                                {{ $kelas->nama ?? 'N/A' }}@unless ($loop->last)
                                                                    ,
                                                                @endunless
                                                            @endforeach)
                                                        @else
                                                            (Tidak ada Kelas)
                                                        @endif
                                                    @else
                                                        Tidak ada siswa dituju. {{-- Ini akan muncul jika is_for_all_student false tapi siswa kosong --}}
                                                    @endif
                                                @endif
                                        </div>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $submission->tugasHafalan->nama ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $submission->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = '';
                                            switch ($submission->status) {
                                                case 'dikumpulkan':
                                                    $statusClass =
                                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'dinilai':
                                                    $statusClass =
                                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                                                    break;
                                                default:
                                                    $statusClass =
                                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                        @endphp
                                        <span
                                            class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">Tidak
                                            ada pengumpulan hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t">
                        <a href="{{ route('teacher.pengumpulan.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat semua pengumpulan
                            →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
