<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\Penilaian;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\Surah;
use App\Models\SurahHafalan;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $kelasId = $request->kelas_id;
    $studentId = $request->student_id;
    $periode = $request->periode;
    $tahunAjaranId = $request->tahun_ajaran_id;
    $surahId = $request->surah_id;

    $selectedSurah = null;
    $selectedStudent = null;

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

    // Base query
    $query = Penilaian::with(['siswa.user', 'surahHafalanPenilaian.surah', 'tugasHafalan.surahHafalan.surah'])
        ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);

    // Filter surah jika dipilih
    if ($surahId) {
        $selectedSurah = Surah::find($surahId);

        $query->where(function ($q) use ($surahId) {
            $q->whereHas('surahHafalanPenilaian.surah', function ($q2) use ($surahId) {
                $q2->where('id', $surahId);
            })->orWhereHas('tugasHafalan.surahHafalan.surah', function ($q3) use ($surahId) {
                $q3->where('id', $surahId);
            });
        });
    }

    // Filter siswa jika dipilih
    if ($studentId) {
        $selectedStudent = Student::with('user')->find($studentId);
        $query->where('student_id', $studentId);
    }

    // Filter kelas: ambil student_id yang ada di kelas
    if ($kelasId) {
        $studentIdsInKelas = SiswaKelas::where('kelas_tahfidz_id', $kelasId)->pluck('student_id');

        // Jika tidak pilih siswa tertentu, maka filter penilaian dengan student dari kelas
        if (!$studentId) {
            $query->whereIn('student_id', $studentIdsInKelas);
        }
    }

    $penilaian = $query->get();
    $surahs = Surah::orderBy('nama')->get();
    $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();
    $tahunAjaranAktifId = $tahunAjaranAktif?->id;

    return view('teacher.laporankelas.index', [
        'kelasList' => KelasTahfidz::all(),
        'tahunAjaranList' => TahunAjaran::all(),
        'studentList' => Student::with('user')->get(),
        'penilaian' => $penilaian,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
        'selectedStudent' => $selectedStudent,
        'selectedSurah' => $selectedSurah,
        'surahs' => $surahs,
        'selectedSurahId' => $surahId,
        'tahunAjaranAktifId' => $tahunAjaranAktifId,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
