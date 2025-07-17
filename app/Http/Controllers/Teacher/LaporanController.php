<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\Penilaian;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $kelasId = $request->kelas_id;
    //     $studentId = $request->student_id;

    //     $kelas = KelasTahfidz::all();
    //     $siswa = Student::with('user')->get();

    //     // if ($kelasId) {
    //     //     $siswa = Student::whereHas('siswaKelas', function ($query) use ($kelasId) {
    //     //         $query->where('kelas_tahfidz_id', $kelasId);
    //     //     })->with('user')->get();
    //     // } else {
    //     //     $siswa = Student::with('user')->get();
    //     // }side

    //     $penilaianQuery = Penilaian::with([
    //         'siswa.user',
    //         'guru.user',
    //         'surahHafalanPenilaian.surah', // Untuk penilaian 'langsung'
    //         'tugasHafalan.surahHafalan.surah' // Untuk penilaian 'pengumpulan' via tugas_hafalan
    //     ])->latest();

    //     // Filter berdasarkan kelas
    //     if ($kelasId) {
    //         $penilaianQuery->whereHas('siswa.siswaKelas', function ($query) use ($kelasId) {
    //             $query->where('kelas_tahfidz_id', $kelasId);
    //         });
    //     }

    //     // Filter berdasarkan siswa
    //     if ($studentId) {
    //         $penilaianQuery->where('student_id', $studentId);
    //     }

    //     $penilaian = $penilaianQuery->get();

    //     $selectedStudent = $studentId ? Student::with('user')->find($studentId) : null;

    //     return view('teacher.laporan.index', compact('kelas', 'siswa', 'penilaian', 'selectedStudent'));
    // }

    public function index(Request $request)
    {
        // Ambil data filter
        $kelasId = $request->kelas_id;
        $studentId = $request->student_id;
        $periode = $request->periode; // 'tanggal', 'bulan', 'semester', atau 'custom'
        $tahunAjaranId = $request->tahun_ajaran_id;
        $selectedStudent = null;

        if ($studentId) {
            $selectedStudent = Student::with(['user', 'siswaKelas.kelasTahfidz'])->find($studentId);
            $siswaIds = [$studentId]; // tetap ambil 1 siswa untuk penilaian
        }

        // Ambil semua siswa dalam kelas dan tahun ajaran yang dipilih
        $siswaIds = SiswaKelas::where('kelas_tahfidz_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->pluck('student_id');

        // Jika user memilih salah satu siswa (opsional)
        if ($studentId) {
            $siswaIds = [$studentId];
        }

        // Set default tanggal (seluruh data)
        $tanggalAwal = now()->startOfYear();
        $tanggalAkhir = now()->endOfYear();

        // Logika filter periode
        switch ($periode) {
            case 'tanggal':
                $tanggalAwal = $request->dari_tanggal;
                $tanggalAkhir = $request->sampai_tanggal;
                break;

            case 'bulan':
                $bulan = $request->bulan; // format: 1-12
                $tahun = $request->tahun ?? now()->year;
                $tanggalAwal = \Carbon\Carbon::create($tahun, $bulan, 1)->startOfMonth();
                $tanggalAkhir = \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth();
                break;

            case 'semester':
                $semester = $request->semester; // 'ganjil' atau 'genap'
                $tahun = $request->tahun ?? now()->year;

                if ($semester == 'ganjil') {
                    $tanggalAwal = \Carbon\Carbon::create($tahun, 7, 1); // Juli
                    $tanggalAkhir = \Carbon\Carbon::create($tahun, 12, 31); // Desember
                } else {
                    $tanggalAwal = \Carbon\Carbon::create($tahun + 1, 1, 1); // Januari
                    $tanggalAkhir = \Carbon\Carbon::create($tahun + 1, 6, 30); // Juni
                }
                break;

            case 'custom':
                $tanggalAwal = $request->custom_dari;
                $tanggalAkhir = $request->custom_sampai;
                break;
        }

        // Ambil data penilaian sesuai filter
        $penilaian = Penilaian::whereIn('student_id', $siswaIds)
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->with(['siswa', 'surahHafalanPenilaian.surah', 'tugasHafalan.surahHafalan.surah']) // relasi yang ingin dimuat
            ->get();

        return view('teacher.laporan.index', [
            'kelasList' => KelasTahfidz::all(),
            'tahunAjaranList' => TahunAjaran::all(),
            'studentList' => Student::with('user')->get(),
            'penilaian' => $penilaian,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'selectedStudent' => $selectedStudent,
        ]);
    }

    public function cetak(Request $request)
    {
        $studentId = $request->student_id;
        $periode = $request->periode;
        $tanggalAwal = now()->startOfYear();
        $tanggalAkhir = now()->endOfYear();

        switch ($periode) {
            case 'tanggal':
                $tanggalAwal = $request->dari_tanggal;
                $tanggalAkhir = $request->sampai_tanggal;
                break;

            case 'bulan':
                $bulan = $request->bulan;
                $tahun = $request->tahun ?? now()->year;
                $tanggalAwal = \Carbon\Carbon::create($tahun, $bulan, 1)->startOfMonth();
                $tanggalAkhir = \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth();
                break;

            case 'semester':
                $semester = $request->semester;
                $tahun = $request->tahun ?? now()->year;

                if ($semester == 'ganjil') {
                    $tanggalAwal = \Carbon\Carbon::create($tahun, 7, 1);
                    $tanggalAkhir = \Carbon\Carbon::create($tahun, 12, 31);
                } else {
                    $tanggalAwal = \Carbon\Carbon::create($tahun + 1, 1, 1);
                    $tanggalAkhir = \Carbon\Carbon::create($tahun + 1, 6, 30);
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

    // public function cetak(Request $request)
    // {
    //     $studentId = $request->student_id;

    //     $siswa = Student::with([
    //         'user',
    //         'siswaKelas.kelasTahfidz',
    //         'siswaKelas.tahunAjaran'
    //     ])->findOrFail($studentId);

    //     $penilaian = Penilaian::with([
    //         'guru.user',
    //         'surahHafalanPenilaian.surah', // Untuk penilaian 'langsung'
    //         'tugasHafalan.surahHafalan.surah' // Untuk penilaian 'pengumpulan' via tugas_hafalan
    //     ])
    //         ->where('student_id', $studentId)
    //         ->orderBy('assessed_at', 'desc')
    //         ->get();

    //     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('teacher.laporan.cetak', compact('siswa', 'penilaian'));
    //     return $pdf->stream('laporan_penilaian_' . $siswa->user->name . '.pdf');
    // }

    // public function byClass(Request $request)
    // {
    //     $kelasId = $request->get('kelas_id');
    //     $search = $request->get('search');
    //     $selectedId = $request->get('selected_id');

    //     if ($selectedId) {
    //         $student = Student::with('user')->find($selectedId);
    //         if ($student) {
    //             return response()->json([
    //                 'id' => $student->id,
    //                 'name' => $student->user->name,
    //             ]);
    //         }
    //         return response()->json([]);
    //     }

    //     if (!$kelasId) {
    //         return response()->json([]);
    //     }

    //     $query = Student::whereHas('siswaKelas', function ($q) use ($kelasId) {
    //         $q->where('kelas_tahfidz_id', $kelasId);
    //     })->with('user');

    //     if ($search) {
    //         $query->whereHas('user', function ($q) use ($search) {
    //             $q->where('name', 'like', '%' . $search . '%');
    //         });
    //     }

    //     $students = $query->limit(20)->get()->map(function ($student) {
    //         return [
    //             'id' => $student->id,
    //             'name' => $student->user->name,
    //         ];
    //     });

    //     return response()->json($students);
    // }

    // public function siswaByKelas(Request $request)
    // {
    //     $kelasId = $request->kelas_id;

    //     $siswa = Student::with('user')
    //         ->whereHas('siswaKelas', fn($q) => $q->where('kelas_tahfidz_id', $kelasId))
    //         ->get();

    //     return response()->json($siswa->map(fn($s) => [
    //         'value' => $s->id,
    //         'text' => $s->user->name,
    //     ]));
    // }

}
