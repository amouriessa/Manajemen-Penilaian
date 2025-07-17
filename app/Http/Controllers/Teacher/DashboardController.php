<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Pengumpulan;
use App\Models\TugasHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherId = Auth::user()->guru->id;

        // Mendapatkan semua ID kelas yang diajar oleh guru ini
        $kelasYangDiajarIds = Auth::user()->guru->kelasTahfidz->pluck('id')->toArray();

        // 1. Hitungan Total Tugas Hafalan Aktif
        $totalTugasAktif = TugasHafalan::where('teacher_id', $teacherId)
        ->where('status', 'aktif')
        ->where('is_archived', false)
        ->where(function ($query) use ($kelasYangDiajarIds, $teacherId) {
            $query->where(function ($q) use ($kelasYangDiajarIds) {
                // Tugas untuk semua siswa di kelas
                $q->where('is_for_all_student', true)
                ->whereIn('kelas_tahfidz_id', $kelasYangDiajarIds);
            })
            ->orWhere(function ($q) use ($teacherId) {
                // Tugas khusus untuk siswa tertentu
                $q->where('is_for_all_student', false)
                ->whereHas('siswa', function ($siswaQuery) use ($teacherId) {
                    $siswaQuery->whereHas('siswaKelas', function ($skQuery) use ($teacherId) {
                        $skQuery->whereHas('kelasTahfidz', function ($ktQuery) use ($teacherId) {
                            $ktQuery->where('teacher_id', $teacherId);
                        });
                    });
                })
                ->whereDoesntHave('penilaian', function ($penilaianQuery) use ($teacherId) {
                    $penilaianQuery->where('teacher_id', $teacherId)
                                    ->where('assessed_at', '!=', null); // atau whereNotNull('nilai')
                });
            });
        })
        ->count();

        // Total pengumpulan hari ini (logika sebelumnya sudah benar)
        // $totalPengumpulanHariIni = Pengumpulan::whereHas('tugasHafalan', function ($query) use ($teacherId) {
        //         $query->where('teacher_id', $teacherId);
        //     })
        //     ->whereDate('submitted_at', Carbon::today())
        //     ->count();

        $totalPengumpulanHariIni = Pengumpulan::whereDate('created_at', today())
                                                ->whereHas('tugasHafalan', function ($query) use ($teacherId) {
                                                    $query->where('teacher_id', $teacherId);
                                                })
                                                ->count();

        // $totalPenilaianTertunda = Pengumpulan::where('status', 'pending') // Atau whereNull('nilai')
        //                                           ->whereHas('tugasHafalan', function ($query) use ($teacherId) {
        //                                               $query->where('teacher_id', $teacherId);
        //                                           })
        //                                           ->count();

        $totalPenilaianTertunda = Pengumpulan::whereHas('tugasHafalan', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->whereDoesntHave('penilaian', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })
        ->count();

        $pengumpulanHariIni = Pengumpulan::with(['siswa', 'tugasHafalan']) // Eager load relasi student dan tugasHafalan
                                              ->whereDate('created_at', today())
                                              ->whereHas('tugasHafalan', function ($query) use ($teacherId) {
                                                  $query->where('teacher_id', $teacherId);
                                              })
                                              ->latest() // Urutkan berdasarkan waktu terbaru
                                              ->limit(5)   // Batasi 5 data terbaru
                                              ->get();

        // // Total penilaian tertunda (logika sebelumnya sudah benar, sesuaikan 'nilai' jika perlu)
        // $totalPenilaianTertunda = Pengumpulan::whereHas('tugasHafalan', function ($query) use ($teacherId) {
        //         $query->where('teacher_id', $teacherId);
        //     })
        //     ->whereNull('nilai') // Atau kondisi lain yang menunjukkan belum dinilai
        //     ->count();


        return view('teacher.dashboard', compact(
            'totalTugasAktif',
            // 'totalPengumpulanHariIni',
            // 'totalPenilaianTertunda'
            'totalPengumpulanHariIni',
            'totalPenilaianTertunda',
            'pengumpulanHariIni'
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
