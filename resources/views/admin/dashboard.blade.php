<x-app-layout>
    <div class="flex min-h-screen overflow-hidden">

        <!-- Sidebar -->
        <x-slot name="sidebar">
            <x-sidebar-admin />
        </x-slot>

        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-y-auto md:p-6">
            <div class="mx-auto max-w-7xl">
                <!-- Header Section -->
                <div class="flex flex-col items-start justify-between gap-4 mb-10 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800 md:text-2xl">Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">Anda dapat mengelola akun pengguna, biodata, dan data
                            akademik sekolah.
                        </p>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="p-4 text-white transition transform shadow-md sm:p-5 rounded-xl bg-gradient-to-r from-indigo-300 to-indigo-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Guru</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $guruTotal }}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 opacity-50" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-gradient-to-r from-yellow-300 to-yellow-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Siswa</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $siswaTotal }}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 opacity-50" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-gradient-to-r from-red-300 to-red-500 hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium">Total Kelas</h3>
                                <p class="mt-2 text-4xl font-bold">{{ $kelasTotal }}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-10 h-10 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Tahun Ajaran Aktif --}}
                    <div class="mt-6">
                        <div class="p-5 bg-white shadow-md rounded-xl">
                            <h2 class="mb-2 text-lg font-semibold text-gray-700">Tahun Ajaran Aktif</h2>
                            <p class="text-xl font-bold text-indigo-600">
                                {{ $tahunAjaranAktif?->tahun_ajaran ?? 'Belum Ada Tahun Ajaran Aktif' }}
                            </p>
                        </div>
                    </div>

                    {{-- Statistik Hafalan dan Surah Terpopuler --}}
                    <div class="mt-6">
                        <div class="p-6 bg-white shadow-md rounded-xl">
                            <h4 class="mb-4 text-lg font-semibold text-gray-700">Statistik Hafalan per Kelas</h4>
                            <canvas id="hafalanChart" class="w-full h-64"></canvas>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="p-6 bg-white shadow-md rounded-xl">
                            <h4 class="mb-4 text-lg font-semibold text-gray-700">Surah Paling Banyak Dihafal</h4>
                            <canvas id="surahPieChart" class="w-full h-64"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('hafalanChart');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($grafikHafalan->pluck('kelas_label')),
                        datasets: [{
                            label: 'Rata-rata Nilai Hafalan',
                            data: @json($grafikHafalan->pluck('rata_rata')),
                            backgroundColor: ['#6366f1', '#ef4444', '#f59e0b', '#10b981'],
                            maxBarThickness: 60
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                suggestedMin: 0,
                                suggestedMax: 100
                            }
                        }
                    }
                });

                const pieCtx = document.getElementById('surahPieChart');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($surahStatistik->pluck('nama')),
                        datasets: [{
                            label: 'Jumlah Ayat',
                            data: @json($surahStatistik->pluck('total')),
                            backgroundColor: [
                                // '#6366f1', '#ef4444', '#f59e0b', '#10b981',
                                // '#3b82f6', '#8b5cf6', '#ec4899', '#22d3ee',
                                // '#f97316', '#14b8a6'

                                '#6366f1', // Indigo (Guru)
                                '#facc15', // Yellow (Siswa)
                                '#ef4444', // Red (Kelas)
                                '#a855f7', // Purple (Tambahan)
                                // Warna cadangan kalau data lebih dari 4
                                '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#22d3ee'
                            ],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            </script>
        @endpush
</x-app-layout>
