<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Detail Data Guru" description="Berikut adalah detail informasi guru yang dipilih."
                    breadcrumbTitle="Data Guru" :route="route('admin.guru.index')" breadcrumbActive="Detail User" buttonText="Kembali" />

                <!-- Detail Card -->
                <div class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">
                    <!-- Display Teacher's Details -->
                    <div class="p-6 space-y-6">

                        <!-- Avatar User -->
                        <div class="flex flex-col items-center justify-center mb-6">
                            <div class="relative inline-flex items-center justify-center w-24 h-24 mb-4 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700">
                                @if ($avatarUrl)
                                    <a href="{{ $avatarUrl }}" target="_blank" title="Lihat Foto">
                                        <img src="{{ $avatarUrl }}" alt="Foto Profil {{ $teacher->user->name }}"
                                            class="object-cover w-full h-full transition-transform duration-200 hover:scale-105">
                                    </a>
                                @else
                                    <span class="text-3xl font-medium text-gray-600 uppercase dark:text-gray-300">
                                        {{ substr($teacher->user->name, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Nama Lengkap User -->
                            <div class="space-y-2">
                                <label for="user_name" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Nama Lengkap
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->user->name }}</p>
                            </div>

                            <!-- Email User -->
                            <div class="space-y-2">
                                <label for="user_email" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Email User
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->user->email }}</p>
                            </div>

                            <!-- NIP -->
                            <div class="space-y-2">
                                <label for="nip" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    NIP
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->nip ?? 'Tidak ada NIP' }}</p>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Jenis Kelamin
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="space-y-2">
                                <label for="birthdate" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Tanggal Lahir
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($teacher->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                            </div>

                            <!-- No. HP -->
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    No. HP
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">+62{{ $teacher->nomor_telp }}</p>
                            </div>

                            {{-- <!-- Bidang Mengajar -->
                            <div class="space-y-2">
                                <label for="subject" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Bidang Mengajar
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->subject }}</p>
                            </div> --}}

                            <!-- Status -->
                            <div class="space-y-2">
                                <label for="status" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Status Mengajar
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->status ? 'Aktif' : 'Non-Aktif' }}</p>
                            </div>

                            <!-- Alamat -->
                            <div class="space-y-2">
                                <label for="address" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Alamat
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $teacher->alamat }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
