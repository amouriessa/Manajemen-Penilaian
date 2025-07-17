<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Tambah Tahun Angkatan"
                    description="Masukkan informasi tahun angkatan."
                    breadcrumbTitle="Tahun Angkatan" :route="route('admin.tahun_angkatan.index')" breadcrumbActive="Tambah Baru" buttonText="Kembali" />

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

                    <form action="{{ route('admin.tahun_angkatan.store') }}" method="POST" class="p-6 space-y-2">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Tahun Angkatan -->
                            <div class="space-y-2">
                                <label for="tahun_angkatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tahun Angkatan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="tahun_angkatan" id="tahun_angkatan" value="{{ old('tahun_angkatan') }}"
                                    min="2000" max="{{ now()->year }}"
                                    class="text-sm block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('tahun_angkatan') border-red-500 ring-1 ring-red-500 @enderror"
                                    placeholder="Contoh: 2025">
                                @error('tahun_angkatan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

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
                            <a href="{{ route('admin.tahun_angkatan.index') }}"
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
