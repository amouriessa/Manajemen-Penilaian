<x-app-layout>
    <!-- Main Content -->
    <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
        <!-- Header with animation -->
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('student.tugas_hafalan.index') }}"
                        class="hover:text-indigo-600 dark:hover:text-indigo-400">Tugas Tahfidz</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Detail Tugas</span>
                </div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Detail Tugas Hafalan</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Menampilkan deskripsi dan detail tugas hafalan.
                </p>
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

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Left Column - Task Details -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Task Information Card -->
                <div
                    class="overflow-hidden bg-white border border-gray-100 shadow-xl dark:bg-gray-800 rounded-2xl dark:border-gray-700">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center mb-6">
                            <div class="p-3 mr-4 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-indigo-900 dark:text-white">Informasi Tugas</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Detail lengkap tugas hafalan</p>
                            </div>
                        </div>

                        <!-- Surah Information -->
                        <div class="mb-8">
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Nama Surah
                                </span>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    @foreach ($tugasHafalan->surahHafalan as $item)
                                        {{ $item->surah->nama }} (Ayat {{ $item->ayat_awal }} - {{ $item->ayat_akhir }})
                                    @endforeach
                                </p>
                            </div>
                        </div>

                        <!-- Task Details Grid -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <div class="flex items-center mb-2">
                                    {{-- <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg> --}}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Jenis
                                        Tugas</span>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ ucfirst($tugasHafalan->jenis_tugas) }}
                                </p>
                            </div>

                            <div>
                                <div class="flex items-center mb-2">
                                    {{-- <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg> --}}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Deadline</span>
                                </div>
                                @php
                                    $deadline = \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->endOfDay();
                                @endphp

                                <p
                                    class="text-lg font-semibold {{ now()->greaterThan($deadline) ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                                    {{ \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->translatedFormat('d M Y') }}
                                </p>

                                @if (now()->greaterThan($deadline))
                                    <span
                                        class="inline-flex items-center px-2 py-1 mt-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                        Terlewat
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Teacher Info -->
            <div class="space-y-6">
                <!-- Teacher Information Card -->
                <div
                    class="overflow-hidden bg-white border border-gray-100 shadow-xl dark:bg-gray-800 rounded-2xl dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 mr-4 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-indigo-900 dark:text-white">Pembuat Tugas</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Informasi guru</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Nama Guru</span>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $tugasHafalan->guru->user->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Dibuat pada</span>
                                <p class="text-sm text-gray-900 dark:text-gray-300">
                                    {{ $tugasHafalan->created_at->translatedFormat('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <!-- Submission Status Card -->
            @if ($pengumpulan)
                <div
                    class="overflow-hidden bg-white border border-gray-100 shadow-xl dark:bg-gray-800 rounded-2xl dark:border-gray-700">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center mb-6">
                            <div class="p-3 mr-4 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-indigo-900 dark:text-white">Status Pengumpulan</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tugas telah dikumpulkan</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Audio Player -->
                            <div
                                class="p-6 border border-indigo-200 bg-gradient-to-r from-indigo-50 to-pink-50 dark:from-indigo-900/20 dark:to-pink-900/20 rounded-xl dark:border-indigo-800">
                                <div class="flex items-center mb-4">
                                    {{-- <svg class="w-4 h-4 mr-3 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                    </svg> --}}
                                    <span class="text-sm font-semibold text-indigo-900 dark:text-white">Audio
                                        Hafalan</span>
                                </div>

                                <!-- Custom Audio Player -->
                                <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                                    <audio id="audioPlayer" class="hidden">
                                        <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                            type="audio/mpeg">
                                        <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                            type="audio/wav">
                                        <source src="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}"
                                            type="audio/ogg">
                                        Browser Anda tidak mendukung audio player.
                                    </audio>

                                    <!-- Player Controls -->
                                    <div class="flex items-center space-x-4">
                                        <!-- Play/Pause Button -->
                                        <button id="playPauseBtn"
                                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-white transition-colors duration-200 bg-indigo-600 rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <svg id="playIcon" class="w-6 h-6 ml-1" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                            <svg id="pauseIcon" class="hidden w-6 h-6" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                                            </svg>
                                        </button>

                                        <!-- Progress Container -->
                                        <div class="flex-1">
                                            <!-- Time Display -->
                                            <div class="flex items-center justify-between mb-2">
                                                <span id="currentTime"
                                                    class="text-sm text-gray-600 dark:text-gray-400">0:00</span>
                                                <span id="duration"
                                                    class="text-sm text-gray-600 dark:text-gray-400">0:00</span>
                                            </div>

                                            <!-- Progress Bar -->
                                            <div class="relative">
                                                <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                                    <div id="progressBar"
                                                        class="h-2 transition-all duration-100 bg-indigo-600 rounded-full"
                                                        style="width: 0%"></div>
                                                </div>
                                                <input id="progressSlider" type="range" min="0"
                                                    max="100" value="0"
                                                    class="absolute top-0 left-0 w-full h-2 opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <!-- Volume Control -->
                                        <div class="flex items-center space-x-2">
                                            <button id="muteBtn"
                                                class="text-gray-600 transition-colors duration-200 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <svg id="volumeIcon" class="w-5 h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                </svg>
                                                <svg id="muteIcon" class="hidden w-5 h-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                                                </svg>
                                            </button>
                                            <input id="volumeSlider" type="range" min="0" max="1"
                                                step="0.1" value="1"
                                                class="w-20 h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 slider">
                                        </div>
                                    </div>

                                    <!-- Download Link -->
                                    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ asset('storage/' . $pengumpulan->file_pengumpulan) }}" download
                                            class="inline-flex items-center text-sm text-indigo-600 transition-colors duration-200 dark:text-indigo-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download Audio
                                        </a>
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
                                    const currentTimeSpan = document.getElementById('currentTime');
                                    const durationSpan = document.getElementById('duration');
                                    const muteBtn = document.getElementById('muteBtn');
                                    const volumeIcon = document.getElementById('volumeIcon');
                                    const muteIcon = document.getElementById('muteIcon');
                                    const volumeSlider = document.getElementById('volumeSlider');

                                    // Format time function
                                    function formatTime(seconds) {
                                        const mins = Math.floor(seconds / 60);
                                        const secs = Math.floor(seconds % 60);
                                        return `${mins}:${secs.toString().padStart(2, '0')}`;
                                    }

                                    // Play/Pause functionality
                                    playPauseBtn.addEventListener('click', function() {
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

                                    // Update progress bar and time
                                    audio.addEventListener('timeupdate', function() {
                                        const progress = (audio.currentTime / audio.duration) * 100;
                                        progressBar.style.width = progress + '%';
                                        progressSlider.value = progress;
                                        currentTimeSpan.textContent = formatTime(audio.currentTime);
                                    });

                                    // Set duration when metadata loads
                                    audio.addEventListener('loadedmetadata', function() {
                                        durationSpan.textContent = formatTime(audio.duration);
                                    });

                                    // Progress slider functionality
                                    progressSlider.addEventListener('input', function() {
                                        const time = (this.value / 100) * audio.duration;
                                        audio.currentTime = time;
                                    });

                                    // Volume control
                                    volumeSlider.addEventListener('input', function() {
                                        audio.volume = this.value;
                                        if (this.value == 0) {
                                            volumeIcon.classList.add('hidden');
                                            muteIcon.classList.remove('hidden');
                                        } else {
                                            volumeIcon.classList.remove('hidden');
                                            muteIcon.classList.add('hidden');
                                        }
                                    });

                                    // Mute/Unmute functionality
                                    muteBtn.addEventListener('click', function() {
                                        if (audio.muted) {
                                            audio.muted = false;
                                            volumeIcon.classList.remove('hidden');
                                            muteIcon.classList.add('hidden');
                                            volumeSlider.value = audio.volume;
                                        } else {
                                            audio.muted = true;
                                            volumeIcon.classList.add('hidden');
                                            muteIcon.classList.remove('hidden');
                                            volumeSlider.value = 0;
                                        }
                                    });

                                    // Reset play button when audio ends
                                    audio.addEventListener('ended', function() {
                                        playIcon.classList.remove('hidden');
                                        pauseIcon.classList.add('hidden');
                                        progressBar.style.width = '0%';
                                        progressSlider.value = 0;
                                        currentTimeSpan.textContent = '0:00';
                                    });
                                });
                            </script>

                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <div class="flex items-center mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Dikirim
                                        pada</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($pengumpulan->submitted_at)->translatedFormat('d M Y H:i') }}
                                </p>
                            </div>
                        </div>

                        @if ($pengumpulan->penilaian)
                            <div
                                class="p-6 mt-6 border border-indigo-200 bg-gradient-to-r from-indigo-50 to-pink-50 dark:from-indigo-900/20 dark:to-pink-900/20 rounded-xl dark:border-indigo-800">
                                <h4
                                    class="flex items-center mb-4 text-lg font-semibold text-indigo-900 dark:text-white">
                                    <svg class="w-4 h-4 mr-2 text-indigo-700 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    Hasil Penilaian
                                </h4>

                                <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2">
                                    <div class="flex flex-col">
                                        <span class="mb-1 text-sm text-gray-500 dark:text-gray-400">Nilai Total</span>
                                        <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-400">
                                            {{ $pengumpulan->penilaian->nilai_total }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="mb-1 text-sm text-gray-500 dark:text-gray-400">Predikat</span>
                                        <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-400">
                                            {{ ucwords(str_replace('_', ' ', $pengumpulan->penilaian->predikat)) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Detail Nilai Tabel -->
                                <div
                                    class="mt-4 overflow-hidden border rounded-lg shadow-sm border-white/20 backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 dark:border-gray-700/50">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-white/20 dark:divide-gray-700/50">
                                            <thead class="bg-white/40 dark:bg-gray-700/40 backdrop-blur-sm">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-indigo-700 uppercase dark:text-indigo-300">
                                                        Aspek Penilaian
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-indigo-700 uppercase dark:text-indigo-300">
                                                        Nilai
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-transparent divide-y divide-white/20 dark:divide-gray-700/50">
                                                <tr
                                                    class="transition-colors duration-150 hover:bg-white/20 dark:hover:bg-gray-700/30">
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        Tajwid
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-indigo-800 rounded-full bg-indigo-200/80 dark:bg-indigo-700/80 dark:text-indigo-200 backdrop-blur-sm">
                                                            {{ $pengumpulan->penilaian->nilai_tajwid ?? '-' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="transition-colors duration-150 hover:bg-white/20 dark:hover:bg-gray-700/30">
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        Harakat
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-pink-800 rounded-full bg-pink-200/80 dark:bg-pink-700/80 dark:text-pink-200 backdrop-blur-sm">
                                                            {{ $pengumpulan->penilaian->nilai_harakat ?? '-' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="transition-colors duration-150 hover:bg-white/20 dark:hover:bg-gray-700/30">
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        Makhraj
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-indigo-900 whitespace-nowrap dark:text-indigo-100">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-indigo-900 rounded-full bg-indigo-300/80 dark:bg-indigo-600/80 dark:text-indigo-100 backdrop-blur-sm">
                                                            {{ $pengumpulan->penilaian->nilai_makhraj ?? '-' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @if ($pengumpulan->penilaian->catatan)
                                    <div class="mt-6">
                                        <span
                                            class="block mb-2 text-sm font-medium text-indigo-700 dark:text-indigo-300">Catatan
                                            Guru</span>
                                        <div
                                            class="p-4 border rounded-lg shadow-sm border-white/20 backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 dark:border-gray-700/50">
                                            <p class="text-sm leading-relaxed text-indigo-900 dark:text-indigo-100">
                                                {{ $pengumpulan->penilaian->catatan }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="flex items-center pt-4 mt-6 border-t border-white/20 dark:border-gray-700/50">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-indigo-600 dark:text-indigo-400">
                                        Dinilai pada:
                                        {{ \Carbon\Carbon::parse($pengumpulan->penilaian->assessed_at)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="p-4 mt-6 border border-indigo-200 bg-indigo-50 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-indigo-800 dark:text-indigo-200">
                                        Menunggu penilaian dari guru
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div
                    class="overflow-hidden bg-white border border-gray-100 shadow-xl dark:bg-gray-800 rounded-2xl dark:border-gray-700">
                    <div class="p-6 sm:p-8">
                        <div class="py-8 text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Belum Mengumpulkan
                            </h3>
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">
                                Anda belum mengumpulkan tugas ini
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
</x-app-layout>
