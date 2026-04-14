<x-app-layout>
    <div class="flex min-h-screen overflow-hidden">

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-5xl px-4 py-6 mx-auto md:px-6">

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
                            <span class="font-medium text-[#3A3028]">Detail Tugas</span>
                        </div>
                        <h2 class="font-serif text-2xl font-bold text-textBody">Detail Tugas Hafalan</h2>
                        <p class="mt-1 text-sm text-indigo-600">Informasi lengkap dan hasil penilaian tugas Anda.</p>
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

                {{-- ===== MAIN GRID ===== --}}
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- ===== LEFT: TASK INFO ===== --}}
                    <div class="space-y-6 lg:col-span-2">

                        {{-- Info Tugas --}}
                        <div class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-md rounded-xl">
                            <div class="h-1 w-full bg-[linear-gradient(90deg,#2D3F63_0%,#D4A355_50%,#B5655A_100%)]">
                            </div>

                            <div class="p-6">
                                {{-- Section title --}}
                                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-[#E5DED6]">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#2D3F63]">
                                        <svg class="w-4 h-4 text-[#F7EDDA]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-serif text-base font-bold text-textBody">Informasi Tugas</h3>
                                        <p class="text-xs text-[#8C8070]">Detail lengkap tugas hafalan</p>
                                    </div>
                                </div>

                                {{-- Nama Surah --}}
                                <div class="mb-4 p-4 rounded-lg bg-[#e8f0fc] border border-[#E5DED6]">
                                    <p class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">Nama Surah</p>
                                    <p class="font-serif text-lg font-bold text-textBody">
                                        @foreach ($pengumpulan->tugasHafalan->surahHafalan as $item)
                                            {{ $item->surah->nama }}
                                            <span class="text-sm font-normal text-[#8C8070]">(Ayat {{ $item->ayat_awal }}–{{ $item->ayat_akhir }})</span>@unless($loop->last), @endunless
                                        @endforeach
                                    </p>
                                </div>

                                {{-- Grid Detail --}}
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="p-4 rounded-lg bg-[#e8f0fc] border border-[#E5DED6]">
                                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">Jenis
                                            Tugas</p>
                                        <p class="text-sm font-semibold text-[#3A3028]">
                                            {{ ucfirst($tugasHafalan->jenis_tugas) }}</p>
                                    </div>

                                    <div class="p-4 rounded-lg bg-[#e8f0fc] border border-[#E5DED6]">
                                        @php
                                            $deadline = \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->endOfDay();
                                            $isLate = now()->greaterThan($deadline);
                                        @endphp
                                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                            Deadline</p>
                                        <p
                                            class="text-sm font-semibold {{ $isLate ? 'text-[#B5655A]' : 'text-[#3A3028]' }}">
                                            {{ \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->translatedFormat('d M Y') }}
                                        </p>
                                        @if ($isLate)
                                            <span
                                                class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 text-xs font-medium rounded-full bg-[#fcd2d2] text-[#B5655A]">
                                                Terlewat
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===== SUBMISSION STATUS ===== --}}
                        @if ($pengumpulan)
                            <div class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-md rounded-xl">
                                <div class="h-1 w-full bg-[linear-gradient(90deg,#5C8270,#D4A355)]"></div>

                                <div class="p-6">
                                    {{-- Section title --}}
                                    <div class="flex items-center gap-3 pb-4 mb-6 border-b border-[#E5DED6]">
                                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5C8270]">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold font-serif text-[#2D3F63]">Status Pengumpulan
                                            </h3>
                                            <p class="text-xs text-[#8C8070]">Tugas telah dikumpulkan</p>
                                        </div>
                                        <span class="ml-auto text-xs text-[#8C8070]">
                                            {{ \Carbon\Carbon::parse($pengumpulan->submitted_at)->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>

                                    {{-- Audio Player --}}
                                    <div class="p-4 mb-4 rounded-xl bg-[#EAF2EE] border border-[#E5DED6]">
                                        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-[#8C8070]">
                                            Audio Hafalan</p>

                                        <audio id="audioPlayer" class="hidden">
                                            <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                                type="audio/mpeg">
                                            <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                                type="audio/wav">
                                            <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                                type="audio/ogg">
                                            <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                                type="audio/webm">
                                        </audio>

                                        {{-- Custom Player --}}
                                        <div class="p-4 rounded-lg bg-[#FDFAF5] border border-[#E5DED6]">
                                            <div class="flex items-center gap-4">

                                                {{-- Play/Pause --}}
                                                <button id="playPauseBtn"
                                                    class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-full bg-[#2D3F63] hover:bg-[#1E2A40] text-white transition shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/40">
                                                    <svg id="playIcon" class="w-5 h-5 ml-0.5" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                    <svg id="pauseIcon" class="hidden w-5 h-5" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                                                    </svg>
                                                </button>

                                                {{-- Progress --}}
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex justify-between mb-1.5 text-xs text-[#8C8070]">
                                                        <span id="currentTime">0:00</span>
                                                        <span id="duration">0:00</span>
                                                    </div>
                                                    <div class="relative h-2">
                                                        <div class="absolute inset-0 rounded-full bg-[#E5DED6]"></div>
                                                        <div id="progressBar"
                                                            class="absolute inset-y-0 left-0 rounded-full bg-[#2D3F63] transition-all duration-100"
                                                            style="width:0%"></div>
                                                        <input id="progressSlider" type="range" min="0"
                                                            max="100" value="0"
                                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                                    </div>
                                                </div>

                                                {{-- Volume --}}
                                                <div class="flex items-center flex-shrink-0 gap-2">
                                                    <button id="muteBtn"
                                                        class="text-[#8C8070] hover:text-[#2D3F63] transition">
                                                        <svg id="volumeIcon" class="w-4 h-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                        </svg>
                                                        <svg id="muteIcon" class="hidden w-4 h-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                                                        </svg>
                                                    </button>
                                                    <input id="volumeSlider" type="range" min="0"
                                                        max="1" step="0.1" value="1"
                                                        class="w-16 h-1 rounded-full appearance-none cursor-pointer bg-[#E5DED6] accent-[#2D3F63]">
                                                </div>
                                            </div>

                                            {{-- Download --}}
                                            <div
                                                class="flex items-center justify-between pt-3 mt-3 border-t border-[#E5DED6]">
                                                <span class="text-xs text-[#8C8070]">File rekaman hafalan</span>
                                                <a href="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                                    download
                                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-[#2D3F63] hover:text-[#1E2A40] transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Unduh Audio
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ===== PENILAIAN ===== --}}
                                    @if ($pengumpulan->penilaian)
                                        <div class="p-5 rounded-xl bg-green-100 border border-[#E5DED6]">
                                            <div class="flex items-center gap-2 pb-4 mb-4 border-b border-[#E5DED6]">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                                <h4 class="text-sm font-bold font-serif text-[#2D3F63]">Hasil Penilaian
                                                </h4>
                                                <span class="ml-auto text-xs text-[#8C8070]">
                                                    Dinilai
                                                    {{ \Carbon\Carbon::parse($pengumpulan->penilaian->assessed_at)->translatedFormat('d M Y') }}
                                                </span>
                                            </div>

                                            {{-- Nilai Total + Predikat --}}
                                            <div class="grid grid-cols-2 gap-4 mb-5">
                                                <div
                                                    class="p-4 text-center rounded-lg bg-[#FDFAF5] border border-[#E5DED6]">
                                                    <p
                                                        class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                        Nilai Total</p>
                                                    <p class="text-2xl font-bold font-serif text-[#2D3F63]">
                                                        {{ $pengumpulan->penilaian->nilai_total }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="p-4 text-center rounded-lg bg-[#FDFAF5] border border-[#E5DED6]">
                                                    <p
                                                        class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                        Predikat</p>
                                                    <p class="text-2xl font-bold font-serif text-[#D4A355]">
                                                        {{ ucwords(str_replace('_', ' ', $pengumpulan->penilaian->predikat)) }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Tabel Nilai --}}
                                            <div class="overflow-hidden rounded-lg border border-[#E5DED6]">
                                                <table class="min-w-full divide-y divide-[#E5DED6]">
                                                    <thead class="bg-[#FDFAF5]">
                                                        <tr>
                                                            <th
                                                                class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-left text-[#8C8070]">
                                                                Aspek Penilaian</th>
                                                            <th
                                                                class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-left text-[#8C8070]">
                                                                Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-[#E5DED6] bg-[#FDFAF5]">
                                                        @php
                                                            $aspek = [
                                                                ['label' => 'Tajwid',  'nilai' => $pengumpulan->penilaian->nilai_tajwid,  'color' => '#2D3F63'],
                                                                ['label' => 'Harakat', 'nilai' => $pengumpulan->penilaian->nilai_harakat, 'color' => '#D4A355'],
                                                                ['label' => 'Makhraj', 'nilai' => $pengumpulan->penilaian->nilai_makhraj, 'color' => '#B5655A'],
                                                            ];
                                                        @endphp
                                                        @foreach ($aspek as $row)
                                                            <tr class="transition">
                                                                <td class="px-5 py-3 text-sm font-medium text-[#3A3028]">{{ $row['label'] }}</td>
                                                                <td class="px-5 py-3">
                                                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white rounded-full"
                                                                        style="background:{{ $row['color'] }}">
                                                                        {{ $row['nilai'] ?? '-' }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Catatan Guru --}}
                                            @if ($pengumpulan->penilaian->catatan)
                                                <div class="mt-4">
                                                    <p
                                                        class="mb-2 text-xs font-semibold uppercase tracking-wide text-[#8C8070]">
                                                        Catatan Guru</p>
                                                    <div class="p-4 rounded-lg bg-[#FDFAF5] border border-[#E5DED6]">
                                                        <p class="text-sm leading-relaxed text-[#3A3028]">
                                                            {{ $pengumpulan->penilaian->catatan }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        {{-- Menunggu Penilaian --}}
                                        <div
                                            class="flex items-center gap-3 p-4 rounded-xl bg-[#EAF2EE] border border-[#D4A355]/30">
                                            <svg class="w-5 h-5 flex-shrink-0 text-[#7A9E8A]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-sm font-medium text-[#7A9E8A]">Menunggu penilaian dari guru.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            {{-- Belum Mengumpulkan --}}
                            <div class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-md rounded-xl">
                                <div class="h-1 w-full bg-[#B5655A]"></div>
                                <div class="p-10 text-center">
                                    <div
                                        class="flex items-center justify-center w-14 h-14 mx-auto mb-4 rounded-2xl bg-[#F9ECEC]">
                                        <svg class="w-7 h-7 text-[#B5655A]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <h3 class="mb-1 font-serif text-lg font-bold text-textBody">Belum Mengumpulkan
                                    </h3>
                                    <p class="text-sm text-gray-500">Anda belum mengumpulkan tugas ini.</p>
                                    <a href="{{ route('student.tugas_hafalan.index') }}"
                                        class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm">
                                        Kumpulkan Sekarang
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- ===== RIGHT: GURU INFO ===== --}}
                    <div class="space-y-6">
                        <div class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-md rounded-xl">
                            <div class="h-1 w-full bg-[linear-gradient(90deg,#D4A355,#B5655A)]"></div>

                            <div class="p-5">
                                <div class="flex items-center gap-3 pb-4 mb-4 border-b border-[#E5DED6]">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#D4A355]">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-serif text-sm font-bold text-textBody">Pembuat Tugas</h3>
                                        <p class="text-xs text-[#8C8070]">Informasi guru</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="p-3 rounded-lg bg-[#F7EDDA] border border-[#E5DED6]">
                                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">Nama
                                            Guru</p>
                                        <p class="text-sm font-semibold text-[#3A3028]">
                                            {{ $tugasHafalan->guru->user->name ?? 'N/A' }}</p>
                                    </div>

                                    <div class="p-3 rounded-lg bg-[#F7EDDA] border border-[#E5DED6]">
                                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                            Dibuat Pada</p>
                                        <p class="text-sm text-[#3A3028]">
                                            {{ $tugasHafalan->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </div>

                                    {{-- Status badge --}}
                                    <div class="p-3 rounded-lg bg-[#F7EDDA] border border-[#E5DED6]">
                                        <p class="mb-2 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                            Status</p>
                                        @if ($pengumpulan?->penilaian)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-[#EAF2EE] text-[#5C8270]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#5C8270]"></span>
                                                Sudah Dinilai
                                            </span>
                                        @elseif ($pengumpulan)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-[#FDF6EC] text-[#B07833]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#D4A355]"></span>
                                                Menunggu Penilaian
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-[#F9ECEC] text-[#B5655A]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#B5655A]"></span>
                                                Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('audioPlayer');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const playIcon = document.getElementById('playIcon');
            const pauseIcon = document.getElementById('pauseIcon');
            const progressBar = document.getElementById('progressBar');
            const progressSlider = document.getElementById('progressSlider');
            const currentTimeEl = document.getElementById('currentTime');
            const durationEl = document.getElementById('duration');
            const muteBtn = document.getElementById('muteBtn');
            const volumeIcon = document.getElementById('volumeIcon');
            const muteIcon = document.getElementById('muteIcon');
            const volumeSlider = document.getElementById('volumeSlider');

            if (!audio) return;

            function fmt(s) {
                const m = Math.floor(s / 60);
                const sec = Math.floor(s % 60);
                return `${m}:${String(sec).padStart(2, '0')}`;
            }

            playPauseBtn?.addEventListener('click', () => {
                if (audio.paused) {
                    audio.play();
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    audio.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            });

            audio.addEventListener('timeupdate', () => {
                if (!audio.duration) return;
                const pct = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = pct + '%';
                progressSlider.value = pct;
                currentTimeEl.textContent = fmt(audio.currentTime);
            });

            audio.addEventListener('loadedmetadata', () => {
                durationEl.textContent = fmt(audio.duration);
            });

            progressSlider?.addEventListener('input', function() {
                audio.currentTime = (this.value / 100) * audio.duration;
            });

            volumeSlider?.addEventListener('input', function() {
                audio.volume = this.value;
                const muted = this.value == 0;
                volumeIcon.classList.toggle('hidden', muted);
                muteIcon.classList.toggle('hidden', !muted);
            });

            muteBtn?.addEventListener('click', () => {
                audio.muted = !audio.muted;
                volumeIcon.classList.toggle('hidden', audio.muted);
                muteIcon.classList.toggle('hidden', !audio.muted);
                volumeSlider.value = audio.muted ? 0 : audio.volume;
            });

            audio.addEventListener('ended', () => {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                progressBar.style.width = '0%';
                progressSlider.value = 0;
                currentTimeEl.textContent = '0:00';
            });
        });
    </script>
</x-app-layout>
