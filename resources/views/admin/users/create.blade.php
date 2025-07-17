<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Tambah User Baru"
                    description="Isi formulir berikut untuk membuat akun pengguna baru dalam sistem."
                    breadcrumbTitle="Data User" :route="route('admin.users.index')" breadcrumbActive="Tambah Baru" buttonText="Kembali" />

                <!-- Form Card -->
                <div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Avatar Upload -->
                        <div class="flex flex-col items-center justify-center mb-6">
                            <div class="relative w-24 h-24 mb-3 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700"
                                id="avatar-preview">
                                <svg class="absolute w-full h-full text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <label for="avatar" class="cursor-pointer">
                                <span
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                    Upload Foto Profil
                                </span>
                                <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*"
                                    onchange="previewImage()">
                            </label>
                            @error('avatar')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Two Columns Layout -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Full Name Field -->
                            <div class="col-span-2 sm:col-span-1">
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap
                                    <span class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="col-span-2 sm:col-span-1">
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span
                                        class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                                        placeholder="email@example.com" required>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role Field -->
                            <div class="col-span-2 sm:col-span-1">
                                <label for="role"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role <span
                                        class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <select id="role" name="role"
                                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('role') border-red-500 @enderror"
                                        required onchange="updateIdLabel()">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Guru
                                        </option>
                                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Siswa
                                        </option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>



                            <!-- Password Field -->
                            <div class="col-span-2 sm:col-span-1">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password <span
                                        class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" id="password" name="password"
                                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror"
                                        placeholder="Minimal 8 karakter" required>
                                    <button type="button" onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            id="eye-icon-password">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="col-span-2 sm:col-span-1">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi
                                    Password <span class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="block w-full pl-10 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Ulangi password" required>
                                    <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            id="eye-icon-password_confirmation">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div
                            class="p-4 mt-6 border border-indigo-200 rounded-md bg-indigo-50 dark:bg-indigo-900/30 dark:border-indigo-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Informasi
                                        Penting</h3>
                                    <div class="mt-2 text-sm text-indigo-700 dark:text-indigo-400">
                                        <ul class="pl-5 space-y-1 list-disc">
                                            <li>Password harus terdiri dari minimal 8 karakter</li>
                                            <li>Email verifikasi akan dikirim secara otomatis</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div
                            class="flex items-center justify-end gap-4 pt-5 mt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </main>

            <script>
                function previewImage() {
                    const input = document.getElementById('avatar');
                    const preview = document.getElementById('avatar-preview');

                    if (input.files && input.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            preview.innerHTML =
                                `<img src="${e.target.result}" class="object-cover w-full h-full" alt="Preview">`;
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function togglePassword(fieldId) {
                    const passwordField = document.getElementById(fieldId);
                    const eyeIcon = document.getElementById(`eye-icon-${fieldId}`);

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeIcon.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                    } else {
                        passwordField.type = 'password';
                        eyeIcon.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                    }
                }

                function updateIdLabel() {
                    const role = document.getElementById('role').value;
                    const idLabel = document.getElementById('id-label');
                    const idInput = document.getElementById('id_number');

                    if (role === 'teacher') {
                        idLabel.textContent = 'NIP';
                        idInput.placeholder = 'Masukkan NIP';
                    } else if (role === 'student') {
                        idLabel.textContent = 'NIS';
                        idInput.placeholder = 'Masukkan NIS';
                    } else {
                        idLabel.textContent = 'Nomor Identitas';
                        idInput.placeholder = 'Masukkan nomor identitas';
                    }
                }

                // Initialize the label on page load
                document.addEventListener('DOMContentLoaded', function() {
                    updateIdLabel();
                });
            </script>
        </div>
    </div>
</x-app-layout>
