<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hafalan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 70px;
            height: 70px;
            float: left;
            margin-right: 15px;
        }

        .school-info {
            text-align: center;
        }

        .school-info h2,
        .school-info h4 {
            margin: 0;
        }

        .line {
            border-bottom: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .info-siswa {
            margin-top: 10px;
        }

        .ttd {
            margin-top: 60px;
            width: 100%;
        }

        .ttd .right {
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- Header Identitas Sekolah --}}
    <div class="header">
        <img src="{{ public_path('images/logo.webp') }}" alt="Logo Sekolah" style="width:70px; height:70px;">
        <div class="school-info">
            <h2>YAYASAN PENDIDIKAN ISLAMIYAH NGAWI</h2>
            <h2>SEKOLAH MENENGAH PERTAMA</h2>
            <h2>SMP ISLAMIYAH WIDODAREN</h2>
            <h4>Alamat: Kedungprahu, Widodaren, Ngawi, Kode Pos 63256</h4>
        </div>
        <div class="line"></div>
    </div>

    {{-- Judul --}}
    <h3 style="text-align: center;">Laporan Hafalan Al-Qur'an</h3>

    {{-- Informasi Siswa --}}
    <div class="info-siswa">
        <p><strong>Nama:</strong> {{ $siswa->user->name }}</p>
        <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
        @php
            $siswaKelasAktif = $siswa->siswaKelas->last(); // Atau gunakan first() tergantung data mana yang terbaru/terlama
        @endphp

        <p><strong>Kelas:</strong> {{ $siswaKelasAktif->kelasTahfidz->nama ?? '-' }} ({{ $siswaKelasAktif->kelasTahfidz->tingkatan_label ?? '-' }}) </p>
        <p><strong>Tahun Ajaran:</strong> {{ $siswaKelasAktif->tahunAjaran->tahun_ajaran ?? '-' }}</p>

    </div>

    {{-- Tabel Penilaian --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Surah & Ayat</th>
                <th>Nilai Tajwid</th>
                <th>Nilai Harakat</th>
                <th>Nilai Makhraj</th>
                <th>Total</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penilaian as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->assessed_at)->translatedFormat('d M Y') }}</td>
                    <td style="text-align: left">
                        @if ($item->tugasHafalan && $item->tugasHafalan->surahHafalan->count())
                            @foreach ($item->tugasHafalan->surahHafalan as $sh)
                                {{ $sh->surah->nama }}: {{ $sh->ayat_awal }}-{{ $sh->ayat_akhir }}<br>
                            @endforeach
                        @elseif ($item->surahHafalanPenilaian && $item->surahHafalanPenilaian->count())
                            @foreach ($item->surahHafalanPenilaian as $sh)
                                {{ $sh->surah->nama }}: {{ $sh->ayat_awal }}-{{ $sh->ayat_akhir }}<br>
                            @endforeach
                        @else
                            <em>-</em>
                        @endif
                    </td>
                    <td>{{ $item->nilai_tajwid }}</td>
                    <td>{{ $item->nilai_harakat }}</td>
                    <td>{{ $item->nilai_makhraj }}</td>
                    <td>{{ $item->nilai_total }}</td>
                    <td>{{ $item->predikat_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"><em>Tidak ada data penilaian</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="ttd">
        <div class="right">
            <p>Widodaren, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Guru Tahfidz</p>
            <br><br><br>
            <p style="text-decoration: underline;">______________________</p>
        </div>
    </div>

</body>

</html>
