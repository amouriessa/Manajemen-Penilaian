<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Tambah Siswa Dalam Kelas"
                    description="Masukkan informasi siswa dan kelas dalam tahun ajaran tertentu."
                    breadcrumbTitle="Data Siswa Kelas" :route="route('admin.manajemen_siswa_kelas.index')" breadcrumbActive="Tambah Baru"
                    buttonText="Kembali" />

                <!-- Form Card -->
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

                    <form action="{{ route('admin.manajemen_siswa_kelas.store') }}" method="POST"
                        class="p-6 space-y-2">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">

                        <div class="space-y-4">
                            <!-- Label with Icon -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    <span>Pilih Siswa</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    <span id="selected-count" class="font-medium text-indigo-600 dark:text-indigo-400">0</span> siswa dipilih
                                </div>
                            </div>

                            <!-- Students List with Checkboxes -->
                            <div class="relative">
                                <div class="p-4 bg-white border-2 border-gray-200 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-600">
                                    <!-- Search Box -->
                                    <div class="relative mb-4">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                        <input type="text" id="student-search" placeholder="Cari nama siswa..."
                                            class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                            onkeyup="filterStudents()">
                                    </div>

                                    <!-- Select All Option -->
                                    <div class="flex items-center justify-between p-3 mb-3 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700/50 dark:border-gray-600">
                                        <label class="flex items-center space-x-3 cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" id="select-all" class="sr-only" onchange="toggleSelectAll()">
                                                <div class="w-5 h-5 transition-all duration-200 bg-white border-2 border-gray-300 rounded dark:bg-gray-600 dark:border-gray-500" id="select-all-checkbox">
                                                    <svg class="w-3 h-3 text-white transition-opacity duration-200 opacity-0" fill="currentColor" viewBox="0 0 20 20" style="margin: 1px;">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Semua Siswa</span>
                                        </label>
                                        <span class="text-xs text-gray-500 dark:text-gray-400" id="total-students">{{ count($students) }} siswa</span>
                                    </div>

                                    <!-- Students List -->
                                    <div class="space-y-2 overflow-y-auto max-h-64" id="students-container">
                                        @foreach ($students as $student)
                                            <div class="flex items-center p-3 transition-all duration-200 border border-gray-100 rounded-lg student-item hover:bg-gray-50 hover:border-gray-200 dark:border-gray-700 dark:hover:bg-gray-700/50"
                                                 data-name="{{ strtolower($student->user->name ?? '-') }}">
                                                <label class="flex items-center w-full space-x-3 cursor-pointer">
                                                    <div class="relative">
                                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                            class="sr-only student-checkbox" onchange="updateSelectedCount()">
                                                        <div class="w-5 h-5 transition-all duration-200 bg-white border-2 border-gray-300 rounded dark:bg-gray-600 dark:border-gray-500 checkbox-design">
                                                            <svg class="w-3 h-3 text-white transition-opacity duration-200 opacity-0" fill="currentColor" viewBox="0 0 20 20" style="margin: 1px;">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $student->user->name ?? '-' }}</span>
                                                            <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                                                @if($student->user->email ?? false)
                                                                    <span>{{ $student->user->email }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- No Results Message -->
                                    <div id="no-results" class="hidden py-8 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.175-5.5-2.709"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada siswa yang ditemukan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Students Preview -->
                            <div id="selected-preview" class="hidden p-4 border border-indigo-200 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 dark:border-indigo-800/50">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-indigo-900 dark:text-indigo-300">Siswa yang Dipilih:</p>
                                        <div id="selected-names" class="flex flex-wrap gap-2 mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800/50 dark:border-gray-700">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aksi Cepat:</span>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="selectAllStudents()"
                                        class="px-3 py-1 text-xs font-medium text-indigo-700 transition-colors duration-200 bg-indigo-100 rounded-md hover:bg-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-300 dark:hover:bg-indigo-900/70">
                                        <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Pilih Semua
                                    </button>
                                    <button type="button" onclick="clearAllStudents()"
                                        class="px-3 py-1 text-xs font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                        <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Hapus Semua
                                    </button>
                                </div>
                            </div>
                        </div>

                        <style>
                        .student-checkbox:checked + .checkbox-design {
                            @apply bg-indigo-600 border-indigo-600;
                        }
                        .student-checkbox:checked + .checkbox-design svg {
                            @apply opacity-100;
                        }
                        #select-all:checked + #select-all-checkbox {
                            @apply bg-indigo-600 border-indigo-600;
                        }
                        #select-all:checked + #select-all-checkbox svg {
                            @apply opacity-100;
                        }
                        </style>

                        <script>
                        function updateSelectedCount() {
                            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
                            const count = checkboxes.length;

                            // Update counter
                            document.getElementById('selected-count').textContent = count;

                            // Update preview
                            const preview = document.getElementById('selected-preview');
                            const namesContainer = document.getElementById('selected-names');

                            if (count > 0) {
                                preview.classList.remove('hidden');
                                const names = Array.from(checkboxes).map(cb => {
                                    const label = cb.closest('.student-item').querySelector('span').textContent;
                                    return `<span class="px-2 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full dark:bg-indigo-900/50 dark:text-indigo-300">${label}</span>`;
                                }).join(' ');
                                namesContainer.innerHTML = names;
                            } else {
                                preview.classList.add('hidden');
                            }

                            // Update select all checkbox
                            const totalCheckboxes = document.querySelectorAll('.student-checkbox').length;
                            const selectAllCheckbox = document.getElementById('select-all');
                            selectAllCheckbox.checked = count === totalCheckboxes && count > 0;
                        }

                        function toggleSelectAll() {
                            const selectAllCheckbox = document.getElementById('select-all');
                            const studentCheckboxes = document.querySelectorAll('.student-checkbox');

                            studentCheckboxes.forEach(checkbox => {
                                checkbox.checked = selectAllCheckbox.checked;
                            });

                            updateSelectedCount();
                        }

                        function selectAllStudents() {
                            const studentCheckboxes = document.querySelectorAll('.student-checkbox');
                            studentCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                            updateSelectedCount();
                        }

                        function clearAllStudents() {
                            const studentCheckboxes = document.querySelectorAll('.student-checkbox');
                            studentCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            updateSelectedCount();
                        }

                        function filterStudents() {
                            const searchTerm = document.getElementById('student-search').value.toLowerCase();
                            const studentItems = document.querySelectorAll('.student-item');
                            const noResults = document.getElementById('no-results');
                            let visibleCount = 0;

                            studentItems.forEach(item => {
                                const studentName = item.dataset.name;
                                if (studentName.includes(searchTerm)) {
                                    item.style.display = 'flex';
                                    visibleCount++;
                                } else {
                                    item.style.display = 'none';
                                }
                            });

                            // Show/hide no results message
                            if (visibleCount === 0 && searchTerm !== '') {
                                noResults.classList.remove('hidden');
                            } else {
                                noResults.classList.add('hidden');
                            }
                        }

                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            updateSelectedCount();
                        });
                        </script>

                        <div class="space-y-2">
                            <label for="kelas_tahfidz_id"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-300">Pilih Kelas
                                Tahfidz <span class="text-red-500">*</span></label>
                            <select name="kelas_tahfidz_id" id="kelas_tahfidz_id" required
                                class="text-sm block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('kelas_tahfidz_id') border-red-500 ring-1 ring-red-500 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasTahfidz as $kelas)
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="tahun_ajaran_id"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-300">Tahun
                                Ajaran <span class="text-red-500">*</span></label>
                            <select name="tahun_ajaran_id" id="tahun_ajaran_id" required
                            class="text-sm block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tahun_ajaran_id') border-red-500 ring-1 ring-red-500 @enderror">
                                {{-- <option value="">-- Pilih Tahun Ajaran --</option> --}}
                                @foreach ($tahunAjaran as $tahun)
                                    <option value="{{ $tahun->id }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $tahun->tahun_ajaran }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.manajemen_siswa_kelas.index') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-200 bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
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
</x-app-layout>
