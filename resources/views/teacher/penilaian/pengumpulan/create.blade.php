<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <!-- Header -->
                <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('teacher.pengumpulan.index') }}"
                                class="hover:text-indigo-600 dark:hover:text-indigo-400">Pengumpulan</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Nilai</span>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Nilai Hafalan Siswa</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Menilai hafalan siswa berdasarkan tugas
                            yang telah dikumpulkan.</p>
                    </div>
                    <a href="{{ route('teacher.pengumpulan.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                @if (session('success'))
                    <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 alert alert-success"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 alert alert-error"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div
                    class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Detail Pengumpulan</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Siswa:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $pengumpulan->siswa->user->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tugas Hafalan:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{-- {{ $pengumpulan->surahHafalan?->surah?->nama ?? 'N/A' }}
                                @if ($pengumpulan->surahHafalan?->ayat_awal && $pengumpulan->surahHafalan?->ayat_akhir)
                                    ({{ $pengumpulan->surahHafalan->ayat_awal }}–{{ $pengumpulan->surahHafalan->ayat_akhir }})
                                @endif --}}
                                @foreach ($pengumpulan->tugasHafalan->surahHafalan as $surah)
                                    {{ $surah->nama }}
                                    ({{ $surah->ayat_awal }}-{{ $surah->ayat_akhir }})
                                    <br>
                                @endforeach
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Siswa:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $pengumpulan->siswa->user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Tugas:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ Ucfirst($pengumpulan->tugasHafalan->jenis_tugas ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Deadline:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($pengumpulan->tugasHafalan->tenggat_waktu)->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>

                        @if ($pengumpulan->file_pengumpulan)
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">File Pengumpulan:</p>
                                <a href="{{ route('teacher.pengumpulan.download', $pengumpulan) }}"
                                    class="inline-flex items-center text-sm text-blue-600 underline hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Download File
                                </a>
                            </div>
                        @else
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">File Pengumpulan:</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">Tidak ada file terlampir.</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pengumpulan:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($pengumpulan->submitted_at ?? $pengumpulan->created_at)->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            {{-- <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Rekaman Hafalan:</p>
                            <audio controls class="w-full mt-2 rounded-lg">
                                <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                    type="audio/webm" />
                                Browser Anda tidak mendukung audio.
                            </audio> --}}
                            {{-- Audio Player --}}
                            @if (
                                $pengumpulan->file_pengumpulan &&
                                    (pathinfo($pengumpulan->file_pengumpulan, PATHINFO_EXTENSION) == 'mp3' ||
                                        pathinfo($pengumpulan->file_pengumpulan, PATHINFO_EXTENSION) == 'webm'))
                                <div>
                                    <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Rekaman
                                        Hafalan:</p>
                                    <audio controls class="w-full mt-2 rounded-lg">
                                        <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                            type="audio/{{ pathinfo($pengumpulan->file_pengumpulan, PATHINFO_EXTENSION) }}" />
                                        Browser Anda tidak mendukung elemen audio.
                                    </audio>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div
                    class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Form Penilaian</h2>


                    <form action="{{ route('teacher.penilaian.pengumpulan.store', $pengumpulan) }}" method="POST">
                        @csrf

                        <!-- Hidden Inputs for Penilaian Model -->
                        <input type="hidden" name="student_id" value="{{ $pengumpulan->student_id }}">
                        <input type="hidden" name="guru_id" value="{{ Auth::user()->guru->id }}">
                        <input type="hidden" name="tugas_hafalan_id" value="{{ $pengumpulan->tugas_hafalan_id }}">
                        <input type="hidden" name="jenis_penilaian" value="pengumpulan">
                        <input type="hidden" name="jenis_hafalan"
                            value="{{ $pengumpulan->tugasHafalan->jenis_tugas ?? 'N/A' }}">

                        <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-3"> {{-- Changed to lg:grid-cols-3 --}}
                            <div>
                                <label for="nilai_tajwid"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Tajwid
                                    (0-100)</label>
                                <input type="number" name="nilai_tajwid" id="nilai_tajwid" min="0"
                                    max="100" value="{{ old('nilai_tajwid') }}"
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                @error('nilai_tajwid')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="nilai_harakat"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Harakat
                                    (0-100)</label>
                                <input type="number" name="nilai_harakat" id="nilai_harakat" min="0"
                                    max="100" value="{{ old('nilai_harakat') }}"
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                @error('nilai_harakat')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="nilai_makhraj"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Makhraj
                                    (0-100)</label>
                                <input type="number" name="nilai_makhraj" id="nilai_makhraj" min="0"
                                    max="100" value="{{ old('nilai_makhraj') }}"
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                @error('nilai_makhraj')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="catatan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Opsional)</label>
                            <textarea name="catatan" id="catatan" rows="4"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Simpan Penilaian
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
