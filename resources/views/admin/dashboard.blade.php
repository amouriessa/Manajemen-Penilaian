<x-app-layout>
    <div class="flex min-h-screen overflow-hidden">

        <x-slot name="sidebar">
            <x-sidebar-admin />
        </x-slot>

        <div class="flex-1 p-4 overflow-y-auto md:p-6">
            <div class="mx-auto max-w-7xl">

                {{-- Info Cards --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="p-4 text-white transition transform shadow-md sm:p-5 rounded-xl bg-[linear-gradient(145deg,#2D3F63_0%,#1E2A40_100%)] hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium">Total Guru</h3>
                                <p class="mt-2 font-serif text-4xl font-medium">{{ $guruTotal ?? 0 }}</p>
                            </div>
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-[linear-gradient(145deg,#D4A355_0%,#B07833_100%)] hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium">Total Siswa</h3>
                                <p class="mt-2 font-serif text-4xl font-medium">{{ $siswaTotal ?? 0 }}</p>
                            </div>
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm">
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
                        class="p-5 text-white transition transform shadow-md rounded-xl bg-[linear-gradient(145deg,#B5655A_0%,#8B4040_100%)] hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium">Total Kelas</h3>
                                <p class="mt-2 font-serif text-4xl font-medium">{{ $kelasTotal ?? 0 }}</p>
                            </div>
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-10 h-10 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3 CARD BAWAH --}}
                <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-3">

                    {{-- Tahun Ajaran Aktif --}}
                    <div class="h-full">
                        <div class="p-6 bg-[#FDFAF5] shadow-md rounded-xl h-full flex flex-col justify-between">
                            <div>
                                <h2 class="pb-3 mb-4 text-xs tracking-[0.2em] uppercase font-semibold 
                                    text-[#3A3028] border-b border-[#E5DED6]">
                                    Tahun Ajaran Aktif
                                </h2>

                                <p class="text-xs text-[#8C8070]">Periode Akademik</p>

                                <p class="mt-3 mb-3 text-2xl font-bold text-[#2D3F63] font-serif">
                                    {{ $tahunAjaranAktif?->tahun_ajaran ?? 'Belum Ada Tahun Ajaran Aktif' }}
                                </p>

                                @if($tahunAjaranAktif)
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    bg-[#EAF2EE] text-[#5C8270]">
                                    ● Sedang Berlangsung
                                </span>
                                @endif
                            </div>

                            {{-- Button --}}
                            <div class="mt-6">
                                <a href="{{ route('admin.tahun_ajaran.create') }}"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white 
                                    rounded-lg bg-[#2D3F63] hover:bg-[#1E2A40] transition">
                                    + Tambah Tahun Ajaran
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Hafalan --}}
                    <div class="h-full">
                        <div class="p-6 bg-[#FDFAF5] shadow-md rounded-xl h-full flex flex-col">
                            <h4 class="pb-3 mb-4 text-sm font-semibold border-b 
                                text-[#3A3028] border-[#E5DED6] font-serif">
                                Statistik Hafalan per Tingkatan
                            </h4>

                            <div class="relative w-full h-[260px]">
                                <canvas id="hafalanChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Surah Terbanyak --}}
                    <div class="h-full">
                        <div class="p-6 bg-[#FDFAF5] shadow-md rounded-xl h-full flex flex-col">
                            <h4 class="pb-3 mb-4 text-sm font-semibold border-b 
                                text-[#3A3028] border-[#E5DED6] font-serif">
                                Surah Paling Banyak Dihafal
                            </h4>

                            <div class="relative w-full w-[150px] h-[150px] mx-auto">
                                <canvas id="surahPieChart"></canvas>
                            </div>

                            <div class="mt-6 space-y-2">
                                @foreach($surahStatistik as $index => $surah)
                                    @php
                                        $colors = ['#2D3F63', '#D4A355', '#B5655A', '#5C8270', '#6B5CA5'];
                                        $total = $surahStatistik->sum('total');
                                        $percentage = $total > 0 
                                            ? round(($surah->total / $total) * 100) 
                                            : 0;
                                    @endphp

                                    <div class="flex items-center justify-between px-4 py-2 
                                        bg-[#F7EDDA] border rounded-lg border-[#E5DED6]">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full"
                                                style="background: {{ $colors[$index % 5] }}"></span>
                                            <span class="text-xs text-[#3A3028]">
                                                {{ $surah->nama }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-semibold text-[#3A3028]">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @push('scripts')
        @php
            $barColors = $grafikHafalan->map(function ($g, $i) {
                $colors = ['#2D3F63','#D4A355','#B5655A','#5C8270','#6B5CA5'];
                return $colors[$i % count($colors)];
            });
        @endphp
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>

            // ===== BAR CHART (FIX 0-100) =====
            const ctx = document.getElementById('hafalanChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($grafikHafalan->pluck('kelas_label')),
                    datasets: [{
                        data: @json($grafikHafalan->pluck('rata_rata')),
                        backgroundColor: @json($barColors),
                        borderRadius: 8,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            },
                            grid: {
                                color: '#ECE6DF'
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });


            // ===== DOUGHNUT CHART =====
            const pieCtx = document.getElementById('surahPieChart');
            const surahData = @json($surahStatistik->pluck('total'));
            const totalSurah = surahData.reduce((a, b) => a + b, 0);

            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($surahStatistik->pluck('nama')),
                    datasets: [{
                        data: surahData,
                        backgroundColor: ['#2D3F63','#D4A355','#B5655A','#5C8270','#6B5CA5'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }
                    }
                },
                plugins: [{
                    id: 'centerText',
                    beforeDraw(chart) {
                        const { width, height } = chart;
                        const ctx = chart.ctx;

                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        ctx.fillStyle = '#8C8070';
                        ctx.font = '12px sans-serif';
                        ctx.fillText('Total', width / 2, height / 2 - 8);

                        ctx.fillStyle = '#2D3F63';
                        ctx.font = 'bold 18px serif';
                        ctx.fillText(totalSurah, width / 2, height / 2 + 10);

                        ctx.restore();
                    }
                }]
            });

        </script>
        @endpush

    </div>
</x-app-layout>