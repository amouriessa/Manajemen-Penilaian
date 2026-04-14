<x-app-layout>
    <div class="flex min-h-screen overflow-hidden">

        <div class="flex-1 overflow-y-auto">
            <div class="px-4 py-6 mx-auto max-w-7xl md:px-6">

                {{-- ===== PAGE HEADER ===== --}}
                <div class="mb-6">
                    <h2 class="font-serif text-2xl font-bold text-textBody">Tugas Hafalan</h2>
                    <p class="mt-1 text-sm text-indigo-600">Tugas hafalan yang masih aktif untuk Anda.</p>
                    <div class="w-16 h-0.5 bg-indigo-600 rounded-full mt-3"></div>
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

                @if ($tugas->count())

                    {{-- ===== NOTIFIKASI ARSIP ===== --}}
                    @if ($archivedTasks->count() > 0 && !session('hide_archive_notification'))
                        <div
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                            <svg class="flex-shrink-0 w-5 h-5 text-[#D4A355]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="flex-1 text-sm font-medium text-[#B07833]">
                                {{ $archivedTasks->count() }} tugas telah dipindahkan ke arsip karena sudah dinilai
                                lebih dari 3 hari.
                            </p>
                            <a href="{{ route('student.tugas_hafalan.archive.redirect') }}"
                                class="px-3 py-1 text-xs font-medium rounded-full text-[#B07833] border border-[#D4A355]/50 hover:bg-[#D4A355]/10 transition whitespace-nowrap">
                                Lihat Arsip
                            </a>
                        </div>
                    @endif

                    {{-- ===== TUGAS AKTIF ===== --}}
                    @if ($activeTasks->count())
                        <div class="p-6 mb-6 bg-[#FDFAF5] shadow-md rounded-xl">

                            {{-- Section Header --}}
                            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-[#E5DED6]">
                                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#2D3F63]">
                                    <svg class="w-4 h-4 text-[#FDFAF5]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-[#2D3F63]">Tugas Aktif</h3>
                                    <p class="text-xs text-[#8C8070]">{{ $activeTasks->count() }} tugas perlu dikerjakan
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($activeTasks as $task)
                                    <div
                                        class="flex flex-col overflow-hidden border border-[#E5DED6] rounded-xl bg-[#FDFAF5] shadow-sm hover:shadow-md hover:scale-[1.01] transition-all duration-200">

                                        {{-- Accent bar --}}
                                        <div class="h-1 w-full bg-[linear-gradient(90deg,#2D3F63,#D4A355)]"></div>

                                        {{-- Card Header --}}
                                        <div
                                            class="flex items-start justify-between px-5 py-4 border-b border-[#E5DED6] bg-[#F7EDDA]/50">
                                            <h4 class="text-sm font-bold font-serif text-[#2D3F63] leading-snug">
                                                @foreach ($task->surahHafalan as $item)
                                                    {{ $item->surah->nama }}@unless ($loop->last)
                                                    ,
                                                @endunless
                                            @endforeach
                                        </h4>
                                        @if ($task->is_submitted)
                                            <span
                                                class="ml-2 flex-shrink-0 px-2.5 py-1 text-xs font-medium rounded-full bg-[#EAF2EE] text-[#5C8270]">
                                                Menunggu Penilaian
                                            </span>
                                        @elseif ($task->is_urgent)
                                            <span
                                                class="ml-2 flex-shrink-0 px-2.5 py-1 text-xs font-medium rounded-full bg-[#F9ECEC] text-[#B5655A]">
                                                Segera Kumpulkan!
                                            </span>
                                        @else
                                            <span
                                                class="ml-2 flex-shrink-0 px-2.5 py-1 text-xs font-medium rounded-full bg-[#FDF6EC] text-[#B07833]">
                                                Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Card Body --}}
                                    <div class="flex flex-col flex-1 p-5">
                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                            <div>
                                                <p
                                                    class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                    Ayat</p>
                                                <p class="text-sm font-medium text-[#3A3028]">
                                                    @foreach ($task->surahHafalan as $item)
                                                        {{ $item->ayat_awal }}–{{ $item->ayat_akhir }}<br>
                                                    @endforeach
                                                </p>
                                            </div>
                                            <div>
                                                <p
                                                    class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                    Deadline</p>
                                                <p
                                                    class="text-sm font-medium {{ $task->is_urgent ? 'text-[#B5655A]' : 'text-[#3A3028]' }}">
                                                    {{ $task->parsed_deadline->translatedFormat('d M Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="pt-3 mb-4 border-t border-[#E5DED6] space-y-1">
                                            <p class="text-xs text-[#8C8070]">
                                                Jenis: <span
                                                    class="font-semibold text-[#3A3028]">{{ ucfirst($task->jenis_tugas) }}</span>
                                            </p>
                                            <p class="text-xs text-[#8C8070]">
                                                Guru: <span
                                                    class="text-[#3A3028]">{{ $task->guru->user->name ?? 'N/A' }}</span>
                                            </p>
                                            <p class="text-xs text-[#8C8070]">
                                                {{ $task->created_at->translatedFormat('d M Y, H:i') }}</p>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex flex-col gap-2 mt-auto">
                                            @if (!$task->is_submitted)
                                                <button type="button"
                                                    onclick="openModal('upload-modal-{{ $task->id }}')"
                                                    class="w-full py-2 text-sm font-semibold text-white rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm">
                                                    Kumpulkan Hafalan
                                                </button>
                                            @else
                                                <button disabled
                                                    class="w-full py-2 text-sm font-medium text-[#8C8070] rounded-lg bg-[#E5DED6] cursor-not-allowed">
                                                    Menunggu Penilaian
                                                </button>
                                            @endif
                                            <a href="{{ route('student.tugas_hafalan.show', $task->id) }}"
                                                class="w-full py-2 text-sm font-medium text-center rounded-lg text-[#2D3F63] bg-[#F7EDDA] hover:bg-[#EDD9B0] border border-[#E5DED6] transition">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== MODAL UPLOAD ===== --}}
                                @if (!$task->is_submitted)
                                    <div id="upload-modal-{{ $task->id }}"
                                        class="fixed inset-0 z-50 items-center justify-center hidden p-4"
                                        role="dialog" aria-modal="true"
                                        aria-labelledby="modal-title-{{ $task->id }}">

                                        {{-- Backdrop --}}
                                        <div class="fixed inset-0 bg-[#1E2A40]/60 backdrop-blur-sm"
                                            onclick="closeModal('upload-modal-{{ $task->id }}')"></div>

                                        {{-- Modal Panel --}}
                                        <div class="relative z-10 w-full max-w-lg mx-auto max-h-[90vh] overflow-y-auto no-scrollbar">
                                            <div
                                                class="overflow-hidden bg-[#FDFAF5] border border-[#E5DED6] shadow-2xl rounded-2xl">

                                                {{-- Accent bar --}}
                                                <div
                                                    class="h-1.5 w-full bg-[linear-gradient(90deg,#2D3F63_0%,#D4A355_50%,#B5655A_100%)]">
                                                </div>

                                                {{-- Modal Header --}}
                                                <div
                                                    class="flex items-center justify-between px-6 py-4 bg-[#2D3F63]">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="flex items-center justify-center rounded-lg w-9 h-9 bg-white/10">
                                                            <svg class="w-5 h-5 text-[#FDFAF5]" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 id="modal-title-{{ $task->id }}"
                                                                class="font-serif text-base font-bold text-white">
                                                                Kumpulkan Hafalan</h3>
                                                            <p class="text-xs text-white/60">
                                                                @foreach ($task->surahHafalan as $item)
                                                                    {{ $item->surah->nama }}
                                                                    ({{ $item->ayat_awal }}–{{ $item->ayat_akhir }})
                                                                    @unless ($loop->last)
                                                                        ,
                                                                    @endunless
                                                                @endforeach
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        onclick="closeModal('upload-modal-{{ $task->id }}')"
                                                        class="p-1.5 rounded-lg text-white/60 hover:text-white hover:bg-white/10 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                {{-- Form --}}
                                                <form
                                                    action="{{ route('student.tugas_hafalan.submit_hafalan', $task->id) }}"
                                                    method="POST" enctype="multipart/form-data"
                                                    id="submission-form-{{ $task->id }}"
                                                    class="p-6 space-y-5">
                                                    @csrf
                                                    <input type="hidden" name="tugas_hafalan_id"
                                                        value="{{ $task->id }}">

                                                    {{-- Recording Area --}}
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-xs font-semibold uppercase tracking-wide text-[#8C8070]">
                                                            Rekaman Hafalan <span
                                                                class="text-[#B5655A] normal-case font-normal">*
                                                                wajib</span>
                                                        </label>

                                                        <div
                                                            class="p-4 rounded-xl bg-[#F7EDDA] border border-[#E5DED6] space-y-3">

                                                            {{-- Start --}}
                                                            <button type="button"
                                                                id="start-recording-{{ $task->id }}"
                                                                class="start-recording w-full flex items-center justify-center gap-2 py-3 px-4 text-sm font-semibold text-white rounded-lg bg-[#5C8270] hover:bg-[#4A6B5C] transition shadow-sm"
                                                                data-task-id="{{ $task->id }}">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                                </svg>
                                                                Mulai Rekam
                                                            </button>

                                                            {{-- Stop --}}
                                                            <button type="button"
                                                                id="stop-recording-{{ $task->id }}"
                                                                class="stop-recording hidden w-full flex items-center justify-center gap-2 py-3 px-4 text-sm font-semibold text-white rounded-lg bg-[#B5655A] hover:bg-[#8B4040] transition shadow-sm"
                                                                data-task-id="{{ $task->id }}">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                                                </svg>
                                                                Stop Rekam
                                                                <span class="flex gap-0.5 ml-1">
                                                                    <span
                                                                        class="w-1 h-1 bg-white rounded-full animate-pulse"></span>
                                                                    <span
                                                                        class="w-1 h-1 bg-white rounded-full animate-pulse"
                                                                        style="animation-delay:.2s"></span>
                                                                    <span
                                                                        class="w-1 h-1 bg-white rounded-full animate-pulse"
                                                                        style="animation-delay:.4s"></span>
                                                                </span>
                                                            </button>

                                                            {{-- Recording Status --}}
                                                            <div id="recording-status-{{ $task->id }}"
                                                                class="hidden text-center">
                                                                <div
                                                                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-medium rounded-lg bg-[#F9ECEC] text-[#B5655A]">
                                                                    <span
                                                                        class="w-2 h-2 rounded-full bg-[#B5655A] animate-pulse"></span>
                                                                    <span
                                                                        id="recording-timer-{{ $task->id }}">Sedang
                                                                        merekam... 00:00</span>
                                                                </div>
                                                            </div>

                                                            {{-- Audio Player --}}
                                                            <div id="audio-container-{{ $task->id }}"
                                                                class="hidden">
                                                                <div
                                                                    class="p-3 rounded-lg bg-[#FDFAF5] border border-[#E5DED6]">
                                                                    <div class="flex items-center gap-2 mb-2">
                                                                        <svg class="w-4 h-4 text-[#5C8270]"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                        <span
                                                                            class="text-xs font-medium text-[#5C8270]">Rekaman
                                                                            berhasil — dengarkan sebelum
                                                                            mengirim</span>
                                                                    </div>
                                                                    <audio id="audio-player-{{ $task->id }}"
                                                                        class="w-full" controls></audio>
                                                                </div>
                                                            </div>

                                                            {{-- <input type="file"
                                                                id="audio-file-{{ $task->id }}"
                                                                name="file_pengumpulan" accept="audio/*"
                                                                class="hidden" required> --}}
                                                        </div>

                                                        {{-- Tips --}}
                                                        <div
                                                            class="flex items-start gap-2 p-3 mt-3 rounded-lg bg-[#F0F4F8] border border-[#2D3F63]/10">
                                                            <svg class="w-4 h-4 text-[#2D3F63] mt-0.5 flex-shrink-0"
                                                                fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <p class="text-xs text-[#3A3028]">Pastikan di tempat
                                                                yang <strong>tenang</strong>, bicara jelas, dan
                                                                periksa rekaman sebelum dikirim.</p>
                                                        </div>
                                                    </div>

                                                    {{-- Notes --}}
                                                    <div>
                                                        <label
                                                            class="block mb-2 text-xs font-semibold uppercase tracking-wide text-[#8C8070]"
                                                            for="catatan-{{ $task->id }}">
                                                            Catatan <span
                                                                class="font-normal normal-case">(Opsional)</span>
                                                        </label>
                                                        <div class="relative">
                                                            <textarea id="catatan-{{ $task->id }}" name="catatan" rows="3"
                                                                placeholder="Tulis catatan untuk guru Anda jika ada..."
                                                                class="w-full px-4 py-3 text-sm text-[#3A3028] bg-[#F7EDDA] border border-[#E5DED6] rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-[#2D3F63]/30 focus:border-[#2D3F63] placeholder-[#C4B8A8] transition"></textarea>
                                                            <div
                                                                class="absolute text-xs text-[#8C8070] bottom-3 right-3">
                                                                <span
                                                                    id="char-count-{{ $task->id }}">0</span>/500
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Actions --}}
                                                    <div
                                                        class="flex flex-col gap-2 pt-4 border-t border-[#E5DED6] sm:flex-row sm:justify-end">
                                                        <button type="button"
                                                            onclick="document.getElementById('upload-modal-{{ $task->id }}').classList.add('hidden')"
                                                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white border border-[#E5DED6] rounded-lg bg-gray-500 hover:bg-gray-600 transition">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                            </svg>
                                                            Kumpulkan Hafalan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ===== TUGAS BARU DINILAI ===== --}}
                @if ($recentlyAssessedTasks->count())
                    <div class="p-6 mb-6 bg-[#FDFAF5] shadow-md rounded-xl">

                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#E5DED6]">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5C8270]">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-[#2D3F63]">Baru Dinilai</h3>
                                    <p class="text-xs text-[#8C8070]">{{ $recentlyAssessedTasks->count() }} tugas
                                        — akan diarsip dalam 3 hari</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($recentlyAssessedTasks as $task)
                                <div
                                    class="flex flex-col overflow-hidden border border-[#E5DED6] border-l-4 border-l-[#5C8270] rounded-xl bg-[#FDFAF5] shadow-sm hover:shadow-md hover:scale-[1.01] transition-all duration-200">

                                    <div
                                        class="flex items-start justify-between px-5 py-4 border-b border-[#E5DED6] bg-[#EAF2EE]/30">
                                        <h4 class="text-sm font-bold font-serif text-[#2D3F63] leading-snug">
                                            @foreach ($task->surahHafalan as $item)
                                                {{ $item->surah->nama }}@unless ($loop->last)
                                                ,
                                            @endunless
                                        @endforeach
                                    </h4>
                                    <div class="flex flex-col items-end flex-shrink-0 gap-1 ml-2">
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium rounded-full bg-[#EAF2EE] text-[#5C8270]">Sudah
                                            Dinilai</span>
                                        @if ($task->has_assessment ?? false)
                                            <span
                                                class="text-xs text-[#8C8070]">{{ intval($task->days_until_archive ?? 0) }}h
                                                → arsip</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col flex-1 p-5">
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div>
                                            <p
                                                class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                Ayat</p>
                                            <p class="text-sm font-medium text-[#3A3028]">
                                                @foreach ($task->surahHafalan as $item)
                                                    {{ $item->ayat_awal }}–{{ $item->ayat_akhir }}<br>
                                                @endforeach
                                            </p>
                                        </div>
                                        <div>
                                            <p
                                                class="mb-1 text-xs font-medium uppercase tracking-wide text-[#8C8070]">
                                                Tanggal Dinilai</p>
                                            <p class="text-sm font-medium text-[#3A3028]">
                                                {{ $task->assessment_date?->translatedFormat('d M Y') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pt-3 mb-4 border-t border-[#E5DED6] space-y-1">
                                        <p class="text-xs text-[#8C8070]">Jenis: <span
                                                class="font-semibold text-[#3A3028]">{{ ucfirst($task->jenis_tugas) }}</span>
                                        </p>
                                        <p class="text-xs text-[#8C8070]">Guru: <span
                                                class="text-[#3A3028]">{{ $task->guru->user->name ?? 'N/A' }}</span>
                                        </p>
                                    </div>

                                    <div class="mt-auto">
                                        <a href="{{ route('student.tugas_hafalan.show', $task) }}"
                                            class="block w-full py-2 text-sm font-medium text-center rounded-lg text-[#5C8270] bg-[#EAF2EE] hover:bg-[#D4E8DC] border border-[#5C8270]/20 transition">
                                            Lihat Penilaian Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ===== PETUNJUK ===== --}}
            <div class="p-6 mb-6 bg-[#FDFAF5] shadow-md rounded-xl">
                <h4 class="pb-3 mb-4 text-sm font-bold font-serif border-b text-[#3A3028] border-[#E5DED6]">
                    Petunjuk Pengumpulan Tugas
                </h4>
                <ol class="space-y-2">
                    @foreach (['Klik tombol <strong class="text-[#3A3028]">Kumpulkan Hafalan</strong> pada kartu tugas.', 'Tekan <strong class="text-[#3A3028]">Mulai Rekam</strong> dan bacakan hafalan Anda.', 'Tekan <strong class="text-[#3A3028]">Stop Rekam</strong> untuk menyelesaikan rekaman.', 'Dengarkan rekaman untuk memastikan kualitasnya.', 'Klik <strong class="text-[#3A3028]">Kumpulkan Hafalan</strong> untuk mengirim ke sistem.'] as $i => $step)
                        <li class="flex items-start gap-3 text-sm text-[#8C8070]">
                            <span
                                class="flex-shrink-0 flex items-center justify-center w-5 h-5 rounded-full bg-[#2D3F63] text-white text-xs font-bold mt-0.5">{{ $i + 1 }}</span>
                            <span>{!! $step !!}</span>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- ===== LINK ARSIP ===== --}}
            <div class="flex justify-center pb-8">
                <a href="{{ route('student.tugas_hafalan.archive') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-[#8C8070] rounded-lg bg-[#FDFAF5] border border-[#E5DED6] hover:bg-[#F7EDDA] hover:text-[#3A3028] transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Lihat Arsip Tugas
                    @if ($archivedTasks->count() > 0)
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full bg-[#E5DED6] text-[#8C8070]">
                            {{ $archivedTasks->count() }}
                        </span>
                    @endif
                </a>
            </div>
        @else
            {{-- ===== EMPTY STATE ===== --}}
            <div class="p-12 text-center bg-[#FDFAF5] shadow-md rounded-xl">
                <div class="flex items-center justify-center w-16 h-16 mx-auto">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="w-12 h-0.5 bg-[#2D3F630] rounded-full mx-auto mb-4"></div>
                <h3 class="mb-2 font-serif text-lg font-bold text-black">Tidak Ada Tugas Aktif</h3>
                <p class="mb-6 text-sm text-gray-500">Saat ini tidak ada tugas hafalan aktif untuk kelas Anda.
                </p>
                <a href="{{ route('student.tugas_hafalan.archive') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Lihat Arsip Tugas Lama
                </a>
            </div>

        @endif

    </div>
</div>
</div>

<script>
    // ===== MODAL HELPERS =====
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // ===== RECORDING PER TASK =====
    @foreach ($tugas as $task)
        (function() {
            const taskId = '{{ $task->id }}';
            let mediaRecorder, audioChunks = [],
                timerInterval, seconds = 0;

            const startBtn = document.getElementById('start-recording-{{ $task->id }}');
            const stopBtn = document.getElementById('stop-recording-{{ $task->id }}');
            const statusEl = document.getElementById('recording-status-{{ $task->id }}');
            const timerEl = document.getElementById('recording-timer-{{ $task->id }}');
            const container = document.getElementById('audio-container-{{ $task->id }}');
            const player = document.getElementById('audio-player-{{ $task->id }}');
            // const fileInput = document.getElementById('audio-file-{{ $task->id }}');

            function pad(n) {
                return String(n).padStart(2, '0');
            }

            function formatTime(s) {
                return `${pad(Math.floor(s/60))}:${pad(s%60)}`;
            }

            startBtn?.addEventListener('click', async () => {
                audioChunks = [];
                seconds = 0;
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();

                    startBtn.classList.add('hidden');
                    stopBtn.classList.remove('hidden');
                    statusEl.classList.remove('hidden');
                    container.classList.add('hidden');
                    // fileInput.value = '';

                    timerInterval = setInterval(() => {
                        seconds++;
                        if (timerEl) timerEl.textContent =
                            `Sedang merekam... ${formatTime(seconds)}`;
                    }, 1000);

                    mediaRecorder.addEventListener('dataavailable', e => audioChunks.push(e.data));
                    mediaRecorder.addEventListener('stop', () => {
                        const blob = new Blob(audioChunks, {
                            type: 'audio/webm'
                        });
                        window[`audioBlob_${taskId}`] = blob;
                        player.src = URL.createObjectURL(blob);
                        container.classList.remove('hidden');

                        // const file = new File([blob], `rekaman-{{ $task->id }}.webm`, { type: 'audio/webm' });
                        // const dt = new DataTransfer();
                        // dt.items.add(file);
                        // fileInput.files = dt.files;

                        stream.getTracks().forEach(t => t.stop());
                    });
                } catch {
                    alert('Tidak dapat mengakses mikrofon. Pastikan Anda memberikan izin.');
                }
            });

            stopBtn?.addEventListener('click', () => {
                if (mediaRecorder?.state !== 'inactive') mediaRecorder.stop();
                clearInterval(timerInterval);
                startBtn.innerHTML =
                    `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Rekam Ulang`;
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');
                statusEl.classList.add('hidden');
            });
        })();
    @endforeach

    document.addEventListener('DOMContentLoaded', () => {

        // Char counter
        document.querySelectorAll('[id^="catatan-"]').forEach(el => {
            const taskId = el.id.split('-')[1];
            const counter = document.getElementById(`char-count-${taskId}`);
            el.addEventListener('input', () => {
                el.value = el.value.substring(0, 500);
                counter.textContent = el.value.length;
                counter.classList.toggle('text-[#B5655A]', el.value.length > 450);
            });
        });

        // Form validation + loading state
        // document.querySelectorAll('[id^="submission-form-"]').forEach(form => {
        //     form.addEventListener('submit', e => {
        //         // const parts  = form.id.split('-');
        //         // const taskId = parts.slice(2).join('-');
        //         const taskId = form.id.replace('submission-form-', '');
        //         const file   = document.getElementById(`audio-file-${taskId}`);
        //         if (!file?.files?.length) {
        //             e.preventDefault();
        //             alert('Silakan buat rekaman hafalan terlebih dahulu.');
        //             return;
        //         }
        //         const btn = form.querySelector('button[type="submit"]');
        //         btn.disabled = true;
        //         btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg> Mengirim...`;
        //     });
        // });

        document.querySelectorAll('[id^="submission-form-"]').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const taskId = form.id.replace('submission-form-', '');
                const blob = window[`audioBlob_${taskId}`];

                if (!blob) {
                    alert('Silakan rekam hafalan dulu');
                    return;
                }

                const formData = new FormData(form);
                // formData.append('file_pengumpulan', blob, `rekaman-${taskId}.webm`);
                const file = new File([blob], `rekaman-${taskId}.webm`, {
                    type: 'audio/webm'
                });

                formData.append('file_pengumpulan', file);

                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg> Mengirim...`;

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    console.log('STATUS:', res.status);

                    if (!res.ok) throw new Error();

                    location.reload();
                } catch (err) {
                    alert('Gagal upload');
                    btn.disabled = false;
                    // btn.innerText = 'Kumpulkan Hafalan';
                    btn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg> Kumpulkan Hafalan`;
                }
            });
        });

        // Auto-hide alerts
        setTimeout(() => {
            ['success-alert', 'error-alert'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.style.transition = 'opacity 1s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 1000);
            });
        }, 5000);

        // ESC closes modal
        document.addEventListener('keydown', e => {
            if (e.key !== 'Escape') return;
            document.querySelectorAll('[id^="upload-modal-"]').forEach(m => {
                if (!m.classList.contains('hidden')) closeModal(m.id);
            });
        });
    });
</script>
</x-app-layout>
