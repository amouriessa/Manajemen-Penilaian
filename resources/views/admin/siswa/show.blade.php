<x-app-layout>
    <div class="flex flex-col min-h-screen overflow-hidden md:flex-row">
        <!-- Main Content -->
        <div class="{{ empty($sidebar) ? 'w-full' : 'flex-1' }} overflow-y-auto bg-gray-100 dark:bg-gray-900">
            <main class="w-full max-w-4xl p-4 mx-auto space-y-6 sm:p-6 lg:p-8">
                <x-header-create title="Detail Data Siswa"
                    description="Berikut adalah detail informasi siswa yang dipilih." breadcrumbTitle="Data Siswa"
                    :route="route('admin.siswa.index')" breadcrumbActive="Detail User" buttonText="Kembali" />

                <div
                    class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl dark:bg-gray-800 dark:border-gray-700">

                    <div class="p-6 space-y-6">

                        <div class="flex flex-col items-center justify-center mb-6">
                            <div
                                class="relative inline-flex items-center justify-center w-24 h-24 mb-4 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700">
                                @if ($avatarUrl)
                                    <a href="{{ $avatarUrl }}" target="_blank" title="Lihat Foto">
                                        <img src="{{ $avatarUrl }}" alt="Foto Profil {{ $student->user->name }}"
                                            class="object-cover w-full h-full transition-transform duration-200 hover:scale-105">
                                    </a>
                                @else
                                    <span class="text-3xl font-medium text-gray-600 uppercase dark:text-gray-300">
                                        {{ substr($student->user->name, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="user_name" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Nama Lengkap
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->user->name }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="user_email" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Email User
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->user->email }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="nis" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    NIS
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->nis ?? 'Tidak ada NIS' }}</p>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Jenis Kelamin
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="tanggal_lahir" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Tanggal Lahir
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="tahun_angkatan"
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Tahun Angkatan
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->tahunAngkatan->tahun_angkatan ?? '-' }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="alamat" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Alamat
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->alamat ?? '-' }}</p>
                            </div>

                            <div class="space-y-2">
                                <label for="status" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Status Siswa
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst($student->status) }}
                                </p>
                            </div>


                            <div class="space-y-2">
                                <label for="kelas_aktif" class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Kelas Saat Ini
                                </label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    @if ($kelasAktif)
                                        {{ $kelasAktif->kelasTahfidz->nama ?? '-' }}
                                        ({{ $kelasAktif->kelasTahfidz->tingkatan_label ?? '-' }})
                                    @else
                                        <span class="italic text-gray-500">Belum ditempatkan</span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
