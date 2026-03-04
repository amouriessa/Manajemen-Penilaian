<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian — {{ $selectedStudent->user->name }}</title>
    <style>
        /* ================================
         * Reset & Base
         * ================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
            line-height: 1.4;
        }

        /* ================================
         * Page Layout — A4 portrait
         * ================================ */
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 20mm;
        }

        @media print {
            body {
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            /* Baris tabel jangan terpotong di tengah halaman */
            tr {
                page-break-inside: avoid;
            }

            /* Jika ada banyak surah dalam satu penilaian, perbolehkan terpotong antar penilaian */
            .penilaian-group {
                page-break-inside: avoid;
            }

            /* Header tabel muncul di setiap halaman */
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }

        .container {
            max-width: 780px;
            margin: 0 auto;
            padding: 10px;
        }

        /* ================================
         * Header Kop Surat
         * ================================ */
        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px double #1a1a1a;
            padding-bottom: 8px;
            margin-bottom: 12px;
            gap: 12px;
        }

        .kop-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .kop-text h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            font-size: 10px;
            color: #444;
        }

        /* ================================
         * Judul Laporan
         * ================================ */
        .report-title {
            text-align: center;
            margin: 10px 0 14px;
        }

        .report-title h2 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-title .periode-info {
            font-size: 10px;
            color: #555;
            margin-top: 3px;
        }

        /* ================================
         * Info Siswa
         * ================================ */
        .info-siswa {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
            background: #f9f9f9;
        }

        .info-siswa table {
            border-collapse: collapse;
            width: 100%;
        }

        .info-siswa td {
            padding: 2px 6px;
            font-size: 10.5px;
        }

        .info-siswa td:first-child {
            font-weight: bold;
            width: 120px;
            color: #333;
        }

        /* ================================
         * Tabel Penilaian
         * ================================ */
        .table-penilaian {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .table-penilaian th {
            background-color: #2d3748;
            color: #fff;
            padding: 5px 6px;
            text-align: center;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .table-penilaian th.text-left {
            text-align: left;
        }

        .table-penilaian td {
            border: 1px solid #ddd;
            padding: 5px 6px;
            vertical-align: middle;
        }

        .table-penilaian tbody tr:nth-child(even) {
            background-color: #f7f8fa;
        }

        .table-penilaian tbody tr:hover {
            background-color: #eef2ff;
        }

        .surah-name {
            font-weight: 600;
        }

        .ayat-range {
            font-size: 9px;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-langsung {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-pengumpulan {
            background: #ede9fe;
            color: #6d28d9;
        }

        .badge-a {
            background: #dcfce7;
            color: #166534;
        }

        .badge-b {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-c {
            background: #fef9c3;
            color: #92400e;
        }

        .badge-d {
            background: #fee2e2;
            color: #991b1b;
        }

        .nilai-total {
            font-weight: bold;
            color: #4338ca;
        }

        /* ================================
         * Ringkasan
         * ================================ */
        .ringkasan {
            margin-top: 14px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ringkasan-item {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 12px;
            text-align: center;
            flex: 1;
            min-width: 80px;
        }

        .ringkasan-item .nilai {
            font-size: 16px;
            font-weight: bold;
            color: #4338ca;
        }

        .ringkasan-item .label {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        /* ================================
         * Tanda Tangan
         * ================================ */
        .ttd-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box {
            text-align: center;
            width: 180px;
        }

        .ttd-box .kota-tanggal {
            font-size: 10px;
        }

        .ttd-box .jabatan {
            font-size: 10px;
            margin-top: 4px;
        }

        .ttd-box .nama {
            font-size: 10.5px;
            font-weight: bold;
            margin-top: 50px;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        /* ================================
         * Tombol aksi (tidak tercetak)
         * ================================ */
        .action-bar {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 8px;
            z-index: 999;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-print {
            background: #4f46e5;
            color: #fff;
        }

        .btn-back {
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">

        {{-- Kop Surat --}}
        <div class="kop">
            <div class="kop-logo">
                {{-- Ganti src dengan logo sekolah --}}
                <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            </div>
            <div class="kop-text">
                <h1>YAYASAN PENDIDIKAN ISLAMIYAH NGAWI</h1>
                <h1>SMP Islamiyah Widodaren</h1>
                <p>Kedungprahu, Widodaren, Ngawi, Kode Pos 63256</p>
            </div>
        </div>

        {{-- Judul --}}
        <div class="report-title">
            <h2>Laporan Penilaian Hafalan Al-Qur'an</h2>
            <div class="periode-info">
                @if (request('periode') === 'bulan')
                    Periode: {{ \Carbon\Carbon::create()->month(request('bulan'))->translatedFormat('F') }}
                    {{ request('tahun') }}
                @elseif (request('periode') === 'tanggal')
                    Periode: {{ \Carbon\Carbon::parse(request('dari_tanggal'))->translatedFormat('d F Y') }}
                    &ndash; {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->translatedFormat('d F Y') }}
                @else
                    Semua Periode
                @endif
            </div>
        </div>

        {{-- Info Siswa --}}
        <div class="info-siswa">
            <table>
                <tr>
                    <td>Nama Siswa</td>
                    <td>: <strong>{{ $selectedStudent->user->name }}</strong></td>
                    <td>Kelas</td>
                    <td>:
                        @php
                            $kelasAktif = $selectedStudent->riwayatKelas
                                ->where('tahun_ajaran_id', request('tahun_ajaran_id'))
                                ->first()?->kelasTahfidz;
                        @endphp
                        {{ $kelasAktif
                            ? ($kelasAktif->tingkatan_label
                                ? 'Kelas ' . $kelasAktif->tingkatan_label . ' - ' . $kelasAktif->nama
                                : $kelasAktif->nama)
                            : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>NIS / Email</td>
                    <td>: {{ $selectedStudent->nis ?? $selectedStudent->user->email }}</td>
                    <td>Dicetak</td>
                    <td>: {{ now()->translatedFormat('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Tabel Penilaian --}}
        <table class="table-penilaian">
            <thead>
                <tr>
                    <th style="width:28px">No</th>
                    <th class="text-left" style="width:130px">Surah & Ayat</th>
                    <th style="width:70px">Jenis Penilaian</th>
                    <th style="width:70px">Jenis Hafalan</th>
                    <th style="width:70px">Tanggal</th>
                    <th style="width:38px">Tajwid</th>
                    <th style="width:40px">Harakat</th>
                    <th style="width:38px">Makhraj</th>
                    <th style="width:40px">Total</th>
                    <th style="width:50px">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse ($penilaian as $item)
                    @php
                        $surahs = collect();
                        if ($item->jenis_penilaian === 'langsung') {
                            $surahs = $item->surahHafalanPenilaian ?? collect();
                        } elseif ($item->jenis_penilaian === 'pengumpulan' && $item->tugasHafalan) {
                            $surahs = $item->tugasHafalan->surahHafalan ?? collect();
                        }
                        $surahCount = max($surahs->count(), 1);
                    @endphp

                    @if ($surahs->isNotEmpty())
                        @foreach ($surahs as $idx => $sh)
                            <tr class="penilaian-group">
                                @if ($idx === 0)
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">{{ $no++ }}
                                    </td>
                                @endif
                                <td>
                                    <div class="surah-name">{{ $sh->surah->nama ?? 'N/A' }}</div>
                                    <div class="ayat-range">Ayat {{ $sh->ayat_awal }}–{{ $sh->ayat_akhir }}</div>
                                </td>
                                @if ($idx === 0)
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        <span
                                            class="badge {{ $item->jenis_penilaian === 'langsung' ? 'badge-langsung' : 'badge-pengumpulan' }}">
                                            {{ ucfirst($item->jenis_penilaian) }}
                                        </span>
                                    </td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        {{ $item->jenis_hafalan }}</td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        {{ \Carbon\Carbon::parse($item->assessed_at)->translatedFormat('d M Y') }}
                                    </td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        {{ $item->nilai_tajwid }}</td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        {{ $item->nilai_harakat }}</td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        {{ $item->nilai_makhraj }}</td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center" class="nilai-total">
                                        {{ $item->nilai_total }}</td>
                                    <td rowspan="{{ $surahCount }}" style="text-align:center">
                                        <span
                                            class="badge
                                            @if ($item->nilai_total >= 90) badge-a
                                            @elseif($item->nilai_total >= 80) badge-b
                                            @elseif($item->nilai_total >= 70) badge-c
                                            @else badge-d @endif">
                                            {{ $item->predikat_label }}
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="text-align:center">{{ $no++ }}</td>
                            <td style="color:#999;font-style:italic">Surah tidak tersedia</td>
                            <td style="text-align:center">
                                <span
                                    class="badge {{ $item->jenis_penilaian === 'langsung' ? 'badge-langsung' : 'badge-pengumpulan' }}">
                                    {{ ucfirst($item->jenis_penilaian) }}
                                </span>
                            </td>
                            <td style="text-align:center">{{ $item->jenis_hafalan }}</td>
                            <td style="text-align:center">
                                {{ \Carbon\Carbon::parse($item->assessed_at)->translatedFormat('d M Y') }}</td>
                            <td style="text-align:center">{{ $item->nilai_tajwid }}</td>
                            <td style="text-align:center">{{ $item->nilai_harakat }}</td>
                            <td style="text-align:center">{{ $item->nilai_makhraj }}</td>
                            <td style="text-align:center" class="nilai-total">{{ $item->nilai_total }}</td>
                            <td style="text-align:center">
                                <span
                                    class="badge
                                    @if ($item->nilai_total >= 90) badge-a
                                    @elseif($item->nilai_total >= 80) badge-b
                                    @elseif($item->nilai_total >= 70) badge-c
                                    @else badge-d @endif">
                                    {{ $item->predikat_label }}
                                </span>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:20px; color:#999;">
                            Tidak ada data penilaian pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Ringkasan Statistik --}}
        @if ($penilaian->isNotEmpty())
            @php
                $avg = number_format($penilaian->avg('nilai_total'), 1);
                $max = $penilaian->max('nilai_total');
                $min = $penilaian->min('nilai_total');
                $total = $penilaian->count();
            @endphp
            <div class="ringkasan">
                <div class="ringkasan-item">
                    <div class="nilai">{{ $total }}</div>
                    <div class="label">Total Penilaian</div>
                </div>
                <div class="ringkasan-item">
                    <div class="nilai">{{ $avg }}</div>
                    <div class="label">Rata-rata Nilai</div>
                </div>
                <div class="ringkasan-item">
                    <div class="nilai">{{ $max }}</div>
                    <div class="label">Nilai Tertinggi</div>
                </div>
                <div class="ringkasan-item">
                    <div class="nilai">{{ $min }}</div>
                    <div class="label">Nilai Terendah</div>
                </div>
            </div>
        @endif

        {{-- Tanda Tangan --}}
        <div class="ttd-section">
            <div class="ttd-box">
                <div class="kota-tanggal">_____, {{ now()->translatedFormat('d F Y') }}</div>
                <div class="jabatan">Guru Tahfidz</div>
                <div class="nama">(_______________________)</div>
            </div>
        </div>

    </div>

    {{-- Tombol Aksi --}}
    <div class="action-bar no-print">
        <a href="{{ url()->previous() }}" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨 Cetak / Simpan PDF</button>
    </div>

    <script>
        // Auto-trigger print dialog jika ada param ?autoprint=1
        if (new URLSearchParams(window.location.search).get('autoprint') === '1') {
            window.addEventListener('load', () => window.print());
        }
    </script>
</body>

</html>
