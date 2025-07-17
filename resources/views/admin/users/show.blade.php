<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Detail Data User" description="Informasi dan detail lengkap data pengguna."
                    breadcrumbTitle="Data User" :route="route('admin.users.index')" breadcrumbActive="Detail User" buttonText="Kembali" />

                @php
                    $role = $user->roles->first()?->name;
                    $roleDisplay =
                        [
                            'teacher' => 'Guru',
                            'student' => 'Siswa',
                            'admin' => 'Admin',
                        ][$role] ?? '-';

                    $statusClass = $user->is_logged_in
                        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
                        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';

                    $statusText = $user->is_logged_in ? 'Online' : 'Offline';
                @endphp

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Kartu profil -->
                    <div
                        class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 text-center">
                            <div
                                class="relative inline-flex items-center justify-center w-24 h-24 mb-4 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700">
                                @if ($avatarUrl)
                                    <a href="{{ $avatarUrl }}" target="_blank" title="Lihat Foto">
                                        <img src="{{ $avatarUrl }}" alt="Foto Profil {{ $user->name }}"
                                            class="object-cover w-full h-full transition-transform duration-200 hover:scale-105">
                                    </a>
                                @else
                                    <span class="text-3xl font-medium text-gray-600 uppercase dark:text-gray-300">
                                        {{ substr($user->name, 0, 1) }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>

                            <div class="flex justify-center mt-4 space-x-3">

                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-orange-800 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Detail informasi -->
                    <div
                        class="overflow-hidden bg-white border border-gray-200 shadow-sm lg:col-span-2 rounded-xl dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Informasi Detail</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Data lengkap tentang user yang dipilih.
                            </p>
                        </div>

                        <div class="p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <!-- Nama -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}</dd>
                                </div>

                                <!-- Email -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd
                                        class="flex items-center mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->email }}
                                        @if ($user->email_verified_at)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1 text-green-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </dd>
                                </div>

                                <!-- Role -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Peran</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $roleDisplay }}</dd>
                                </div>

                                <!-- Status Akun -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Akun</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Terakhir Login -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Login</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                                    </dd>
                                </div>

                                <!-- Tanggal Dibuat -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuat</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->created_at->translatedformat('d F Y, H:i') }}
                                    </dd>
                                </div>

                                <!-- Tanggal Diupdate -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diupdate
                                    </dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->updated_at->translatedformat('d F Y, H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
