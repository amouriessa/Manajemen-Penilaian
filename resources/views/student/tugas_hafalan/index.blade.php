<x-app-layout>
    <div class="container px-4 py-6 mx-auto">
        <div class="mb-12">
            <h2 class="mb-2 text-xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-sm text-gray-600">Tugas hafalan yang masih aktif untuk Anda.</p>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="p-4 mb-6 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg" role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium">Berhasil!</span>
                        {{ session('success') }}
                    </div>
                    <button type="button" onclick="document.getElementById('success-alert').remove()"
                        class="ml-auto -mx-1.5 -my-1.5 text-green-700 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="error-alert" class="p-4 mb-6 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg"
                role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="font-medium">Error!</span>
                        {{ session('error') }}
                    </div>
                    <button type="button" onclick="document.getElementById('error-alert').remove()"
                        class="ml-auto -mx-1.5 -my-1.5 text-red-700 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- HALAMAN UTAMA TUGAS (dengan sistem arsip otomatis) --}}
        @if ($tugas->count())
            {{-- NOTIFIKASI ARSIP --}}
            @if ($archivedTasks->count() > 0 && !session('hide_archive_notification'))
                <div class="p-4 mb-6 border rounded-lg border-amber-200 bg-amber-50">
                    <div class="flex items-center space-x-3">
                        <svg class="flex-shrink-0 w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-amber-800">
                                {{ $archivedTasks->count() }} tugas telah dipindahkan ke arsip karena sudah dinilai
                                lebih dari 3 hari.
                            </p>
                        </div>
                        <a href="{{ route('student.tugas_hafalan.archive.redirect') }}"
                            class="px-3 py-1 text-xs font-medium transition-colors border rounded-full text-amber-800 border-amber-300 hover:bg-amber-100">
                            Lihat Arsip
                        </a>
                    </div>
                </div>
            @endif

            {{-- BAGIAN TUGAS AKTIF --}}
            @if ($activeTasks->count())
                <div class="px-8 py-8 mb-12 bg-white border rounded-lg shadow-md">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-indigo-800">Tugas Aktif</h2>
                                <p class="text-sm text-gray-600">{{ $activeTasks->count() }} tugas perlu dikerjakan</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($activeTasks as $task)
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">
                                <div
                                    class="flex items-center justify-between p-5 border-b bg-gradient-to-r from-indigo-50 to-indigo-50">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        @foreach ($task->surahHafalan as $surahHafalanItem)
                                            <span>{{ $surahHafalanItem->surah->nama }}</span>
                                        @endforeach
                                    </h3>
                                    @if ($task->is_submitted)
                                        <span
                                            class="px-3 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full">Menunggu
                                            Penilaian</span>
                                    @else
                                        {{-- <span
                                            class="px-3 py-1 text-xs font-semibold text-{{ $isUrgent ? 'red' : 'yellow' }}-800 bg-{{ $isUrgent ? 'red' : 'yellow' }}-100 rounded-full">
                                            {{ $isUrgent ? 'Segera Kumpulkan!' : 'Belum Dikumpulkan' }}
                                        </span> --}}
                                        <span
                                            class="px-3 py-1 text-xs font-semibold
                                                text-{{ $task->is_urgent ? 'red' : 'yellow' }}-800
                                                bg-{{ $task->is_urgent ? 'red' : 'yellow' }}-100
                                                rounded-full">
                                            {{ $task->is_urgent ? 'Segera Kumpulkan!' : 'Belum Dikumpulkan' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-5">
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Ayat</p>
                                            <p class="font-medium">
                                                @foreach ($task->surahHafalan as $surahHafalanItem)
                                                    {{-- Ganti nama variabel agar lebih jelas --}}
                                                    ({{ $surahHafalanItem->ayat_awal }}-{{ $surahHafalanItem->ayat_akhir }})
                                                    <br>
                                                @endforeach
                                            </p>
                                        </div>
                                        {{-- <div>
                                            <p class="text-sm text-gray-500">Deadline</p>
                                            <p class="font-medium {{ $isUrgent ? 'text-red-600' : '' }}">
                                                {{ $deadline->translatedFormat('d M Y') }}
                                            </p>
                                        </div> --}}
                                        <div>
                                            <p class="text-sm text-gray-500">Deadline</p>
                                            <p class="font-medium {{ $task->is_urgent ? 'text-red-600' : '' }}">
                                                {{ $task->parsed_deadline->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="mb-2 text-sm text-gray-600">Jenis Tugas:
                                            <span class="font-medium text-black">{{ ucfirst($task->jenis_tugas) }}
                                            </span>
                                        </p>
                                        <div class="mt-4 text-sm text-gray-500">
                                            Dibuat oleh: {{ $task->guru->user->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Dibuat pada: {{ $task->created_at->translatedFormat('d M Y H:i') }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col mt-6 space-y-3">
                                        @if (!$task->is_submitted)
                                            <button type="button"
                                                onclick="document.getElementById('upload-modal-{{ $task->id }}').classList.remove('hidden')"
                                                class="w-full px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                Kumpulkan Hafalan
                                            </button>
                                        @else
                                            <button type="button" disabled
                                                class="w-full px-4 py-2 text-center text-gray-500 bg-gray-100 rounded-lg cursor-not-allowed">
                                                Menunggu Penilaian
                                            </button>
                                        @endif

                                        <a href="{{ route('student.tugas_hafalan.show', $task->id) }}"
                                            class="w-full px-4 py-2 text-center text-indigo-700 transition-colors rounded-lg bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                            Lihat Detail Tugas
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Upload --}}
                            @if (!$task->is_submitted)
                                <div id="upload-modal-{{ $task->id }}"
                                    class="fixed inset-0 z-50 hidden overflow-y-auto">
                                    <!-- Backdrop dengan blur effect -->
                                    <div class="flex items-center justify-center min-h-screen px-4 py-6">
                                        <div
                                            class="fixed inset-0 transition-opacity duration-300 bg-gray-500/75 backdrop-blur-sm">
                                        </div>

                                        <!-- Modal Container -->
                                        <div
                                            class="relative w-full max-w-lg mx-auto transition-all duration-300 transform scale-95 hover:scale-100">
                                            <div
                                                class="overflow-hidden bg-white border border-gray-100 shadow-2xl rounded-2xl">

                                                <!-- Header Section -->
                                                <div class="px-6 py-5 bg-gradient-to-r from-indigo-500 to-indigo-700">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <!-- Icon Microphone -->
                                                            <div class="p-2 rounded-full bg-white/20">
                                                                <svg class="w-6 h-6 text-white" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h3 class="text-xl font-bold text-white">Kumpulkan
                                                                    Hafalan</h3>
                                                                <p class="text-sm text-indigo-100">Rekam dan kirim
                                                                    hafalan Anda</p>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            onclick="document.getElementById('upload-modal-{{ $task->id }}').classList.add('hidden')"
                                                            class="p-2 transition-colors duration-200 rounded-full text-white/70 hover:text-white hover:bg-white/10">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Form Content -->
                                                <form
                                                    action="{{ route('student.tugas_hafalan.submit_hafalan', $task->id) }}"
                                                    method="POST" enctype="multipart/form-data"
                                                    id="submission-form-{{ $task->id }}" class="p-6 space-y-6">
                                                    @csrf

                                                    <input type="hidden" name="tugas_hafalan_id"
                                                        value="{{ $task->id }}">

                                                    <!-- Recording Section -->
                                                    <div class="space-y-4">
                                                        <div class="flex items-center space-x-2">
                                                            <label class="text-sm font-semibold text-gray-800"
                                                                for="audio-{{ $task->id }}">
                                                                Rekaman Hafalan
                                                            </label>
                                                            <span class="text-sm font-medium text-red-500">*</span>
                                                        </div>

                                                        <!-- Recording Controls -->
                                                        <div class="p-6 border border-gray-200 bg-gray-50 rounded-xl">
                                                            <!-- Start Recording Button -->
                                                            <button type="button"
                                                                id="start-recording-{{ $task->id }}"
                                                                class="w-full flex items-center justify-center space-x-3 px-6 py-4 text-white font-semibold bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl hover:from-green-600 hover:to-emerald-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl start-recording focus:outline-none focus:ring-4 focus:ring-green-200"
                                                                data-task-id="{{ $task->id }}">
                                                                <svg class="w-6 h-6" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                                                    </path>
                                                                </svg>
                                                                <span>Mulai Rekam</span>
                                                            </button>

                                                            <!-- Stop Recording Button -->
                                                            <button type="button"
                                                                id="stop-recording-{{ $task->id }}"
                                                                class="hidden w-full flex items-center justify-center space-x-3 px-6 py-4 text-white font-semibold bg-gradient-to-r from-red-500 to-pink-600 rounded-xl hover:from-red-600 hover:to-pink-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl stop-recording focus:outline-none focus:ring-4 focus:ring-red-200"
                                                                data-task-id="{{ $task->id }}">
                                                                <svg class="w-6 h-6" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z">
                                                                    </path>
                                                                </svg>
                                                                <span>Stop Rekam</span>
                                                                <div class="flex space-x-1">
                                                                    <div
                                                                        class="w-1 h-1 bg-white rounded-full animate-pulse">
                                                                    </div>
                                                                    <div class="w-1 h-1 bg-white rounded-full animate-pulse"
                                                                        style="animation-delay: 0.2s"></div>
                                                                    <div class="w-1 h-1 bg-white rounded-full animate-pulse"
                                                                        style="animation-delay: 0.4s"></div>
                                                                </div>
                                                            </button>

                                                            <!-- Audio Player -->
                                                            <div id="audio-container-{{ $task->id }}"
                                                                class="hidden mt-4">
                                                                <div
                                                                    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                                                    <div class="flex items-center mb-2 space-x-3">
                                                                        <svg class="w-5 h-5 text-green-600"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg>
                                                                        <span
                                                                            class="text-sm font-medium text-gray-700">Rekaman
                                                                            berhasil</span>
                                                                    </div>
                                                                    <audio id="audio-player-{{ $task->id }}"
                                                                        class="w-full" controls>
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </div>
                                                            </div>

                                                            <!-- Hidden File Input -->
                                                            <input type="file" id="audio-file-{{ $task->id }}"
                                                                name="file_pengumpulan" accept="audio/*"
                                                                class="hidden" required>

                                                            <!-- Recording Status -->
                                                            <div id="recording-status-{{ $task->id }}"
                                                                class="hidden mt-4 text-center">
                                                                <div
                                                                    class="inline-flex items-center px-4 py-2 space-x-2 text-red-700 bg-red-100 rounded-lg">
                                                                    <div
                                                                        class="w-3 h-3 bg-red-500 rounded-full animate-pulse">
                                                                    </div>
                                                                    <span class="text-sm font-medium">Sedang
                                                                        merekam...</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Recording Instructions -->
                                                        <div
                                                            class="p-4 border border-indigo-200 rounded-lg bg-indigo-50">
                                                            <div class="flex items-start space-x-3">
                                                                <svg class="w-5 h-5 text-indigo-600 mt-0.5 flex-shrink-0"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                <div class="text-sm text-indigo-800">
                                                                    <p class="mb-1 font-medium">Tips Rekaman:</p>
                                                                    <ul
                                                                        class="space-y-1 text-indigo-700 list-disc list-inside">
                                                                        <li>Pastikan berada di tempat yang tenang</li>
                                                                        <li>Bicara dengan jelas dan tidak terlalu cepat
                                                                        </li>
                                                                        <li>Periksa kembali rekaman sebelum mengirim
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Notes Section -->
                                                    <div class="space-y-3">
                                                        <label
                                                            class="flex items-center space-x-2 text-sm font-semibold text-gray-800"
                                                            for="notes-{{ $task->id }}">
                                                            <svg class="w-4 h-4 text-gray-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                            <span>Catatan (Opsional)</span>
                                                        </label>
                                                        <div class="relative">
                                                            <textarea
                                                                class="w-full px-4 py-3 text-gray-700 transition-all duration-200 border border-gray-200 resize-none bg-gray-50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500"
                                                                id="catatan-{{ $task->id }}" name="catatan" rows="4"
                                                                placeholder="Tulis catatan untuk guru Anda jika ada"></textarea>
                                                            <div
                                                                class="absolute text-xs text-gray-400 bottom-3 right-3">
                                                                <span id="char-count-{{ $task->id }}">0</span>/500
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div
                                                        class="flex flex-col justify-end pt-4 space-y-3 border-t border-gray-100 sm:flex-row sm:space-y-0 sm:space-x-3">
                                                        <button type="button"
                                                            onclick="document.getElementById('upload-modal-{{ $task->id }}').classList.add('hidden')"
                                                            class="w-full sm:w-auto px-6 py-3 text-gray-700 font-medium bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-gray-200 transform hover:scale-[1.02]">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="w-full sm:w-auto flex items-center justify-center space-x-2 px-8 py-3 text-white font-semibold bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-200 transform hover:scale-[1.02]">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                            </svg>
                                                            <span>Kumpulkan Hafalan</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- BAGIAN TUGAS YANG BARU DINILAI (< 3 hari) --}}
            @if ($recentlyAssessedTasks->count())
                <div class="px-8 py-8 mb-12 bg-white border rounded-lg shadow-md">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-green-800">Tugas Baru Dinilai</h2>
                                <p class="text-sm text-gray-600">{{ $recentlyAssessedTasks->count() }} tugas baru selesai
                                    dinilai</p>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Akan dipindah ke arsip setelah 3 hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($recentlyAssessedTasks as $task)
                            <div
                                class="overflow-hidden transition-shadow duration-300 bg-white border-l-4 border-green-500 shadow-md rounded-xl hover:shadow-lg">
                                <div
                                    class="flex items-center justify-between p-5 border-b bg-gradient-to-r from-green-50 to-emerald-50">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        @foreach ($task->surahHafalan as $surahHafalanItem)
                                            <span>{{ $surahHafalanItem->surah->nama }}</span>
                                        @endforeach
                                    </h3>
                                    <div class="flex flex-col items-end space-y-1">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Sudah
                                            Dinilai</span>
                                        @if ($task->has_assessment ?? false)
                                            <span class="text-xs text-gray-500">
                                                {{ intval($task->days_until_archive ?? 0) }} hari lagi → arsip
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-5">
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Ayat</p>
                                            <p class="font-medium">
                                                @foreach ($task->surahHafalan as $surahHafalanItem)
                                                    {{-- Ganti nama variabel agar lebih jelas --}}
                                                    ({{ $surahHafalanItem->ayat_awal }}-{{ $surahHafalanItem->ayat_akhir }})
                                                    <br>
                                                @endforeach
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Dinilai</p>
                                            <p class="font-medium text-gray-600">
                                                {{ $task->assessment_date?->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="mb-2 text-sm text-gray-600">Jenis Tugas:
                                            <span class="font-medium text-black">{{ ucfirst($task->jenis_tugas) }}
                                            </span>
                                        </p>
                                        <div class="mt-4 text-sm text-gray-500">
                                            Dibuat oleh: {{ $task->guru->user->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Dibuat pada: {{ $task->created_at->translatedFormat('d M Y H:i') }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col mt-6 space-y-3">
                                        <a href="{{ route('student.tugas_hafalan.show', $task) }}"
                                            class="w-full px-4 py-2 text-center text-green-700 transition-colors rounded-lg bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-200">
                                            Lihat Penilaian Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- PETUNJUK PENGGUNAAN --}}
            <div class="p-6 mt-10 bg-white shadow-md rounded-xl">
                <h4 class="mb-4 text-lg font-semibold text-gray-800">Petunjuk Pengumpulan Tugas</h4>
                <ul class="space-y-2 text-sm text-gray-600 list-disc list-inside">
                    <li>Klik tombol <strong>"Kumpulkan Hafalan"</strong></li>
                    <li>Gunakan tombol <strong>"Mulai Rekam"</strong> untuk merekam suara hafalan Anda.</li>
                    <li>Tekan <strong>"Stop Rekam"</strong> untuk menyelesaikan rekaman.</li>
                    <li>Setelah selesai, klik <strong>"Kumpulkan"</strong> untuk mengirimkan rekaman ke sistem.</li>
                    <li>Pastikan suara jelas dan rekaman tidak kosong.</li>
                </ul>
            </div>

            {{-- TOMBOL AKSES ARSIP --}}
            <div class="flex justify-center mt-8">
                <a href="{{ route('student.tugas_hafalan.archive') }}"
                    class="inline-flex items-center px-6 py-3 space-x-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Lihat Arsip Tugas</span>
                    @if ($archivedTasks->count() > 0)
                        <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-full">
                            {{ $archivedTasks->count() }}
                        </span>
                    @endif
                </a>
            </div>
        @else
            {{-- TAMPILAN KETIKA TIDAK ADA TUGAS --}}
            <div class="p-10 text-center bg-white shadow rounded-xl">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-medium text-gray-700">Tidak Ada Tugas Hafalan</h3>
                <p class="text-gray-500">Saat ini tidak ada tugas hafalan aktif untuk kelas Anda.</p>

                {{-- Tombol ke arsip jika ada tugas lama --}}
                <div class="mt-6">
                    <a href="{{ route('student.tugas_hafalan.archive') }}"
                        class="inline-flex items-center px-4 py-2 space-x-2 text-gray-600 transition-colors rounded-lg bg-gray-50 hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Lihat Arsip Tugas Lama</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        // MediaStream Recording API per task
        @foreach ($tugas as $task)
            (function() {
                let mediaRecorder;
                let audioChunks = [];

                const startBtn = document.getElementById('start-recording-{{ $task->id }}');
                const stopBtn = document.getElementById('stop-recording-{{ $task->id }}');
                const audioPlayer = document.getElementById('audio-player-{{ $task->id }}');
                const audioFileInput = document.getElementById('audio-file-{{ $task->id }}');

                startBtn?.addEventListener('click', async function() {
                    audioChunks = [];
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({
                            audio: true
                        });
                        mediaRecorder = new MediaRecorder(stream);
                        mediaRecorder.start();
                        startBtn.classList.add('hidden');
                        stopBtn.classList.remove('hidden');
                        audioPlayer.classList.add('hidden');
                        audioFileInput.value = ''; // Clear previous file

                        mediaRecorder.addEventListener('dataavailable', event => {
                            audioChunks.push(event.data);
                        });

                        mediaRecorder.addEventListener('stop', () => {
                            const audioBlob = new Blob(audioChunks, {
                                type: 'audio/webm'
                            });
                            const audioUrl = URL.createObjectURL(audioBlob);
                            audioPlayer.src = audioUrl;
                            audioPlayer.classList.remove('hidden');

                            // Convert Blob ke File dan assign ke input[type=file]
                            const file = new File([audioBlob],
                                "rekaman-{{ $task->id }}.webm", {
                                    type: 'audio/webm'
                                });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            audioFileInput.files = dataTransfer.files;
                        });
                    } catch (err) {
                        console.error('Error accessing microphone:', err);
                        alert('Tidak dapat mengakses mikrofon. Pastikan Anda memberikan izin.');
                    }
                });

                stopBtn?.addEventListener('click', function() {
                    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                        mediaRecorder.stop();
                        mediaRecorder.stream.getTracks().forEach(track => track.stop()); // Stop all tracks
                    }
                    startBtn.classList.remove('hidden');
                    stopBtn.classList.add('hidden');
                });
            })();
        @endforeach

        // Enhanced Recording Modal JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            let mediaRecorder;
            let audioChunks = [];
            let recordingTimer;
            let recordingSeconds = 0;

            // Character counter for notes
            document.querySelectorAll('[id^="notes-"]').forEach(textarea => {
                const taskId = textarea.id.split('-')[1];
                const charCount = document.getElementById(`char-count-${taskId}`);

                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    charCount.textContent = currentLength;

                    if (currentLength > 500) {
                        this.value = this.value.substring(0, 500);
                        charCount.textContent = 500;
                    }

                    // Visual feedback
                    if (currentLength > 450) {
                        charCount.classList.add('text-red-500');
                        charCount.classList.remove('text-gray-400');
                    } else {
                        charCount.classList.remove('text-red-500');
                        charCount.classList.add('text-gray-400');
                    }
                });
            });

            // Recording functions
            function startRecording(taskId) {
                navigator.mediaDevices.getUserMedia({
                        audio: true
                    })
                    .then(stream => {
                        mediaRecorder = new MediaRecorder(stream);
                        audioChunks = [];
                        recordingSeconds = 0;

                        const startBtn = document.getElementById(`start-recording-${taskId}`);
                        const stopBtn = document.getElementById(`stop-recording-${taskId}`);
                        const status = document.getElementById(`recording-status-${taskId}`);

                        // UI Updates
                        startBtn.classList.add('hidden');
                        stopBtn.classList.remove('hidden');
                        status.classList.remove('hidden');

                        // Start recording
                        mediaRecorder.start();

                        // Start timer
                        recordingTimer = setInterval(() => {
                            recordingSeconds++;
                            updateRecordingTimer(taskId, recordingSeconds);
                        }, 1000);

                        mediaRecorder.addEventListener('dataavailable', event => {
                            audioChunks.push(event.data);
                        });

                        mediaRecorder.addEventListener('stop', () => {
                            const audioBlob = new Blob(audioChunks, {
                                type: 'audio/wav'
                            });
                            const audioUrl = URL.createObjectURL(audioBlob);

                            // Create audio player
                            const audioPlayer = document.getElementById(`audio-player-${taskId}`);
                            const audioContainer = document.getElementById(`audio-container-${taskId}`);

                            audioPlayer.src = audioUrl;
                            audioContainer.classList.remove('hidden');

                            // Create file for form submission
                            const audioFile = new File([audioBlob],
                                `recording-${taskId}-${Date.now()}.wav`, {
                                    type: 'audio/wav'
                                });

                            // Set file input
                            const fileInput = document.getElementById(`audio-file-${taskId}`);
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(audioFile);
                            fileInput.files = dataTransfer.files;

                            // Stop all tracks to free up microphone
                            stream.getTracks().forEach(track => track.stop());
                        });
                    })
                    .catch(error => {
                        console.error('Error accessing microphone:', error);
                        showNotification('Error',
                            'Tidak dapat mengakses mikrofon. Pastikan Anda memberikan izin akses.', 'error');
                    });
            }

            function stopRecording(taskId) {
                if (mediaRecorder && mediaRecorder.state === 'recording') {
                    mediaRecorder.stop();
                    clearInterval(recordingTimer);

                    const startBtn = document.getElementById(`start-recording-${taskId}`);
                    const stopBtn = document.getElementById(`stop-recording-${taskId}`);
                    const status = document.getElementById(`recording-status-${taskId}`);

                    // UI Updates
                    startBtn.classList.remove('hidden');
                    stopBtn.classList.add('hidden');
                    status.classList.add('hidden');

                    // Update start button text
                    startBtn.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Rekam Ulang</span>
            `;
                }
            }

            function updateRecordingTimer(taskId, seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                const timeString =
                    `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;

                const status = document.getElementById(`recording-status-${taskId}`);
                if (status) {
                    status.innerHTML = `
                <div class="inline-flex items-center px-4 py-2 space-x-2 text-red-700 bg-red-100 rounded-lg">
                    <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium">Sedang merekam... ${timeString}</span>
                </div>
            `;
                }
            }

            // Event listeners for recording buttons
            document.querySelectorAll('.start-recording').forEach(button => {
                button.addEventListener('click', function() {
                    const taskId = this.getAttribute('data-task-id');
                    startRecording(taskId);
                });
            });

            document.querySelectorAll('.stop-recording').forEach(button => {
                button.addEventListener('click', function() {
                    const taskId = this.getAttribute('data-task-id');
                    stopRecording(taskId);
                });
            });

            // Form validation
            document.querySelectorAll('[id^="submission-form-"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const taskId = this.id.split('-')[2];
                    const audioFile = document.getElementById(`audio-file-${taskId}`);

                    if (!audioFile.files || audioFile.files.length === 0) {
                        e.preventDefault();
                        showNotification('Peringatan',
                            'Silakan buat rekaman hafalan terlebih dahulu.', 'warning');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengirim...</span>
            `;
                });
            });

            // Modal animation
            function showModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.transform').classList.remove('scale-95');
                    modal.querySelector('.transform').classList.add('scale-100');
                }, 10);
            }

            function hideModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.querySelector('.transform').classList.remove('scale-100');
                modal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('#success-alert, #error-alert');
                alerts.forEach(alert => {
                    if (alert) {
                        alert.style.transition = 'opacity 1s ease';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 1000);
                    }
                });
            }, 5000);

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('[id^="upload-modal-"]').forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            modal.classList.add('hidden');
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
