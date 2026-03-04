<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <div class="w-full overflow-y-auto">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">

                <x-header-create 
                    title="Tambah Siswa Dalam Kelas"
                    description="Masukkan informasi siswa dan kelas dalam tahun ajaran tertentu."
                    breadcrumbTitle="Data Siswa Kelas"
                    :route="route('admin.manajemen_siswa_kelas.index')"
                    breadcrumbActive="Tambah Baru"
                    buttonText="Kembali"
                />

                <div class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">

                    @if ($errors->any())
                        <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                            <h3 class="text-sm font-semibold text-red-800 dark:text-red-400">
                                Terdapat kesalahan pada pengisian form.
                            </h3>
                        </div>
                    @endif

                    <form id="main-form" action="{{ route('admin.manajemen_siswa_kelas.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- ========================= --}}
                            {{-- TAHUN AJARAN --}}
                            {{-- ========================= --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>

                                <select name="tahun_ajaran_id" id="tahun_ajaran_id" required
                                    class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('tahun_ajaran_id') border-red-500 ring-1 ring-red-500 @enderror">
                                    @foreach ($tahunAjaran as $tahun)
                                        <option value="{{ $tahun->id }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $tahun->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('tahun_ajaran_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- ========================= --}}
                            {{-- KELAS --}}
                            {{-- ========================= --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Pilih Kelas Tahfidz <span class="text-red-500">*</span>
                                </label>

                                <select name="kelas_tahfidz_id" id="kelas_tahfidz_id" required
                                    class="w-full mt-2 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-100 focus:border-indigo-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('kelas_tahfidz_id') border-red-500 ring-1 ring-red-500 @enderror">
                                    <option value="" class="text-gray-500">-- Pilih kelas --</option>
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
                        </div>

                        {{-- ========================= --}}
                        {{-- SISWA --}}
                        {{-- ========================= --}}
                        <div id="student-section" class="space-y-4 opacity-50 pointer-events-none transition-all duration-200">

                            <div class="flex justify-between items-center">
                                <label class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    Pilih Siswa <span class="text-red-500">*</span>
                                </label>
                                <span class="text-xs text-gray-500">
                                    <span id="selected-count" class="font-medium text-indigo-600">0</span> dipilih
                                </span>
                            </div>

                            @error('student_ids')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Search --}}
                            <input type="text"
                                   id="student-search"
                                   placeholder="Cari nama siswa..."
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                            {{-- Select All --}}
                            <div class="flex items-center justify-between p-3 border rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                <label class="flex items-center space-x-2 text-sm cursor-pointer">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <span>Pilih Semua (yang terlihat)</span>
                                </label>
                                <span class="text-xs text-gray-500">{{ count($students) }} total siswa</span>
                            </div>

                            {{-- Student List --}}
                            <div id="students-container" class="space-y-2 max-h-64 overflow-y-auto border p-2 rounded-lg">
                                @foreach ($students as $student)
                                    <label class="flex items-center p-2 space-x-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 student-item"
                                           data-name="{{ strtolower($student->user->name ?? '-') }}">
                                        <input type="checkbox"
                                               name="student_ids[]"
                                               value="{{ $student->id }}"
                                               class="student-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        <span class="text-sm text-gray-800 dark:text-gray-200">
                                            {{ $student->user->name ?? '-' }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Preview --}}
                            <div id="selected-preview"
                                 class="hidden p-3 border border-indigo-200 rounded-lg bg-indigo-50">
                                <p class="text-sm font-medium text-indigo-700">
                                    Siswa Dipilih:
                                </p>
                                <div id="selected-names" class="flex flex-wrap gap-2 mt-2"></div>
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <a href="{{ route('admin.manajemen_siswa_kelas.index') }}"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                Batal
                            </a>

                            <button type="submit"
                                    id="submit-btn"
                                    disabled
                                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg disabled:opacity-50 hover:bg-indigo-700">
                                Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const kelasSelect = document.getElementById('kelas_tahfidz_id');
    const studentSection = document.getElementById('student-section');
    const searchInput = document.getElementById('student-search');
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectedCount = document.getElementById('selected-count');
    const preview = document.getElementById('selected-preview');
    const previewContainer = document.getElementById('selected-names');
    const submitBtn = document.getElementById('submit-btn');

    function enableStudents() {
        if (kelasSelect.value !== '') {
            studentSection.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            studentSection.classList.add('opacity-50', 'pointer-events-none');
        }
        validateForm();
    }

    function visibleCheckboxes() {
        return Array.from(document.querySelectorAll('.student-item'))
            .filter(item => item.style.display !== 'none')
            .map(item => item.querySelector('.student-checkbox'));
    }

    function updateSelection() {
        const checked = document.querySelectorAll('.student-checkbox:checked');
        selectedCount.textContent = checked.length;

        if (checked.length > 0) {
            preview.classList.remove('hidden');
            const names = Array.from(checked).map(cb =>
                cb.closest('.student-item').querySelector('span').textContent
            );

            let display = names.slice(0, 5).map(name =>
                `<span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded-full">${name}</span>`
            ).join('');

            if (names.length > 5) {
                display += `<span class="px-2 py-1 text-xs bg-gray-200 rounded-full">+${names.length - 5} lainnya</span>`;
            }

            previewContainer.innerHTML = display;
        } else {
            preview.classList.add('hidden');
        }

        validateForm();
    }

    function validateForm() {
        const anyChecked = document.querySelectorAll('.student-checkbox:checked').length > 0;
        submitBtn.disabled = !(kelasSelect.value !== '' && anyChecked);
    }

    function filterStudents() {
        const term = searchInput.value.toLowerCase();
        document.querySelectorAll('.student-item').forEach(item => {
            item.style.display = item.dataset.name.includes(term) ? 'flex' : 'none';
        });
    }

    // Events
    kelasSelect.addEventListener('change', enableStudents);
    searchInput.addEventListener('keyup', filterStudents);

    selectAll.addEventListener('change', function () {
        visibleCheckboxes().forEach(cb => cb.checked = this.checked);
        updateSelection();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateSelection);
    });

    document.getElementById('main-form').addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Menyimpan...';
    });

});
</script>