<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Update Siswa Dalam Kelas"
                    description="Update informasi siswa dan kelas dalam tahun ajaran tertentu."
                    breadcrumbTitle="Data Siswa Kelas" :route="route('admin.manajemen_siswa_kelas.index')" breadcrumbActive="Update Data"
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

                    <form action="{{ route('admin.manajemen_siswa_kelas.update', $assignment->id) }}" method="POST"
                        class="p-6 space-y-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">

                        <div class="space-y-2">
                            <label
                                class="flex items-center space-x-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                <span>Nama Siswa</span>

                            </label>
                            <input type="text" value="{{ $assignment->siswa->user->name }}" readonly
                            class="block w-full mt-1 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" />
                        </div>

                        <div class="space-y-2">
                            <label for="kelas_tahfidz_id"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-300">Pilih Kelas
                                Tahfidz <span class="text-red-500">*</span></label>
                            <select name="kelas_tahfidz_id" id="kelas_tahfidz_id" required
                                class="text-sm block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('kelas_tahfidz_id') border-red-500 ring-1 ring-red-500 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @forelse ($kelasTahfidz as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('kelas_tahfidz_id', $assignment->kelas_tahfidz_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->tingkatan_label ?? '-' }} ({{ $kelas->nama }})
                                    </option>
                                @empty
                                    <option value="">Belum ada data kelas</option>
                                @endforelse
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
