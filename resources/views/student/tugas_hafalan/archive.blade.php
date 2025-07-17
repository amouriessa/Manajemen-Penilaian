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
                    <span class="font-medium text-gray-700 dark:text-gray-300">Arsip Tugas</span>
                </div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Arsip Tugas Hafalan</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tugas yang sudah dinilai lebih dari 3 hari.</p>
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

        <div class="p-6 space-y-3 bg-white rounded-lg shadow">
            <div class="container py-8 mx-auto">

                <!-- Search + Filter Form -->
                <div class="w-full">
                    <form method="GET" action="{{ route('student.tugas_hafalan.archive') }}"
                        class="flex flex-col gap-4 md:flex-row md:items-end">
                        <div class="relative w-full md:w-1/3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari data..."
                                class="w-full py-2.5 pl-10 pr-4 border border-gray-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                            @if (request('search'))
                                <a href="{{ route('student.tugas_hafalan.archive') }}"
                                    class="absolute text-xs text-gray-500 right-16 top-2 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center w-full gap-2 md:w-auto">
                            <div>
                                <label for="tanggal_awal"
                                    class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Dari</label>
                                <input type="date" id="tanggal_awal" name="tanggal_awal"
                                    value="{{ request('tanggal_awal') }}"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                            </div>
                            <div>
                                <label for="tanggal_akhir"
                                    class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Sampai</label>
                                <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                    value="{{ request('tanggal_akhir') }}"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                            </div>
                        </div>

                        <div class="flex gap-2 mt-1 md:self-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Cari
                            </button>

                            @if (request('search') || request('tanggal_awal') || request('tanggal_akhir'))
                                <a href="{{ route('student.tugas_hafalan.archive') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div id="success-alert"
                    class="p-4 border-l-4 border-green-500 rounded-lg shadow-md fade-in-up bg-green-50 dark:bg-green-900/30 dark:border-green-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                        <div class="pl-3 ml-auto">
                            <button onclick="document.getElementById('success-alert').remove()"
                                class="inline-flex p-1.5 text-green-500 rounded-md hover:bg-green-200 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <span class="sr-only">Tutup</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="error-alert"
                    class="p-4 border-l-4 border-red-500 rounded-lg shadow-md fade-in-up bg-red-50 dark:bg-red-900/30 dark:border-red-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                        </div>
                        <div class="pl-3 ml-auto">
                            <button onclick="document.getElementById('error-alert').remove()"
                                class="inline-flex p-1.5 text-red-500 rounded-md hover:bg-red-200 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <span class="sr-only">Tutup</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif



            {{-- Konten Arsip --}}
            @if ($tugas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr class="text-sm font-semibold text-left text-gray-700 dark:text-gray-200">
                                <th class="px-4 py-2 border-b">Surah</th>
                                <th class="px-4 py-2 border-b">Ayat</th>
                                <th class="px-4 py-2 border-b">Tenggat</th>
                                <th class="px-4 py-2 border-b">Dinilai</th>
                                <th class="px-4 py-2 border-b">Audio</th>
                                <th class="px-4 py-2 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800 dark:text-gray-100">
                            @foreach ($tugas as $task)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-4 py-2 border-b">
                                        @foreach ($task->surahHafalan as $item)
                                            {{ $item->surah->nama }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @foreach ($task->surahHafalan as $item)
                                            ({{ $item->ayat_awal }}–{{ $item->ayat_akhir }})
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        {{ \Carbon\Carbon::parse($task->tenggat_waktu)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        {{ \Carbon\Carbon::parse($task->assessmentDate)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @if ($task->submission && $task->submission->file_pengumpulan)
                                            <div class="flex flex-col gap-1">
                                                <audio controls preload="none" class="w-40">
                                                    <source
                                                        src="{{ asset('storage/' . $task->submission->file_pengumpulan) }}"
                                                        type="audio/webm">
                                                    Browser tidak mendukung pemutar audio.
                                                </audio>
                                                <a href="{{ asset('storage/' . $task->submission->file_pengumpulan) }}"
                                                    download="Hafalan_{{ Str::slug($task->surahHafalan->first()?->surah->nama ?? 'audio') }}.webm"
                                                    class="inline-block text-xs text-blue-600 hover:underline">
                                                    Download Audio
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-xs italic text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @if ($task->submission)
                                            <a href="{{ route('student.pengumpulan.show', $task->submission->id) }}"
                                                class="px-3 py-1.5 text-xs text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                                Lihat Nilai
                                            </a>
                                        @else
                                            <span class="text-xs italic text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- JavaScript untuk Audio Player --}}
                <script>
                    function toggleAudio(audioId) {
                        const audio = document.getElementById(audioId);
                        const taskId = audioId.replace('audio-', '');
                        const playIcon = document.getElementById('play-icon-' + taskId);
                        const pauseIcon = document.getElementById('pause-icon-' + taskId);

                        if (audio.paused) {
                            // Pause all other audio elements
                            document.querySelectorAll('audio').forEach(otherAudio => {
                                if (otherAudio !== audio && !otherAudio.paused) {
                                    otherAudio.pause();
                                    // Reset other icons
                                    const otherTaskId = otherAudio.id.replace('audio-', '');
                                    document.getElementById('play-icon-' + otherTaskId).classList.remove('hidden');
                                    document.getElementById('pause-icon-' + otherTaskId).classList.add('hidden');
                                }
                            });

                            audio.play();
                            playIcon.classList.add('hidden');
                            pauseIcon.classList.remove('hidden');
                        } else {
                            audio.pause();
                            playIcon.classList.remove('hidden');
                            pauseIcon.classList.add('hidden');
                        }

                        // Reset icon when audio ends
                        audio.addEventListener('ended', function() {
                            playIcon.classList.remove('hidden');
                            pauseIcon.classList.add('hidden');
                        });
                    }
                </script>

                {{-- Pagination jika diperlukan --}}
                <div class="flex justify-center mt-8 space-x-1">
                    @if ($tugas->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>

                        </span>
                    @else
                        <a href="{{ $tugas->previousPageUrl() }}"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>

                        </a>
                    @endif

                    <!-- Page Numbers -->
                    <div class="items-center hidden space-x-1 sm:flex">
                        @foreach ($tugas->getUrlRange(max(1, $tugas->currentPage() - 2), min($tugas->lastPage(), $tugas->currentPage() + 2)) as $page => $url)
                            @if ($page == $tugas->currentPage())
                                <span
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 border border-indigo-600 rounded-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if ($tugas->hasMorePages())
                        <a href="{{ $tugas->nextPageUrl() }}"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900">

                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-md cursor-not-allowed">

                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="p-4 mb-4 bg-gray-100 rounded-full">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-600">Belum Ada Arsip</h3>
                    <p class="max-w-md text-sm text-center text-gray-500">
                        Tugas yang sudah dinilai lebih dari 3 hari akan muncul di arsip.
                        Selesaikan dan kirimkan tugas Anda untuk mulai membangun arsip.
                    </p>
                    <a href="{{ route('student.tugas_hafalan.index') }}"
                        class="px-6 py-3 mt-6 text-base text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Lihat Tugas Aktif
                    </a>
                </div>
            @endif
        </div>

        @push('scripts')
            <script>
                // success alert
                // Auto-dismiss alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('#success-alert, #error-alert');
                    alerts.forEach(alert => {
                        if (alert) {
                            alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                            setTimeout(() => {
                                alert.remove();
                            }, 500);
                        }
                    });
                }, 5000);
            </script>
        @endpush
</x-app-layout>
