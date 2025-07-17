<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Buat Tugas Hafalan"
                    description="Isi form berikut untuk tugas hafalan yang ingin ditambahkan."
                    breadcrumbTitle="Tugas Hafalan" :route="route('teacher.tugas_hafalan.index')" breadcrumbActive="Tambah Tugas"
                    buttonText="Kembali" />


                <div
                    class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">
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

                    <form action="{{ route('teacher.tugas_hafalan.store') }}" method="POST" class="p-6 space-y-2">
                        @csrf

                        {{-- <!-- Nama Tugas -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nama Tugas</label>
                            <input type="text" name="nama"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                        </div> --}}



                        <!-- Kelas Tahfidz -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Kelas Tahfidz</label>
                            <select name="kelas_tahfidz_id"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasTahfidz as $kelas)
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Tugas -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Jenis Hafalan</label>
                            <select name="jenis_tugas" id="jenis_tugas"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="baru">Baru</option>
                                <option value="murajaah">Murajaah</option>
                            </select>
                        </div>

                        <!-- Tanggal Tenggat -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Tenggat Waktu</label>
                            <input type="date" name="tenggat_waktu"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <!-- Input Surah & Ayat -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium">Surah & Ayat</label>
                            <div id="surah-container">
                                <div class="flex gap-2 mb-2 surah-row">
                                    <select name="surah_data[0][surah_id]" class="w-1/3 border-gray-300 rounded-md"
                                        required>
                                        <option value="">-- Pilih Surah --</option>
                                        @foreach ($surahs as $surah)
                                            <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="surah_data[0][ayat_awal]" placeholder="Ayat Awal"
                                        class="w-1/3 border-gray-300 rounded-md" min="1" required>
                                    <input type="number" name="surah_data[0][ayat_akhir]" placeholder="Ayat Akhir"
                                        class="w-1/3 border-gray-300 rounded-md" min="1" required>
                                </div>
                            </div>
                            <button type="button" id="add-surah-row" class="mt-1 text-sm text-blue-600">+ Tambah
                                Surah</button>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <!-- Tipe Penugasan -->
                        <div class="mb-4">
                            <label class="block mb-1 text-sm font-medium">Tugaskan ke:</label>
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_for_all_student" value="1" checked>
                                    <span class="ml-2">Semua siswa di kelas</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_for_all_student" value="0">
                                    <span class="ml-2">Pilih siswa tertentu</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pilih siswa (ditampilkan jika memilih siswa tertentu) -->
                        <div class="hidden mb-6" id="student-select">
                            <label class="block mb-2 text-sm font-medium">Pilih Siswa</label>
                            <select name="student_ids[]" multiple class="w-full border-gray-300 rounded-md">
                                {{-- Akan diisi via JavaScript AJAX saat kelas dipilih --}}
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <div>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md">Simpan</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>

        <!-- Tambah Row JS -->
        <script>
            let surahIndex = 1;

            document.getElementById('add-surah-row').addEventListener('click', function() {
                const container = document.getElementById('surah-container');
                const newRow = document.createElement('div');
                newRow.classList.add('surah-row', 'flex', 'gap-2', 'mb-2');
                newRow.innerHTML = `
            <select name="surah_data[${surahIndex}][surah_id]" class="w-1/3 border-gray-300 rounded-md" required>
                <option value="">-- Pilih Surah --</option>
                @foreach ($surahs as $surah)
                    <option value="{{ $surah->surah_id }}">{{ $surah->nama }}</option>
                @endforeach
            </select>
            <input type="number" name="surah_data[${surahIndex}][ayat_awal]" placeholder="Ayat Awal" class="w-1/3 border-gray-300 rounded-md" min="1" required>
            <input type="number" name="surah_data[${surahIndex}][ayat_akhir]" placeholder="Ayat Akhir" class="w-1/3 border-gray-300 rounded-md" min="1" required>
        `;
                container.appendChild(newRow);
                surahIndex++;
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
    </div>
</x-app-layout>
