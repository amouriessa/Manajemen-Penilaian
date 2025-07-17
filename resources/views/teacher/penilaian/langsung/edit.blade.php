<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <!-- Header -->
                <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex items-center gap-2 mb-1 text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('teacher.penilaian.langsung.index') }}"
                                class="hover:text-indigo-600 dark:hover:text-indigo-400">Penilaian</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Edit Nilai</span>
                        </div>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white md:text-2xl">Edit Penilaian Langsung
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ubah data penilaian hafalan siswa.</p>
                    </div>
                    <a href="{{ route('teacher.penilaian.langsung.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-200 bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Form -->
                <div
                    class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    @if ($errors->any())
                        <div class="p-4 mb-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                            <ul class="text-sm text-red-700 list-disc list-inside dark:text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('teacher.penilaian.langsung.update', $penilaian) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="jenis_penilaian" value="langsung">
                        <input type="hidden" name="student_id" value="{{ $penilaian->student_id }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Siswa</label>
                                <input type="text" value="{{ $penilaian->siswa->user->name }}" readonly
                                    class="block w-full mt-1 text-sm bg-gray-100 border-gray-300 rounded-sm shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="text" value="{{ $penilaian->siswa->user->email }}" readonly
                                    class="block w-full mt-1 text-sm bg-gray-100 border-gray-300 rounded-sm shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600">
                            </div>

                            <div class="space-y-2">
                                <label for="jenis_tugas"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                                    Hafalan</label>
                                <select name="jenis_tugas" id="jenis_tugas"
                                    class="block w-full text-sm border-gray-300 rounded-md" required>
                                    <option value="">-- Pilih Jenis Hafalan --</option>
                                    <option value="baru" {{ $penilaian->jenis_hafalan == 'baru' ? 'selected' : '' }}>
                                        Baru</option>
                                    <option value="murajaah"
                                        {{ $penilaian->jenis_hafalan == 'murajaah' ? 'selected' : '' }}>Murajaah
                                    </option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Surah & Ayat</label>
                                <div id="surah-container">
                                    @foreach ($penilaian->surahHafalanPenilaian as $i => $surah)
                                        <div class="flex gap-2 mb-2 surah-row">
                                            <select name="surah_data[{{ $i }}][surah_id]"
                                                class="w-1/3 text-xs border-gray-300 rounded-md" required>
                                                <option value="">Pilih Surah</option>
                                                @foreach ($surahList as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $surah->surah_id ? 'selected' : '' }}>
                                                        {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="surah_data[{{ $i }}][ayat_awal]"
                                                placeholder="Ayat Awal" value="{{ $surah->ayat_awal }}"
                                                class="w-1/3 text-xs border-gray-300 rounded-md" min="1"
                                                required>
                                            <input type="number" name="surah_data[{{ $i }}][ayat_akhir]"
                                                placeholder="Ayat Akhir" value="{{ $surah->ayat_akhir }}"
                                                class="w-1/3 text-xs border-gray-300 rounded-md" min="1"
                                                required>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-surah-row" class="mt-1 text-sm text-blue-600">+ Tambah
                                    Surah</button>
                            </div>

                            <div class="space-y-2">
                                <label for="nilai_tajwid"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai
                                    Tajwid</label>
                                <input type="number" name="nilai_tajwid" value="{{ $penilaian->nilai_tajwid }}"
                                    class="w-full border-gray-300 rounded-md" min="0" max="100" required>
                            </div>
                            <div class="space-y-2">
                                <label for="nilai_harakat"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai
                                    Harakat</label>
                                <input type="number" name="nilai_harakat" value="{{ $penilaian->nilai_harakat }}"
                                    class="w-full border-gray-300 rounded-md" min="0" max="100" required>
                            </div>
                            <div class="space-y-2">
                                <label for="nilai_makhraj"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai
                                    Makhraj</label>
                                <input type="number" name="nilai_makhraj" value="{{ $penilaian->nilai_makhraj }}"
                                    class="w-full border-gray-300 rounded-md" min="0" max="100" required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="catatan"
                                    class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <textarea name="catatan" id="catatan" rows="4" class="w-full border-gray-300 rounded-md">{{ $penilaian->catatan }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let surahIndex = {{ isset($penilaian) ? $penilaian->surahHafalanPenilaian->count() : 1 }};

            document.getElementById('add-surah-row').addEventListener('click', function() {
                const container = document.getElementById('surah-container');
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'gap-2', 'mb-2', 'surah-row');

                newRow.innerHTML = `
                    <select name="surah_data[${surahIndex}][surah_id]" class="w-1/3 text-xs border-gray-300 rounded-md" required>
                        <option value="">Pilih Surah</option>
                        @foreach ($surahList as $surah)
                            <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="surah_data[${surahIndex}][ayat_awal]" placeholder="Ayat Awal"
                        class="w-1/3 text-xs border-gray-300 rounded-md" min="1" required>
                    <input type="number" name="surah_data[${surahIndex}][ayat_akhir]" placeholder="Ayat Akhir"
                        class="w-1/3 text-xs border-gray-300 rounded-md" min="1" required>
                `;
                container.appendChild(newRow);
                surahIndex++;
            });
        });
    </script>
</x-app-layout>
