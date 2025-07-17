<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <div class="w-full overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('teacher.penilaian.langsung.index') }}"
                               class="hover:text-indigo-600 dark:hover:text-indigo-400">Penilaian</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Detail</span>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Detail Penilaian Langsung</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat detail hasil penilaian langsung siswa.</p>
                    </div>
                    <a href="{{ route('teacher.penilaian.langsung.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Siswa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->siswa->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Siswa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->siswa->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru Penilai</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->guru->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Hafalan</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize dark:text-white">{{ $penilaian->jenis_hafalan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai Tajwid</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->nilai_tajwid }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai Harakat</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->nilai_harakat }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai Makhraj</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->nilai_makhraj }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai Total</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->nilai_total }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Predikat</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->predikat_label }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Surah & Ayat</dt>
                            <dd class="mt-1 space-y-1">
                                @forelse ($penilaian->surahHafalanPenilaian as $surah)
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $surah->surah->nama }}: Ayat {{ $surah->ayat_awal }}–{{ $surah->ayat_akhir }}
                                    </div>
                                @empty
                                    <p class="italic text-gray-400">Tidak ada surah dicatat</p>
                                @endforelse
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $penilaian->catatan ?: '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Penilaian</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($penilaian->assessed_at)->translatedFormat('d F Y H:i') }} WIB
                            </dd>
                        </div>
                    </dl>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
