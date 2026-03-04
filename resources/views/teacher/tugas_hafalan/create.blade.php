<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden">
        <div class="w-full overflow-y-auto">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <x-header-create
                    title="Buat Tugas Hafalan"
                    description="Isi detail tugas hafalan yang akan diberikan kepada siswa."
                    breadcrumbTitle="Tugas Hafalan"
                    :route="route('teacher.tugas_hafalan.index')"
                    breadcrumbActive="Tambah Tugas"
                    buttonText="Kembali"
                />

                <div class="bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">

                    {{-- Error Summary --}}
                    @if ($errors->any())
                        <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                            <p class="text-sm font-semibold text-red-800 dark:text-red-400">
                                Periksa kembali form yang diisi.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('teacher.tugas_hafalan.store') }}" method="POST" class="p-6 space-y-8">
                        @csrf

                        {{-- ===================== --}}
                        {{-- SECTION 1: INFORMASI --}}
                        {{-- ===================== --}}
                        <div class="space-y-6">

                            <h3 class="text-sm font-bold text-[#3A3028] uppercase tracking-wide dark:text-gray-300">
                                Informasi Tugas
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                {{-- Kelas --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Kelas Tahfidz <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kelas_tahfidz_id"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                        <option value="" class="text-gray-600">-- Pilih kelas --</option>
                                        @foreach ($kelasTahfidz as $kelas)
                                            <option value="{{ $kelas->id }}">
                                                {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_tahfidz_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Jenis --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Jenis Hafalan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_tugas"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                        <option value="" class="text-gray-600">-- Pilih jenis --</option>
                                        <option value="baru">Baru</option>
                                        <option value="murajaah">Murajaah</option>
                                    </select>
                                </div>

                                {{-- Tenggat --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Tenggat Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tenggat_waktu"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                </div>

                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- SECTION 2: SURAH --}}
                        {{-- ===================== --}}
                        <div class="space-y-4">

                            <h3 class="text-sm font-bold text-[#3A3028] uppercase tracking-wide dark:text-gray-300">
                                Target Hafalan
                            </h3>

                            <div id="surah-container" class="space-y-3">

                                <div class="grid items-end grid-cols-1 gap-3 md:grid-cols-4 surah-row">
                                    <select name="surah_data[0][surah_id]"
                                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>
                                        <option value="" class="text-gray-600">-- Pilih surah --</option>
                                        @foreach ($surahs as $surah)
                                            <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                                        @endforeach
                                    </select>

                                    <input type="number"
                                        name="surah_data[0][ayat_awal]"
                                        placeholder="Ayat Awal"
                                        min="1"
                                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>

                                    <input type="number"
                                        name="surah_data[0][ayat_akhir]"
                                        placeholder="Ayat Akhir"
                                        min="1"
                                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>

                                    <!-- Tombol hapus (disabled untuk row pertama) -->
                                    <button type="button"
                                        disabled
                                        class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                        Hapus
                                    </button>
                                </div>

                            </div>

                            <button type="button"
                                id="add-surah-row"
                                class="p-2 text-xs font-medium text-indigo-600 rounded-lg bg-indigo-100/50 hover:bg-indigo-100 hover:text-indigo-700">
                                + Tambah Surah
                            </button>

                        </div>

                        {{-- ===================== --}}
                        {{-- SECTION 3: DESKRIPSI --}}
                        {{-- ===================== --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Deskripsi (Opsional)
                            </label>
                            <textarea name="deskripsi"
                                rows="3"
                                class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"></textarea>
                        </div>

                        {{-- ===================== --}}
                        {{-- SECTION 4: PENUGASAN --}}
                        {{-- ===================== --}}
                        <div class="space-y-4">

                            <h3 class="text-sm text-[#3A3028] font-bold uppercase tracking-wide dark:text-gray-300">
                                Penugasan
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-indigo-600">
                                    <input type="hidden" name="is_for_all_student" value="0">
                                    <input type="radio" name="is_for_all_student" value="1" checked class="mr-3 text-indigo-600 focus:ring-indigo-600">
                                    <span class="text-sm font-medium">Semua siswa di kelas</span>
                                </label>

                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-indigo-600">
                                    <input type="radio" name="is_for_all_student" value="0" class="mr-3 text-indigo-600 focus:ring-indigo-600">
                                    <span class="text-sm font-medium">Pilih siswa tertentu</span>
                                </label>

                            </div>

                            <div id="student-select" class="hidden">
                                <select name="student_ids[]"
                                    multiple
                                    class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700">
                                </select>
                            </div>

                        </div>

                        {{-- SUBMIT --}}
                        <div
                            class="flex items-center justify-end gap-4 pt-5 mt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('teacher.tugas_hafalan.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <!-- Tambah Row JS -->
        <script>
            let surahIndex = 1;

            document.getElementById('add-surah-row').addEventListener('click', function() {

                const container = document.getElementById('surah-container');

                const newRow = document.createElement('div');
                newRow.classList.add('grid','grid-cols-1','md:grid-cols-4','gap-3','surah-row','items-end');

                newRow.innerHTML = `
                    <select name="surah_data[${surahIndex}][surah_id]"
                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                        required>
                        <option value="">-- Pilih surah --</option>
                        @foreach ($surahs as $surah)
                            <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                        @endforeach
                    </select>

                    <input type="number"
                        name="surah_data[${surahIndex}][ayat_awal]"
                        placeholder="Ayat Awal"
                        min="1"
                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                        required>

                    <input type="number"
                        name="surah_data[${surahIndex}][ayat_akhir]"
                        placeholder="Ayat Akhir"
                        min="1"
                        class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                        required>

                    <button type="button"
                        class="px-3 py-2 text-sm text-red-600 rounded-lg remove-surah bg-red-50 hover:bg-red-100">
                        Hapus
                    </button>
                `;

                container.appendChild(newRow);
                surahIndex++;
            });


            // Event delegation untuk hapus row
            document.getElementById('surah-container').addEventListener('click', function(e) {

                if (e.target.classList.contains('remove-surah')) {
                    const row = e.target.closest('.surah-row');
                    row.remove();
                }

            });

            // Tampilkan select siswa jika pilih "pilih siswa tertentu"
            const radios = document.querySelectorAll('input[name="is_for_all_student"]');
            const studentSelectContainer = document.getElementById('student-select');
            const kelasTahfidzSelect = document.querySelector('select[name="kelas_tahfidz_id"]');
            const siswaMultiSelect = document.querySelector(
            'select[name="student_ids[]"]'); // Dapatkan referensi ke select siswa

            // Fungsi untuk memuat siswa berdasarkan ID kelas
            function loadSiswaByKelas(kelasTahfidzId) {
                siswaMultiSelect.innerHTML = ''; // Kosongkan dulu opsi siswa

                if (!kelasTahfidzId) {
                    return; // Jangan fetch jika kelas belum dipilih
                }

                fetch(`/teacher/get-siswa-by-kelas/${kelasTahfidzId}`)
                    .then(response => {
                        if (!response.ok) {
                            // Jika respons bukan OK (misal 404, 500), throw error
                            throw new Error('Gagal memuat siswa: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            const option = document.createElement('option');
                            option.value = "";
                            option.text = "Tidak ada siswa di kelas ini atau tahun ajaran tidak aktif.";
                            option.disabled = true; // Buat opsi tidak bisa dipilih
                            siswaMultiSelect.appendChild(option);
                        } else {
                            data.forEach(siswa => {
                                const option = document.createElement('option');
                                option.value = siswa.id; // Pastikan ini sesuai dengan 'id' dari JSON
                                option.text = siswa.name; // Pastikan ini sesuai dengan 'name' dari JSON
                                siswaMultiSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching siswa:', error);
                        const option = document.createElement('option');
                        option.value = "";
                        option.text = "Error memuat siswa.";
                        option.disabled = true;
                        siswaMultiSelect.appendChild(option);
                    });
            }

            // Event listener untuk radio button "Tugaskan ke:"
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Tampilkan/sembunyikan div 'student-select'
                    studentSelectContainer.classList.toggle('hidden', this.value === "1");

                    // Jika "Pilih siswa tertentu" dipilih DAN kelas tahfidz sudah ada isinya
                    if (this.value === "0" && kelasTahfidzSelect.value) {
                        loadSiswaByKelas(kelasTahfidzSelect.value);
                    }
                });
            });

            // Event listener untuk dropdown "Kelas Tahfidz"
            // Ini akan memuat siswa setiap kali kelas diubah, jika radio button 'pilih siswa tertentu' aktif
            kelasTahfidzSelect.addEventListener('change', function() {
                // Cek apakah radio button "Pilih siswa tertentu" sedang aktif (value="0")
                const isSelectSpecificStudent = document.querySelector('input[name="is_for_all_student"]:checked')
                    .value === "0";

                if (isSelectSpecificStudent) {
                    loadSiswaByKelas(this.value);
                } else {
                    // Jika "Semua siswa" dipilih, kosongkan select siswa dan sembunyikan
                    siswaMultiSelect.innerHTML = '';
                    studentSelectContainer.classList.add('hidden');
                }
            });

            // Opsional: Muat siswa saat halaman pertama kali dimuat jika ada kelas yang sudah dipilih
            // dan radio button "Pilih siswa tertentu" adalah default (jika ingin)
            // if (kelasTahfidzSelect.value && document.querySelector('input[name="is_for_all_student"][value="0"]').checked) {
            //     loadSiswaByKelas(kelasTahfidzSelect.value);
            // }
        </script>
</x-app-layout>
