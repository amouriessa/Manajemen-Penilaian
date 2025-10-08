<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\Penilaian;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\Surah;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     // Ambil data filter
    //     $kelasId = $request->kelas_id;
    //     $studentId = $request->student_id;
    //     $periode = $request->periode; // 'tanggal', 'bulan', 'semester', atau 'custom'
    //     $tahunAjaranId = $request->tahun_ajaran_id;
    //     $selectedStudent = null;

    //     if ($studentId) {
    //         $selectedStudent = Student::with(['user', 'siswaKelas.kelasTahfidz'])->find($studentId);
    //         $siswaIds = [$studentId]; // tetap ambil 1 siswa untuk penilaian
    //     }

    //     // Ambil semua siswa dalam kelas dan tahun ajaran yang dipilih
    //     $siswaIds = SiswaKelas::where('kelas_tahfidz_id', $kelasId)
    //         ->where('tahun_ajaran_id', $tahunAjaranId)
    //         ->pluck('student_id');

    //     // Jika user memilih salah satu siswa (opsional)
    //     if ($studentId) {
    //         $siswaIds = [$studentId];
    //     }

    //     // Set default tanggal (seluruh data)
    //     $tanggalAwal = now()->startOfYear();
    //     $tanggalAkhir = now()->endOfYear();

    //     // Logika filter periode
    //     switch ($periode) {
    //         case 'tanggal':
    //             $tanggalAwal = $request->dari_tanggal;
    //             $tanggalAkhir = $request->sampai_tanggal;
    //             break;

    //         case 'bulan':
    //             $bulan = $request->bulan; // format: 1-12
    //             $tahun = $request->tahun ?? now()->year;
    //             $tanggalAwal = \Carbon\Carbon::create($tahun, $bulan, 1)->startOfMonth();
    //             $tanggalAkhir = \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth();
    //             break;

    //         case 'semester':
    //             $semester = $request->semester; // 'ganjil' atau 'genap'
    //             $tahun = $request->tahun ?? now()->year;

    //             if ($semester == 'ganjil') {
    //                 $tanggalAwal = \Carbon\Carbon::create($tahun, 7, 1); // Juli
    //                 $tanggalAkhir = \Carbon\Carbon::create($tahun, 12, 31); // Desember
    //             } else {
    //                 $tanggalAwal = \Carbon\Carbon::create($tahun + 1, 1, 1); // Januari
    //                 $tanggalAkhir = \Carbon\Carbon::create($tahun + 1, 6, 30); // Juni
    //             }
    //             break;

    //         case 'custom':
    //             $tanggalAwal = $request->custom_dari;
    //             $tanggalAkhir = $request->custom_sampai;
    //             break;
    //     }

    //     // Ambil data penilaian sesuai filter
    //     // $penilaian = Penilaian::whereIn('student_id', $siswaIds)
    //     //     ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
    //     //     ->with(['siswa', 'surahHafalanPenilaian.surah', 'tugasHafalan.surahHafalan.surah']) // relasi yang ingin dimuat
    //     //     ->get();

    //     // if ($request->filled('surah_nama')) {
    //     //     $surahNama = $request->input('surah_nama');

    //     //     $penilaian->whereHas('surahHafalanPenilaian.surah', function ($q) use ($surahNama) {
    //     //         $q->where('nama', 'like', '%' . $surahNama . '%');
    //     //     })->orWhereHas('tugasHafalan.surahHafalan.surah', function ($q) use ($surahNama) {
    //     //         $q->where('nama', 'like', '%' . $surahNama . '%');
    //     //     });
    //     // }

    //     $query = Penilaian::whereIn('student_id', $siswaIds)
    //         ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
    //         ->with(['siswa', 'surahHafalanPenilaian.surah', 'tugasHafalan.surahHafalan.surah']);

    //     if ($request->filled('surah_nama')) {
    //         $surahNama = $request->input('surah_nama');

    //         $query->where(function ($q) use ($surahNama) {
    //             $q->whereHas('surahHafalanPenilaian.surah', function ($q2) use ($surahNama) {
    //                 $q2->where('nama', 'like', '%' . $surahNama . '%');
    //             })->orWhereHas('tugasHafalan.surahHafalan.surah', function ($q3) use ($surahNama) {
    //                 $q3->where('nama', 'like', '%' . $surahNama . '%');
    //             });
    //         });
    //     }

    //     $penilaian = $query->get();
    //     $surahs = Surah::orderBy('nama')->get();

    //     return view('teacher.laporan.index', [
    //         'kelasList' => KelasTahfidz::all(),
    //         'tahunAjaranList' => TahunAjaran::all(),
    //         'studentList' => Student::with('user')->get(),
    //         'penilaian' => $penilaian,
    //         'tanggalAwal' => $tanggalAwal,
    //         'tanggalAkhir' => $tanggalAkhir,
    //         'selectedStudent' => $selectedStudent,
    //         'surahs' => $surahs,
    //     ]);
    // }

    // public function cetak(Request $request)
    // {
    //     $studentId = $request->student_id;
    //     $periode = $request->periode;
    //     $tanggalAwal = now()->startOfYear();
    //     $tanggalAkhir = now()->endOfYear();

    //     switch ($periode) {
    //         case 'tanggal':
    //             $tanggalAwal = $request->dari_tanggal;
    //             $tanggalAkhir = $request->sampai_tanggal;
    //             break;

    //         case 'bulan':
    //             $bulan = $request->bulan;
    //             $tahun = $request->tahun ?? now()->year;
    //             $tanggalAwal = \Carbon\Carbon::create($tahun, $bulan, 1)->startOfMonth();
    //             $tanggalAkhir = \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth();
    //             break;

    //         case 'semester':
    //             $semester = $request->semester;
    //             $tahun = $request->tahun ?? now()->year;

    //             if ($semester == 'ganjil') {
    //                 $tanggalAwal = \Carbon\Carbon::create($tahun, 7, 1);
    //                 $tanggalAkhir = \Carbon\Carbon::create($tahun, 12, 31);
    //             } else {
    //                 $tanggalAwal = \Carbon\Carbon::create($tahun + 1, 1, 1);
    //                 $tanggalAkhir = \Carbon\Carbon::create($tahun + 1, 6, 30);
    //             }
    //             break;

    //         case 'custom':
    //             $tanggalAwal = $request->custom_dari;
    //             $tanggalAkhir = $request->custom_sampai;
    //             break;
    //     }

    //     $siswa = Student::with([
    //         'user',
    //         'siswaKelas.kelasTahfidz',
    //         'siswaKelas.tahunAjaran'
    //     ])->findOrFail($studentId);

    //     $penilaian = Penilaian::with([
    //         'guru.user',
    //         'surahHafalanPenilaian.surah',
    //         'tugasHafalan.surahHafalan.surah'
    //     ])
    //         ->where('student_id', $studentId)
    //         ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('teacher.laporan.cetak', compact('siswa', 'penilaian', 'tanggalAwal', 'tanggalAkhir'));
    //     return $pdf->stream('laporan_penilaian_' . $siswa->user->name . '.pdf');
    // }

    public function index(Request $request)
{
    $kelasId = $request->kelas_id;
    $studentId = $request->student_id;
    $periode = $request->periode;
    $tahunAjaranId = $request->tahun_ajaran_id;
    $surahId = $request->surah_id;

    $selectedStudent = null;

    $siswaQuery = SiswaKelas::query();

    if ($kelasId) {
        $siswaQuery->where('kelas_tahfidz_id', $kelasId);
    }
    if ($tahunAjaranId) {
        $siswaQuery->where('tahun_ajaran_id', $tahunAjaranId);
    }

    $siswaIds = $siswaQuery->pluck('student_id');

    // Jika memilih siswa spesifik
    if ($studentId) {
        $selectedStudent = Student::with(['user', 'siswaKelas.kelasTahfidz'])->find($studentId);
        $siswaIds = [$studentId];
    }

    // Jika memilih kelas dan surah TANPA memilih siswa
    if ($kelasId && $surahId && !$studentId) {
        // Ambil semua student_id di kelas yg punya penilaian surah tersebut
        $studentIdsWithPenilaian = Penilaian::whereIn('student_id', $siswaIds)
            ->where(function ($q) use ($surahId) {
                $q->whereHas('surahHafalanPenilaian.surah', function ($q2) use ($surahId) {
                    $q2->where('id', $surahId);
                })->orWhereHas('tugasHafalan.surahHafalan.surah', function ($q3) use ($surahId) {
                    $q3->where('id', $surahId);
                });
            })
            ->pluck('student_id')
            ->unique();

        $siswaIds = $studentIdsWithPenilaian;
    }

    // Tanggal default
    $tanggalAwal = Carbon::now()->startOfYear();
    $tanggalAkhir = Carbon::now()->endOfYear();

    switch ($periode) {
        case 'tanggal':
            $tanggalAwal = $request->dari_tanggal;
            $tanggalAkhir = $request->sampai_tanggal;
            break;
        case 'bulan':
            $bulan = $request->bulan;
            $tahun = $request->tahun ?? Carbon::now()->year;
            $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();
            break;
        case 'semester':
            $semester = $request->semester;
            $tahun = $request->tahun ?? Carbon::now()->year;
            if ($semester == 'ganjil') {
                $tanggalAwal = Carbon::create($tahun, 7, 1);
                $tanggalAkhir = Carbon::create($tahun, 12, 31);
            } else {
                $tanggalAwal = Carbon::create($tahun + 1, 1, 1);
                $tanggalAkhir = Carbon::create($tahun + 1, 6, 30);
            }
            break;
        case 'custom':
            $tanggalAwal = $request->custom_dari;
            $tanggalAkhir = $request->custom_sampai;
            break;
    }

    // Ambil penilaian sesuai semua filter
    $query = Penilaian::whereIn('student_id', $siswaIds)
        ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
        ->with(['siswa', 'surahHafalanPenilaian.surah', 'tugasHafalan.surahHafalan.surah']);

    if ($surahId) {
        $query->where(function ($q) use ($surahId) {
            $q->whereHas('surahHafalanPenilaian.surah', function ($q2) use ($surahId) {
                $q2->where('id', $surahId);
            })->orWhereHas('tugasHafalan.surahHafalan.surah', function ($q3) use ($surahId) {
                $q3->where('id', $surahId);
            });
        });
    }

    $penilaian = $query->get();
    $surahs = Surah::orderBy('nama')->get();

    return view('teacher.laporan.index', [
        'kelasList' => KelasTahfidz::all(),
        'tahunAjaranList' => TahunAjaran::all(),
        'studentList' => Student::with('user')->get(),
        'penilaian' => $penilaian,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
        'selectedStudent' => $selectedStudent,
        'surahs' => $surahs,
        'selectedSurahId' => $surahId,
    ]);
}    

    public function cetak(Request $request)
    {
        // Logika cetak juga perlu diperbarui untuk menyertakan filter surah
        // Namun, dari deskripsi, laporan cetak masih per siswa, jadi tidak perlu menambahkan filter surah di sini
        // Jika di masa depan laporan cetak juga bisa per surah, maka logika di sini perlu disesuaikan.
        $studentId = $request->student_id;
        $periode = $request->periode;
        $tanggalAwal = Carbon::now()->startOfYear();
        $tanggalAkhir = Carbon::now()->endOfYear();

        switch ($periode) {
            case 'tanggal':
                $tanggalAwal = $request->dari_tanggal;
                $tanggalAkhir = $request->sampai_tanggal;
                break;

            case 'bulan':
                $bulan = $request->bulan;
                $tahun = $request->tahun ?? Carbon::now()->year;
                $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();
                break;

            case 'semester':
                $semester = $request->semester;
                $tahun = $request->tahun ?? Carbon::now()->year;

                if ($semester == 'ganjil') {
                    $tanggalAwal = Carbon::create($tahun, 7, 1);
                    $tanggalAkhir = Carbon::create($tahun, 12, 31);
                } else {
                    $tanggalAwal = Carbon::create($tahun + 1, 1, 1);
                    $tanggalAkhir = Carbon::create($tahun + 1, 6, 30);
                }
                break;

            case 'custom':
                $tanggalAwal = $request->custom_dari;
                $tanggalAkhir = $request->custom_sampai;
                break;
        }

        $siswa = Student::with([
            'user',
            'siswaKelas.kelasTahfidz',
            'siswaKelas.tahunAjaran'
        ])->findOrFail($studentId);

        $penilaian = Penilaian::with([
            'guru.user',
            'surahHafalanPenilaian.surah',
            'tugasHafalan.surahHafalan.surah'
        ])
            ->where('student_id', $studentId)
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('teacher.laporan.cetak', compact('siswa', 'penilaian', 'tanggalAwal', 'tanggalAkhir'));
        return $pdf->stream('laporan_penilaian_' . $siswa->user->name . '.pdf');
    }



}
