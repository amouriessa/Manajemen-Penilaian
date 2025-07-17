<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\Penilaian;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total guru, siswa, kelas, tahun ajaran aktif
        $guruTotal = User::role('teacher')->count();
        $siswaTotal = User::role('student')->count();
        $kelasTotal = KelasTahfidz::count();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Statistik: Surah paling sering dinilai
        $surahStatistik = Penilaian::join('tugas_hafalans', 'penilaians.tugas_hafalan_id', '=', 'tugas_hafalans.id')
            ->join('surah_hafalans', 'tugas_hafalans.id', '=', 'surah_hafalans.tugas_hafalan_id')
            ->join('surahs', 'surah_hafalans.surah_id', '=', 'surahs.id')
            ->select('surahs.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('surahs.nama')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Grafik contoh dummy: total nilai hafalan per kelas (opsional)
        $grafikHafalan = DB::table('penilaians')
            ->join('students', 'penilaians.student_id', '=', 'students.id')
            ->join('siswa_kelas', 'students.id', '=', 'siswa_kelas.student_id')
            ->join('kelas_tahfidzs', 'siswa_kelas.kelas_tahfidz_id', '=', 'kelas_tahfidzs.id')
            ->select('kelas_tahfidzs.nama', DB::raw('AVG(penilaians.nilai_total) as rata_rata'))
            ->groupBy('kelas_tahfidzs.nama')
            ->orderBy('kelas_tahfidzs.nama')
            ->get()
            ->map(function ($row) {
                $row->rata_rata = (float) $row->rata_rata;
                return $row;
            });

        return view('admin.dashboard', compact(
            'guruTotal',
            'siswaTotal',
            'kelasTotal',
            'tahunAjaranAktif',
            'surahStatistik',
            'grafikHafalan'
        ));
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
