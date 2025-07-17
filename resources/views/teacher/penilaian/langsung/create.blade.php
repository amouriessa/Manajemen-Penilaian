<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <!-- Header -->
                <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('teacher.penilaian.langsung.index') }}"
                                class="hover:text-indigo-600 dark:hover:text-indigo-400">Pengumpulan</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Nilai</span>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Tambah Penilaian
                            Langsung</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat penilaian hafalan siswa secara
                            langsung.</p>
                    </div>
                    <a href="{{ route('teacher.penilaian.langsung.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Main Content -->
                <div
                    class="p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    @if ($errors->any())
                        <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-400">Terdapat beberapa
                                        kesalahan:</h3>
                                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside dark:text-red-300">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('teacher.penilaian.langsung.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="jenis_penilaian" value="langsung">
                        <input type="hidden" name="teacher_id" value="{{ Auth::user()->guru->id }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="student_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <select name="student_id" id="student_id" required
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ketik nama siswa minimal 3 huruf
                                    untuk mencari.</p>
                            </div>

                            <!-- Email User (Auto-fill) -->
                            <div class="space-y-2">
                                <label for="user_email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email
                                </label>
                                <input type="text" id="user_email" readonly
                                    class="block w-full mt-1 text-sm bg-gray-100 border-gray-300 rounded-sm shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Email akan terisi otomatis saat nama
                                    dipilih.</p>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const emailInput = document.getElementById('user_email');

                                    const selectUser = new TomSelect('#student_id', {
                                        valueField: 'value',
                                        labelField: 'text',
                                        searchField: 'text',
                                        placeholder: "-- Ketik nama siswa --",
                                        loadThrottle: 300,
                                        maxOptions: 20,
                                        minQueryLength: 3,
                                        load: function(query, callback) {
                                            fetch(`{{ route('teacher.siswa.searchUser') }}?q=${encodeURIComponent(query)}`)
                                                .then(response => response.json())
                                                .then(json => {
                                                    callback(json);
                                                }).catch(() => {
                                                    callback();
                                                });
                                        },
                                        onChange: function(value) {
                                            const option = this.options[value];
                                            if (option && option.email) {
                                                emailInput.value = option.email;
                                            } else {
                                                emailInput.value = '';
                                            }
                                        }
                                    });
                                });
                            </script>

                            <!-- Student Selection -->
                            {{-- <div class="group">
                                <label for="student_id" class="block mb-2 text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Pilih Siswa
                                    </span>
                                </label>
                                <select name="student_id" id="student_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white @error('student_id') border-red-500 @enderror"
                                    required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswa as $student)
                                        <option value="{{ $student->id }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }} ({{ $student->user->email }})
                                        </option>
                                    @endforeach

                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="space-y-2">
                                <label for="jenis_tugas"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jenis Hafalan <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_tugas" id="jenis_tugas" required
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="">-- Pilih Jenis Hafalan --</option>
                                    <option value="baru" {{ old('jenis_tugas') == 'baru' ? 'selected' : '' }}>
                                        Baru</option>
                                    <option value="murajaah"
                                        {{ old('jenis_tugas') == 'murajaah' ? 'selected' : '' }}>Murajaah
                                    </option>
                                </select>
                                @error('jenis_tugas')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Surah & Ayat Input -->
                            <div class="space-y-2">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Surah & Ayat</label>

                                <div id="surah-container">
                                    <div class="flex gap-2 mb-2 surah-row">
                                        <select name="surah_data[0][surah_id]" class="w-1/3 text-xs border-gray-300 rounded-md"
                                            required>
                                            <option value="">Pilih Surah</option>
                                            @foreach ($surahList as $surah)
                                                <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                                            @endforeach
                                        </select>

                                        <input type="number" name="surah_data[0][ayat_awal]" placeholder="Ayat Awal"
                                            class="w-1/3 text-xs border-gray-300 rounded-md" min="1" required>

                                        <input type="number" name="surah_data[0][ayat_akhir]" placeholder="Ayat Akhir"
                                            class="w-1/3 text-xs border-gray-300 rounded-md" min="1" required>
                                    </div>
                                </div>

                                <button type="button" id="add-surah-row" class="mt-1 text-sm text-blue-600">+ Tambah
                                    Surah</button>
                            </div>

                            <div class="space-y-2">
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
                            <div class="space-y-2">
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
                            <div class="space-y-2">
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

                            <div class="mb-4 space-y-2 md:col-span-2">
                                <label for="catatan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                    (Opsional)</label>
                                <textarea name="catatan" id="catatan" rows="4"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div
                            class="flex items-center justify-end gap-4 pt-5 mt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('teacher.penilaian.langsung.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
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
