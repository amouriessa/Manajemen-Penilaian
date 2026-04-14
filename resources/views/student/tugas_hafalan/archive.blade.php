<x-app-layout>
    <div class="flex min-h-screen overflow-hidden">

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-6xl px-4 py-6 mx-auto md:px-6">

                {{-- ===== BREADCRUMB + HEADER ===== --}}
                <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex items-center gap-1.5 mb-2 text-xs text-[#8C8070]">
                            <a href="{{ route('student.tugas_hafalan.index') }}"
                                class="hover:text-[#2D3F63] transition">Tugas Hafalan</a>
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="font-medium text-[#3A3028]">Arsip Tugas</span>
                        </div>
                        <h2 class="font-serif text-2xl font-bold text-textBody">Arsip Tugas Hafalan</h2>
                        <p class="mt-1 text-sm text-indigo-600">Tugas yang sudah dinilai lebih dari 3 hari.</p>
                        <div class="w-16 h-0.5 bg-indigo-600 rounded-full mt-3"></div>
                    </div>

                    <a href="{{ route('student.tugas_hafalan.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                {{-- ===== ALERTS ===== --}}
                @if (session('success'))
                    <div id="success-alert"
                        class="flex items-center gap-3 p-4 mb-5 text-sm rounded-xl bg-[#EAF2EE] text-[#5C8270] border border-[#5C8270]/20">
                        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><span class="font-semibold">Berhasil!</span> {{ session('success') }}</span>
                        <button onclick="document.getElementById('success-alert').remove()"
                            class="ml-auto text-[#5C8270] hover:text-[#3A3028]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-alert"
                        class="flex items-center gap-3 p-4 mb-5 text-sm rounded-xl bg-[#F9ECEC] text-[#B5655A] border border-[#B5655A]/20">
                        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><span class="font-semibold">Error!</span> {{ session('error') }}</span>
                        <button onclick="document.getElementById('error-alert').remove()"
                            class="ml-auto text-[#B5655A] hover:text-[#8B4040]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- ===== MAIN CARD ===== --}}
                <div class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-md rounded-xl">
                    <div class="h-1 w-full bg-[linear-gradient(90deg,#2D3F63_0%,#D4A355_50%,#B5655A_100%)]"></div>

                    <div class="p-6">

                        {{-- Section Header --}}
                        {{-- <div class="flex items-center gap-3 pb-4 mb-6 border-b border-[#E5DED6]">
                            <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#2D3F63]">
                                <svg class="w-4 h-4 text-[#FDFAF5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-serif text-base font-bold text-textBody">Daftar Arsip</h3>
                                <p class="text-xs text-[#8C8070]">Riwayat tugas yang telah dinilai</p>
                            </div>
                        </div> --}}

                        {{-- ===== SEARCH & FILTER ===== --}}
                        <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-end md:justify-between">

                            <!-- SEARCH -->
                            <div class="w-full md:w-1/2 lg:w-1/3">
                                <form method="GET" action="{{ route('student.tugas_hafalan.archive') }}"
                                    class="relative">
                                    <div class="flex items-center">

                                        <!-- Icon -->
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-[#8C8070]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>

                                        <!-- Input -->
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Cari surah atau tugas..."
                                            class="w-full py-2.5 pl-10 pr-20 text-sm text-[#3A3028] bg-[#FDFAF5]
                        border border-[#E5DED6] rounded-lg placeholder-[#C4B8A8]
                        focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/30 focus:border-[#2D3F63]">

                                        <!-- Reset -->
                                        @if (request('search') || request('tanggal_awal') || request('tanggal_akhir'))
                                            <a href="{{ route('student.tugas_hafalan.archive') }}"
                                                class="absolute text-xs text-[#8C8070] right-16 hover:text-[#B5655A]">
                                                Reset
                                            </a>
                                        @endif

                                        <!-- Button -->
                                        <button type="submit"
                                            class="absolute inset-y-0 right-0 flex items-center px-3 text-sm font-medium text-[#2D3F63] hover:text-[#1E2A40] border-l border-[#E5DED6]">
                                            Cari
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- FILTER DATE -->
                            <form method="GET" action="{{ route('student.tugas_hafalan.archive') }}">
                                <div class="flex flex-wrap items-end gap-3">

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-[#8C8070]">Dari</label>
                                        <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                                            class="px-3 py-2.5 text-sm text-[#3A3028] bg-[#FDFAF5]
                        border border-[#E5DED6] rounded-lg
                        focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/30 focus:border-[#2D3F63]">
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-[#8C8070]">Sampai</label>
                                        <input type="date" name="tanggal_akhir"
                                            value="{{ request('tanggal_akhir') }}"
                                            class="px-3 py-2.5 text-sm text-[#3A3028] bg-[#FDFAF5]
                        border border-[#E5DED6] rounded-lg
                        focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/30 focus:border-[#2D3F63]">
                                    </div>

                                    <!-- Submit filter -->
                                    <button type="submit"
                                        class="px-4 py-2.5 text-sm font-semibold text-white bg-[#2D3F63] rounded-lg hover:bg-[#1E2A40] transition">
                                        Terapkan
                                    </button>

                                    <!-- Reset -->
                                    @if (request('tanggal_awal') || request('tanggal_akhir'))
                                        <a href="{{ route('student.tugas_hafalan.archive', request('search') ? ['search' => request('search')] : []) }}"
                                            class="inline-flex items-center px-3 py-2.5 text-sm text-gray-500
                        border border-[#E5DED6] rounded-lg bg-[#FDFAF5]
                        hover:bg-[#ffffff] hover:text-red-500 transition">
                                            Reset
                                        </a>
                                    @endif

                                </div>
                            </form>

                        </div>

                        {{-- ===== TABLE ===== --}}
                        @if ($tugas->count() > 0)
                            <div class="overflow-x-auto rounded-xl border border-[#E5DED6]">
                                <table class="min-w-full divide-y divide-[#E5DED6]">
                                    <thead>
                                        <tr class="bg-[#FDFAF5]">
                                            @foreach (['Surah', 'Ayat', 'Tenggat', 'Dinilai', 'Audio', 'Aksi'] as $col)
                                                <th
                                                    class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-left text-[#8C8070]">
                                                    {{ $col }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#E5DED6] bg-[#FDFAF5]">
                                        @foreach ($tugas as $task)
                                            <tr class="hover:bg-[#FDFAF5] transition">

                                                {{-- Surah --}}
                                                <td class="px-4 py-3">
                                                    @foreach ($task->surahHafalan as $item)
                                                        <span
                                                            class="block font-serif text-sm font-semibold text-textBody">
                                                            {{ $item->surah->nama }}
                                                        </span>
                                                    @endforeach
                                                </td>

                                                {{-- Ayat --}}
                                                <td class="px-4 py-3">
                                                    @foreach ($task->surahHafalan as $item)
                                                        <span class="block text-sm text-[#3A3028]">
                                                            {{ $item->ayat_awal }}–{{ $item->ayat_akhir }}
                                                        </span>
                                                    @endforeach
                                                </td>

                                                {{-- Tenggat --}}
                                                <td class="px-4 py-3 text-sm text-[#3A3028] whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($task->tenggat_waktu)->translatedFormat('d M Y') }}
                                                </td>

                                                {{-- Dinilai --}}
                                                <td class="px-4 py-3 text-sm text-[#3A3028] whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($task->assessmentDate)->translatedFormat('d M Y') }}
                                                </td>

                                                {{-- Audio --}}
                                                <td class="px-4 py-3">
                                                    @if ($task->submission && $task->submission->file_pengumpulan)
                                                        <div class="flex flex-col gap-1.5">
                                                            <audio controls preload="none" class="h-8 rounded-lg w-44"
                                                                style="accent-color:#2D3F63">
                                                                <source
                                                                    src="{{ asset('storage/' . $task->submission->file_pengumpulan) }}"
                                                                    type="audio/webm">
                                                                <source
                                                                    src="{{ asset('storage/' . $task->submission->file_pengumpulan) }}"
                                                                    type="audio/mpeg">
                                                                Browser tidak mendukung pemutar audio.
                                                            </audio>
                                                            <a href="{{ asset('storage/' . $task->submission->file_pengumpulan) }}"
                                                                download="Hafalan_{{ Str::slug($task->surahHafalan->first()?->surah->nama ?? 'audio') }}.webm"
                                                                class="inline-flex items-center gap-1 text-xs font-medium text-[#2D3F63] hover:text-[#1E2A40] transition">
                                                                <svg class="w-3 h-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                Unduh
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-xs italic text-[#C4B8A8]">—</span>
                                                    @endif
                                                </td>

                                                {{-- Aksi --}}
                                                <td class="px-4 py-3">
                                                    @if ($task->submission)
                                                        <a href="{{ route('student.pengumpulan.show', $task->submission->id) }}"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition whitespace-nowrap">
                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                            Lihat Nilai
                                                        </a>
                                                    @else
                                                        <span class="text-xs italic text-[#C4B8A8]">—</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- ===== PAGINATION ===== --}}
                            @if ($tugas->hasPages())
                                <div class="flex items-center justify-center gap-1 mt-6">
                                    {{-- Prev --}}
                                    @if ($tugas->onFirstPage())
                                        <span
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm rounded-lg text-[#C4B8A8] bg-[#FDFAF5] border border-[#E5DED6] cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $tugas->previousPageUrl() }}"
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm rounded-lg text-[#3A3028] bg-[#FDFAF5] border border-[#E5DED6] hover:bg-[#FDFAF5] transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pages --}}
                                    @foreach ($tugas->getUrlRange(max(1, $tugas->currentPage() - 2), min($tugas->lastPage(), $tugas->currentPage() + 2)) as $page => $url)
                                        @if ($page == $tugas->currentPage())
                                            <span
                                                class="inline-flex items-center justify-center w-9 h-9 text-sm font-semibold rounded-lg text-white bg-[#2D3F63]">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="inline-flex items-center justify-center w-9 h-9 text-sm rounded-lg text-[#3A3028] bg-[#FDFAF5] border border-[#E5DED6] hover:bg-[#FDFAF5] transition">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next --}}
                                    @if ($tugas->hasMorePages())
                                        <a href="{{ $tugas->nextPageUrl() }}"
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm rounded-lg text-[#3A3028] bg-[#FDFAF5] border border-[#E5DED6] hover:bg-[#FDFAF5] transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm rounded-lg text-[#C4B8A8] bg-[#FDFAF5] border border-[#E5DED6] cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-3 text-xs text-center text-[#8C8070]">
                                    Menampilkan {{ $tugas->firstItem() }}–{{ $tugas->lastItem() }} dari
                                    {{ $tugas->total() }} arsip
                                </p>
                            @endif
                        @else
                            {{-- ===== EMPTY STATE ===== --}}
                            <div class="py-16 text-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-2xl">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 font-serif text-lg font-bold text-textBody">
                                    @if (request('search') || request('tanggal_awal') || request('tanggal_akhir'))
                                        Tidak Ada Hasil
                                    @else
                                        Belum Ada Arsip
                                    @endif
                                </h3>
                                <p class="max-w-xs mx-auto mb-6 text-sm text-gray-500">
                                    @if (request('search') || request('tanggal_awal') || request('tanggal_akhir'))
                                        Tidak ditemukan arsip yang sesuai dengan filter pencarian Anda.
                                    @else
                                        Tugas yang sudah dinilai lebih dari 3 hari akan muncul di sini secara otomatis.
                                    @endif
                                </p>
                                @if (request('search') || request('tanggal_awal') || request('tanggal_akhir'))
                                    {{-- <a href="{{ route('student.tugas_hafalan.archive') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-[#8C8070] rounded-lg bg-[#FDFAF5] border border-[#E5DED6] hover:bg-[#EDD9B0] transition">
                                        Reset Filter
                                    </a> --}}
                                @else
                                    <a href="{{ route('student.tugas_hafalan.index') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm">
                                        Lihat Tugas Aktif
                                    </a>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>

                <div class="pb-8"></div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            setTimeout(() => {
                ['success-alert', 'error-alert'].forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.style.transition = 'opacity 1s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 1000);
                });
            }, 5000);
        </script>
    @endpush
</x-app-layout>
