<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\Penilaian;
use App\Models\Student;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ==============================================================
        // Data untuk dropdown filter
        // ==============================================================
        $kelasList = KelasTahfidz::orderBy('tingkatan_kelas')->orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun_ajaran')->get();
        $studentList = collect();

        if ($request->filled('kelas_tahfidz_id')) {
            $studentList = Student::with('user')
                ->whereHas('riwayatKelas', function ($q) use ($request) {
                    $q->where('kelas_tahfidz_id', $request->kelas_tahfidz_id);
                })
                ->whereHas('user')
                ->get()
                ->sortBy('user.name');
        }

        $selectedStudent = null;
        $penilaian = collect();

        $isSubmitted = $request->hasAny(['kelas_tahfidz_id', 'student_id', 'periode', 'tahun_ajaran_id']);

        if ($isSubmitted) {

            // ==============================================================
            // VALIDASI (Laravel way)
            // ==============================================================
            $request->validate([
                'kelas_tahfidz_id' => 'required',
                'tahun_ajaran_id'  => 'required',
                'student_id'       => 'required',
                'periode'          => 'required|in:tanggal,bulan',

                'dari_tanggal'   => 'nullable|required_if:periode,tanggal|date',
                'sampai_tanggal' => 'nullable|required_if:periode,tanggal|date',

                'bulan'            => 'required_if:periode,bulan',
                'tahun'            => 'required_if:periode,bulan|integer',
            ]);

            // ==============================================================
            // Ambil data siswa
            // ==============================================================
            $selectedStudent = Student::with(['user', 'kelastahfidz'])
                ->findOrFail($request->student_id);

            // ==============================================================
            // Query utama
            // ==============================================================
            $query = Penilaian::with([
                    'surahHafalanPenilaian.surah',
                    'tugasHafalan.surahHafalan.surah',
                ])
                ->where('student_id', $request->student_id)
                ->orderBy('assessed_at', 'desc');

            // ==============================================================
            // APPLY FILTER PERIODE (FIXED)
            // ==============================================================
            $query = $this->applyPeriodeFilter($query, $request);

            $penilaian = $query->get();
        }

        return view('teacher.laporan.index', compact(
            'kelasList',
            'tahunAjaranList',
            'studentList',
            'selectedStudent',
            'penilaian'
        ));
    }

    public function siswaByKelas(Request $request)
    {
        abort_if(! $request->filled('kelas_tahfidz_id'), 400, 'kelas_tahfidz_id diperlukan');

        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        $siswa = Student::with('user')
            ->whereHas('riwayatKelas', function ($q) use ($request, $tahunAjaranAktif) {
                $q->where('kelas_tahfidz_id', $request->kelas_tahfidz_id);

                // optional filter tahun ajaran
                // if ($tahunAjaranAktif) {
                //     $q->where('tahun_ajaran_id', $tahunAjaranAktif->id);
                // }
            })
            ->whereHas('user')
            ->get()
            ->sortBy('user.name')
            ->map(fn($s) => [
                'id'   => $s->id,
                'name' => $s->user->name,
            ])
            ->values();

        return response()->json($siswa);
    }

    public function cetak(Request $request)
    {
        abort_if(! $request->filled('student_id'), 400, 'student_id diperlukan');

        $request->validate([
            'periode'        => 'required|in:tanggal,bulan',
            'dari_tanggal'   => 'nullable|required_if:periode,tanggal|date',
            'sampai_tanggal' => 'nullable|required_if:periode,tanggal|date',
            'bulan'          => 'required_if:periode,bulan',
            'tahun'          => 'required_if:periode,bulan|integer',
        ]);

        $selectedStudent = Student::with(['user', 'riwayatKelas.kelasTahfidz'])
            ->findOrFail($request->student_id);

        $query = Penilaian::with([
                'surahHafalanPenilaian.surah',
                'tugasHafalan.surahHafalan.surah',
            ])
            ->where('student_id', $request->student_id)
            ->orderBy('assessed_at', 'asc');

        // pakai helper yang sama
        $query = $this->applyPeriodeFilter($query, $request);

        $penilaian = $query->get();

        return view('teacher.laporan.cetak', compact('selectedStudent', 'penilaian'));
    }

    /**
     * Helper filter periode (biar gak duplicate + fix bug bulan)
     */
    private function applyPeriodeFilter($query, Request $request)
    {
        // if ($request->periode === 'tanggal') {
        //     return $query->whereBetween('assessed_at', [
        //         Carbon::parse($request->dari_tanggal)->startOfDay(),
        //         Carbon::parse($request->sampai_tanggal)->endOfDay(),
        //     ]);
        // }
        if ($request->periode === 'tanggal') {
            $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
            $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();

            return $query->where(function ($q) use ($dari, $sampai) {
                $q->where(function ($q2) use ($dari, $sampai) {
                    $q2->where('jenis_penilaian', 'langsung')
                    ->whereBetween('assessed_at', [$dari, $sampai]);
                })
                ->orWhere(function ($q2) use ($dari, $sampai) {
                    $q2->where('jenis_penilaian', 'pengumpulan')
                    ->whereBetween('created_at', [$dari, $sampai]);
                });
            });
        }

        if ($request->periode === 'bulan') {
            // FIX: handle string "April" → 4
            $bulan = is_numeric($request->bulan)
                ? (int) $request->bulan
                : Carbon::parse($request->bulan)->month;

            return $query->whereMonth('assessed_at', $bulan)
                         ->whereYear('assessed_at', (int) $request->tahun);
        }

        return $query;
    }
}
