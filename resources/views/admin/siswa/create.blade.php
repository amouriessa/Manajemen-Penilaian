<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Tambah Data Siswa"
                    description="Masukkan data siswa dari pengguna yang sudah terdaftar dalam sistem."
                    breadcrumbTitle="Data Siswa" :route="route('admin.siswa.index')" breadcrumbActive="Tambah Baru" buttonText="Kembali" />

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

                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="p-6 space-y-2">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="user_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <select name="user_id" id="user_id" required
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                </select>
                                @error('user_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ketik nama siswa minimal 3 huruf
                                    untuk mencari.</p>
                            </div>

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

                                    const selectUser = new TomSelect('#user_id', {
                                        valueField: 'value',
                                        labelField: 'text',
                                        searchField: 'text',
                                        placeholder: "-- Ketik nama siswa --",
                                        loadThrottle: 300,
                                        maxOptions: 20,
                                        minQueryLength: 3,
                                        load: function(query, callback) {
                                            fetch(`{{ route('admin.siswa.searchUser') }}?q=${encodeURIComponent(query)}`)
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

                            <div class="space-y-2">
                                <label for="nis"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    NIS <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required
                                    class="block text-sm w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('nis') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">NIS tidak lebih dari 7 karakter.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input id="gender_l" name="jenis_kelamin" type="radio" value="L"
                                            {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="gender_l"
                                            class="ml-2 text-sm text-gray-700 dark:text-gray-300">Laki-laki</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="gender_p" name="jenis_kelamin" type="radio" value="P"
                                            {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="gender_p"
                                            class="ml-2 text-sm text-gray-700 dark:text-gray-300">Perempuan</label>
                                    </div>
                                </div>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="tanggal_lahir"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}"
                                    class="text-sm block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tanggal_lahir') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="tahun_angkatan_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tahun Angkatan <span class="text-red-500">*</span>
                                </label>
                                <select name="tahun_angkatan_id" id="tahun_angkatan_id" required
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tahun_angkatan_id') border-red-500 ring-1 ring-red-500 @enderror">
                                    <option value="">-- Pilih Tahun Angkatan --</option>
                                    @foreach ($tahunAngkatan as $tahun_angkatan)
                                        <option value="{{ $tahun_angkatan->id }}"
                                            {{ old('tahun_angkatan_id') == $tahun_angkatan->id ? 'selected' : '' }}>
                                            {{ $tahun_angkatan->tahun_angkatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_angkatan_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    new TomSelect('#tahun_angkatan_id', {
                                        create: false,
                                        sortField: {
                                            field: "text",
                                            direction: "asc"
                                        },
                                        placeholder: "-- Pilih Tahun Angkatan --",
                                    });
                                });
                            </script>

                            <div class="space-y-2">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status"
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('status') border-red-500 ring-1 ring-red-500 @enderror"
                                    required>
                                    <option value="" disabled {{ old('status') === null ? 'selected' : '' }}>--
                                        Pilih status --</option>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus
                                    </option>
                                    <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah
                                    </option>
                                    <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4 space-y-2 md:col-span-2">
                                <label for="alamat"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Alamat
                                </label>
                                <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat lengkap"
                                    class="text-sm block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('alamat') border-red-500 ring-1 ring-red-500 @enderror">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.siswa.index') }}"
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
