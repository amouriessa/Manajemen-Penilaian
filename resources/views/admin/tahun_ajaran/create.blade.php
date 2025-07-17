<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Tambah Tahun Ajaran"
                    description="Masukkan informasi tahun ajaran."
                    breadcrumbTitle="Tahun Ajaran" :route="route('admin.tahun_ajaran.index')" breadcrumbActive="Tambah Baru" buttonText="Kembali" />

                <!-- Form Card -->
                <div class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">
                    @if ($errors->any())
                    <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/30">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-400">Terdapat beberapa kesalahan:</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside dark:text-red-300">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('admin.tahun_ajaran.store') }}" method="POST" class="p-6 space-y-2">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Tahun Ajaran (2 field + auto generate) -->
                            <div class="space-y-2">
                                <label for="tahun_awal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="tahun_awal" id="tahun_awal" value="{{ old('tahun_awal') }}" placeholder="2024"
                                        required min="2000" max="2100"
                                        class="w-1/2 text-sm block border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tahun_awal') border-red-500 ring-1 ring-red-500 @enderror">
                                    <span class="self-center">/</span>
                                    <input type="number" name="tahun_akhir" id="tahun_akhir" value="{{ old('tahun_akhir') }}" placeholder="2025"
                                        required min="2000" max="2100"
                                        class="w-1/2 text-sm block border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tahun_akhir') border-red-500 ring-1 ring-red-500 @enderror">
                                </div>
                                <input type="hidden" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}">
                                @error('tahun_awal')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('tahun_akhir')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan tahun mulai, tahun akhir akan otomatis terisi. Contoh: 2024 → 2025</p>
                            </div>

                            <script>
                                const yearStartInput = document.getElementById('tahun_awal');
                                const yearEndInput = document.getElementById('tahun_akhir');
                                const academicYearInput = document.getElementById('tahun_ajaran');

                                function updateYearEnd() {
                                    const start = parseInt(yearStartInput.value);
                                    if (!isNaN(start)) {
                                        yearEndInput.value = start + 1;
                                        academicYearInput.value = start + '/' + (start + 1);
                                    } else {
                                        yearEndInput.value = '';
                                        academicYearInput.value = '';
                                    }
                                }

                                yearStartInput.addEventListener('input', updateYearEnd);
                                yearEndInput.addEventListener('input', function() {
                                    const start = parseInt(yearStartInput.value);
                                    const end = parseInt(yearEndInput.value);
                                    if (!isNaN(start) && !isNaN(end)) {
                                        academicYearInput.value = start + '/' + end;
                                    }
                                });

                                // Auto-update saat halaman reload kalau ada old value
                                if (yearStartInput.value) {
                                    updateYearEnd();
                                }
                            </script>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input id="status_1" name="status" type="radio" value="1" {{ old('status') == '1' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="status_1" class="block ml-2 text-sm text-gray-700 dark:text-gray-300">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="status_0" name="status" type="radio" value="0" {{ old('status') == '0' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="status_0" class="block ml-2 text-sm text-gray-700 dark:text-gray-300">
                                            Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.tahun_ajaran.index') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-200 bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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
