<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Edit Tugas Hafalan"
                    description="Perbarui informasi tugas hafalan yang sudah ada."
                    breadcrumbTitle="Tugas Hafalan" :route="route('teacher.tugas_hafalan.index')" breadcrumbActive="Edit Tugas"
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

                    {{-- Form untuk memperbarui Tugas Hafalan --}}
                    {{-- Arahkan ke route update dengan ID tugas hafalan, gunakan method PUT --}}
                    <form action="{{ route('teacher.tugas_hafalan.update', $tugasHafalan->id) }}" method="POST" class="p-6 space-y-2">
                        @csrf
                        @method('PUT') {{-- Penting untuk HTTP PUT method --}}

                        <!-- Kelas Tahfidz -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas Tahfidz</label>
                            <select name="kelas_tahfidz_id"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasTahfidzOptions as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('kelas_tahfidz_id', $tugasHafalan->kelas_tahfidz_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Tugas -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Hafalan</label>
                            <select name="jenis_tugas" id="jenis_tugas"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="baru" {{ old('jenis_tugas', $tugasHafalan->jenis_tugas) == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="murajaah" {{ old('jenis_tugas', $tugasHafalan->jenis_tugas) == 'murajaah' ? 'selected' : '' }}>Murajaah</option>
                            </select>
                        </div>

                        <!-- Status Tugas -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Tugas</label>
                            <select name="status"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                <option value="aktif" {{ old('status', $tugasHafalan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $tugasHafalan->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <!-- Tanggal Tenggat -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tenggat Waktu</label>
                            <input type="date" name="tenggat_waktu"
                                value="{{ old('tenggat_waktu', $tugasHafalan->tenggat_waktu ? \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->format('Y-m-d') : '') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                        </div>

                        <!-- Input Surah & Ayat -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Surah & Ayat</label>
                            <div id="surah-container">
                                @forelse(old('surah_data', $surahHafalanTerpilih) as $index => $surahData)
                                    <div class="flex items-center gap-2 mb-2 surah-row">
                                        <select name="surah_data[{{ $index }}][surah_id]" class="w-1/3 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                            <option value="">-- Pilih Surah --</option>
                                            @foreach ($surahs as $surah)
                                                <option value="{{ $surah->id }}" {{ (old("surah_data.$index.surah_id", $surahData['surah_id'])) == $surah->id ? 'selected' : '' }}>
                                                    {{ $surah->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="surah_data[{{ $index }}][ayat_awal]" placeholder="Ayat Awal"
                                            value="{{ old("surah_data.$index.ayat_awal", $surahData['ayat_awal']) }}"
                                            class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                                        <input type="number" name="surah_data[{{ $index }}][ayat_akhir]" placeholder="Ayat Akhir"
                                            value="{{ old("surah_data.$index.ayat_akhir", $surahData['ayat_akhir']) }}"
                                            class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                                        @if($index > 0) {{-- Hanya tampilkan tombol hapus untuk baris tambahan --}}
                                            <button type="button" class="px-3 py-1 text-sm text-white bg-red-500 rounded-md remove-surah-row hover:bg-red-600">X</button>
                                        @endif
                                    </div>
                                @empty
                                    {{-- Baris default jika tidak ada surah yang terhubung (misal, tugas baru belum ada surahnya) --}}
                                    <div class="flex items-center gap-2 mb-2 surah-row">
                                        <select name="surah_data[0][surah_id]" class="w-1/3 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                            <option value="">-- Pilih Surah --</option>
                                            @foreach ($surahs as $surah)
                                                <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="surah_data[0][ayat_awal]" placeholder="Ayat Awal" class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                                        <input type="number" name="surah_data[0][ayat_akhir]" placeholder="Ayat Akhir" class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" id="add-surah-row" class="mt-1 text-sm text-blue-600 hover:text-blue-800">+ Tambah Surah</button>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('deskripsi', $tugasHafalan->deskripsi) }}</textarea>
                        </div>

                        <!-- Tipe Penugasan -->
                        <div class="mb-4">
                            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Tugaskan ke:</label>
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_for_all_student" value="1"
                                        {{ old('is_for_all_student', $tugasHafalan->is_for_all_student) == '1' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Semua siswa di kelas</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_for_all_student" value="0"
                                        {{ old('is_for_all_student', $tugasHafalan->is_for_all_student) == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Pilih siswa tertentu</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pilih siswa (ditampilkan jika memilih siswa tertentu) -->
                        <div class="{{ old('is_for_all_student', $tugasHafalan->is_for_all_student) == '1' ? 'hidden' : '' }} mb-6" id="student-select">
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Siswa</label>
                            <select name="student_ids[]" multiple class="w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                {{-- Akan diisi via JavaScript AJAX saat kelas dipilih dan saat halaman dimuat --}}
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <div>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Perbarui Tugas</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>

        <!-- JavaScript untuk Tambah/Hapus Surah & Logika Siswa -->
        <script>
            // Inisialisasi indeks surah berdasarkan jumlah surah yang sudah ada
            let surahIndex = {{ count(old('surah_data', $surahHafalanTerpilih)) > 0 ? count(old('surah_data', $surahHafalanTerpilih)) : 1 }};
            
            // Event listener untuk tombol "Tambah Surah"
            document.getElementById('add-surah-row').addEventListener('click', function() {
                const container = document.getElementById('surah-container');
                const newRow = document.createElement('div');
                newRow.classList.add('surah-row', 'flex', 'gap-2', 'mb-2', 'items-center');
                newRow.innerHTML = `
                    <select name="surah_data[${surahIndex}][surah_id]" class="w-1/3 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                        <option value="">-- Pilih Surah --</option>
                        @foreach ($surahs as $surah)
                            <option value="{{ $surah->id }}">{{ $surah->nama }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="surah_data[${surahIndex}][ayat_awal]" placeholder="Ayat Awal" class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                    <input type="number" name="surah_data[${surahIndex}][ayat_akhir]" placeholder="Ayat Akhir" class="w-1/3 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" min="1" required>
                    <button type="button" class="px-3 py-1 text-sm text-white bg-red-500 rounded-md remove-surah-row hover:bg-red-600">X</button>
                `;
                container.appendChild(newRow);
                surahIndex++;
                addRemoveButtonListeners(); // Tambahkan listener untuk tombol hapus yang baru
            });

            // Fungsi untuk menambahkan event listener ke semua tombol hapus surah
            function addRemoveButtonListeners() {
                document.querySelectorAll('.remove-surah-row').forEach(button => {
                    button.onclick = function() {
                        if (document.querySelectorAll('.surah-row').length > 1) { // Pastikan setidaknya ada satu baris tersisa
                            this.closest('.surah-row').remove();
                        } else {
                            alert('Minimal harus ada satu surah.'); // Ganti dengan modal jika tidak boleh alert
                        }
                    };
                });
            }

            addRemoveButtonListeners(); // Panggil saat awal untuk tombol yang sudah ada

            // Tampilkan select siswa jika pilih "pilih siswa tertentu"
            const radios = document.querySelectorAll('input[name="is_for_all_student"]');
            const studentSelectContainer = document.getElementById('student-select');
            const kelasTahfidzSelect = document.querySelector('select[name="kelas_tahfidz_id"]');
            const siswaMultiSelect = document.querySelector('select[name="student_ids[]"]');

            // Fungsi untuk memuat siswa berdasarkan ID kelas
            function loadSiswaByKelas(kelasTahfidzId, selectedStudentIds = []) {
                siswaMultiSelect.innerHTML = ''; // Kosongkan dulu opsi siswa

                if (!kelasTahfidzId) {
                    return; // Jangan fetch jika kelas belum dipilih
                }

                fetch(`/teacher/get-siswa-by-kelas/${kelasTahfidzId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal memuat siswa: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            const option = document.createElement('option');
                            option.value = "";
                            option.text = "Tidak ada siswa di kelas ini atau tahun ajaran tidak aktif.";
                            option.disabled = true;
                            siswaMultiSelect.appendChild(option);
                        } else {
                            data.forEach(siswa => {
                                const option = document.createElement('option');
                                option.value = siswa.id;
                                option.text = siswa.name;
                                // Periksa apakah siswa ini harus dipilih
                                if (selectedStudentIds.includes(siswa.id)) {
                                    option.selected = true;
                                }
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
                    studentSelectContainer.classList.toggle('hidden', this.value === "1");

                    // Jika "Pilih siswa tertentu" dipilih DAN kelas tahfidz sudah ada isinya
                    if (this.value === "0" && kelasTahfidzSelect.value) {
                        // Saat beralih ke "pilih siswa tertentu", tidak ada siswa yang terpilih sebelumnya (berdasarkan old() atau $siswaTerpilih),
                        // jadi panggil tanpa selectedStudentIds untuk opsi baru.
                        loadSiswaByKelas(kelasTahfidzSelect.value);
                    } else if (this.value === "1") {
                         // Jika beralih ke "Semua siswa", kosongkan select siswa
                        siswaMultiSelect.innerHTML = '';
                    }
                });
            });

            // Event listener untuk dropdown "Kelas Tahfidz"
            kelasTahfidzSelect.addEventListener('change', function() {
                const isSelectSpecificStudent = document.querySelector('input[name="is_for_all_student"]:checked').value === "0";

                if (isSelectSpecificStudent) {
                    // Saat kelas berubah, muat ulang siswa tanpa pre-seleksi awal (karena ini perubahan kelas)
                    loadSiswaByKelas(this.value);
                } else {
                    siswaMultiSelect.innerHTML = '';
                    // studentSelectContainer.classList.add('hidden'); // Tidak perlu ini jika sudah diatur oleh radio button
                }
            });

            // Inisialisasi saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                const initialKelasId = kelasTahfidzSelect.value;
                const initialIsForAllStudent = document.querySelector('input[name="is_for_all_student"]:checked').value;

                // Jika mode "Pilih siswa tertentu" aktif secara default dan ada kelas yang dipilih
                if (initialIsForAllStudent === "0" && initialKelasId) {
                    const siswaTerpilihIds = @json(old('student_ids', $siswaTerpilihIds)); // Ambil data siswa terpilih dari PHP
                    loadSiswaByKelas(initialKelasId, siswaTerpilihIds);
                }
            });
        </script>
    </div>
</x-app-layout>
