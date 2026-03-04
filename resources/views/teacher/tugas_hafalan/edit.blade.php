<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden">
        <div class="w-full overflow-y-auto">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <x-header-create title="Edit Tugas Hafalan" description="Perbarui detail tugas hafalan yang sudah ada."
                    breadcrumbTitle="Tugas Hafalan" :route="route('teacher.tugas_hafalan.index')" breadcrumbActive="Edit Tugas" buttonText="Kembali" />

                <div class="bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">

                    @if ($errors->any())
                        <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                            <p class="text-sm font-semibold text-red-800 dark:text-red-400">
                                Periksa kembali form yang diisi.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('teacher.tugas_hafalan.update', $tugasHafalan->id) }}" method="POST"
                        class="p-6 space-y-8">
                        @csrf
                        @method('PUT')

                        {{-- ===================== --}}
                        {{-- SECTION 1: INFORMASI --}}
                        {{-- ===================== --}}
                        <div class="space-y-6">

                            <h3 class="text-sm font-bold text-[#3A3028] uppercase tracking-wide">
                                Informasi Tugas
                            </h3>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                {{-- Kelas --}}
                                <div>
                                    <label class="block text-sm font-semibold">
                                        Kelas Tahfidz <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kelas_tahfidz_id"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>
                                        <option value="">-- Pilih kelas --</option>
                                        @foreach ($kelasTahfidzOptions as $kelas)
                                            <option value="{{ $kelas->id }}"
                                                {{ old('kelas_tahfidz_id', $tugasHafalan->kelas_tahfidz_id) == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Jenis --}}
                                <div>
                                    <label class="block text-sm font-semibold">
                                        Jenis Hafalan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_tugas"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>
                                        <option value="">-- Pilih jenis --</option>
                                        <option value="baru"
                                            {{ old('jenis_tugas', $tugasHafalan->jenis_tugas) == 'baru' ? 'selected' : '' }}>
                                            Baru</option>
                                        <option value="murajaah"
                                            {{ old('jenis_tugas', $tugasHafalan->jenis_tugas) == 'murajaah' ? 'selected' : '' }}>
                                            Murajaah</option>
                                    </select>
                                </div>

                                {{-- Tenggat --}}
                                <div>
                                    <label class="block text-sm font-semibold">
                                        Tenggat Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tenggat_waktu"
                                        value="{{ old('tenggat_waktu', $tugasHafalan->tenggat_waktu ? \Carbon\Carbon::parse($tugasHafalan->tenggat_waktu)->format('Y-m-d') : '') }}"
                                        class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                        required>
                                </div>

                                {{-- Status --}}
                                {{-- <div>
                                    <label class="block text-sm font-semibold">
                                        Status Tugas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status"
                                            class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                            required>
                                        <option value="aktif" {{ old('status', $tugasHafalan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $tugasHafalan->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div> --}}

                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- SECTION 2: SURAH --}}
                        {{-- ===================== --}}
                        <div class="space-y-4">

                            <h3 class="text-sm font-bold text-[#3A3028] uppercase tracking-wide">
                                Target Hafalan
                            </h3>

                            <div id="surah-container" class="space-y-3">

                                @foreach (old('surah_data', $surahHafalanTerpilih) as $index => $surahData)
                                    <div class="grid items-end grid-cols-1 gap-3 md:grid-cols-4 surah-row">

                                        <select name="surah_data[{{ $index }}][surah_id]"
                                            class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                            required>
                                            <option value="">-- Pilih surah --</option>
                                            @foreach ($surahs as $surah)
                                                <option value="{{ $surah->id }}"
                                                    {{ old("surah_data.$index.surah_id", $surahData['surah_id']) == $surah->id ? 'selected' : '' }}>
                                                    {{ $surah->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="number" name="surah_data[{{ $index }}][ayat_awal]"
                                            value="{{ old("surah_data.$index.ayat_awal", $surahData['ayat_awal']) }}"
                                            min="1" placeholder="Ayat Awal"
                                            class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                            required>

                                        <input type="number" name="surah_data[{{ $index }}][ayat_akhir]"
                                            value="{{ old("surah_data.$index.ayat_akhir", $surahData['ayat_akhir']) }}"
                                            min="1" placeholder="Ayat Akhir"
                                            class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700"
                                            required>

                                        @if ($index > 0)
                                            <button type="button"
                                                class="px-3 py-2 text-sm text-red-600 rounded-lg remove-surah bg-red-50 hover:bg-red-100">
                                                Hapus
                                            </button>
                                        @else
                                            <button type="button" disabled
                                                class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                                Hapus
                                            </button>
                                        @endif

                                    </div>
                                @endforeach

                            </div>

                            <button type="button" id="add-surah-row"
                                class="p-2 text-xs font-medium text-indigo-600 rounded-lg bg-indigo-100/50 hover:bg-indigo-100 hover:text-indigo-700">
                                + Tambah Surah
                            </button>
                        </div>

                        {{-- ===================== --}}
                        {{-- SECTION 3: DESKRIPSI --}}
                        {{-- ===================== --}}
                        <div>
                            <label class="block text-sm font-semibold">
                                Deskripsi (Opsional)
                            </label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700">{{ old('deskripsi', $tugasHafalan->deskripsi) }}</textarea>
                        </div>

                        <div class="space-y-4">

                            <h3 class="text-sm text-[#3A3028] font-bold uppercase tracking-wide">
                                Penugasan
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                <label
                                    class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-indigo-600">

                                    <input type="hidden" name="is_for_all_student" value="0">

                                    <input type="radio" name="is_for_all_student" value="1"
                                        class="mr-3 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('is_for_all_student', $isForAllStudent) == 1 ? 'checked' : '' }}>

                                    <span class="text-sm font-medium">
                                        Semua siswa di kelas
                                    </span>

                                </label>


                                <label
                                    class="flex items-center p-4 border rounded-lg cursor-pointer focus:border-indigo-600 hover:border-indigo-600">

                                    <input type="radio" name="is_for_all_student" value="0"
                                        class="mr-3 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('is_for_all_student', $isForAllStudent) == 0 ? 'checked' : '' }}>

                                    <span class="text-sm font-medium">
                                        Pilih siswa tertentu
                                    </span>

                                </label>

                            </div>


                            <div id="student-select"
                                class="{{ old('is_for_all_student', $isForAllStudent) == 1 ? 'hidden' : '' }}">

                                <select name="student_ids[]" multiple
                                    class="w-full text-sm border-gray-300 rounded-lg shadow-sm">

                                    @foreach ($studentsOptions as $student)
                                        <option value="{{ $student->id }}"
                                            {{ in_array($student->id, old('student_ids', $siswaTerpilihIds)) ? 'selected' : '' }}>

                                            {{ $student->user->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                        {{-- ===================== --}}
                        {{-- SUBMIT --}}
                        {{-- ===================== --}}
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
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const radios = document.querySelectorAll('input[name="is_for_all_student"]');
            const studentSelectContainer = document.getElementById('student-select');
            const kelasTahfidzSelect = document.querySelector('select[name="kelas_tahfidz_id"]');

            radios.forEach(radio => {

                radio.addEventListener('change', function() {

                    studentSelectContainer.classList.toggle(
                        'hidden',
                        this.value === "1"
                    );

                });

            });

        });

        let surahIndex = {{ count($surahHafalanTerpilih) }};

        document.getElementById('add-surah-row').addEventListener('click', function() {

            const container = document.getElementById('surah-container');

            const newRow = document.createElement('div');
            newRow.classList.add(
                'grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-3', 'surah-row', 'items-end'
            );

            newRow.innerHTML = `
        <select name="surah_data[${surahIndex}][surah_id]"
        class="text-sm border-gray-300 rounded-lg shadow-sm"
        required>

            <option value="">-- Pilih surah --</option>

            @foreach ($surahs as $surah)
                <option value="{{ $surah->id }}">
                    {{ $surah->nama }}
                </option>
            @endforeach

        </select>

        <input type="number"
        name="surah_data[${surahIndex}][ayat_awal]"
        placeholder="Ayat Awal"
        min="1"
        class="text-sm border-gray-300 rounded-lg shadow-sm"
        required>

        <input type="number"
        name="surah_data[${surahIndex}][ayat_akhir]"
        placeholder="Ayat Akhir"
        min="1"
        class="text-sm border-gray-300 rounded-lg shadow-sm"
        required>

        <button type="button"
        class="px-3 py-2 text-sm text-red-600 rounded-lg remove-surah bg-red-50 hover:bg-red-100">
            Hapus
        </button>
    `;

            container.appendChild(newRow);
            surahIndex++;

        });


        document.getElementById('surah-container').addEventListener('click', function(e) {

            if (e.target.classList.contains('remove-surah')) {

                const row = e.target.closest('.surah-row');
                row.remove();

            }

        });
    </script>
</x-app-layout>
