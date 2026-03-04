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

        // Populate siswa jika kelas sudah dipilih (untuk saat page reload)
        if ($request->filled('kelas_tahfidz_id')) {
            $studentList = Student::with('user')
    ->whereHas('riwayatKelas', function ($q) use ($request) {
        $q->where('kelas_tahfidz_id', $request->kelas_tahfidz_id);
    })
    ->whereHas('user')
    ->get()
    ->sortBy('user.name');
        }

        // ==============================================================
        // Validasi — hanya jalankan jika form benar-benar di-submit
        // (ditandai dengan adanya salah satu parameter filter)
        // ==============================================================
        $selectedStudent = null;
        $penilaian = collect();

        $isSubmitted = $request->hasAny(['kelas_tahfidz_id', 'student_id', 'periode', 'tahun_ajaran_id']);

        if ($isSubmitted) {
            $errors = [];

            if (! $request->filled('kelas_tahfidz_id'))        $errors[] = 'Kelas wajib dipilih.';
            if (! $request->filled('tahun_ajaran_id')) $errors[] = 'Tahun ajaran wajib dipilih.';
            if (! $request->filled('student_id'))      $errors[] = 'Siswa wajib dipilih.';
            if (! $request->filled('periode'))         $errors[] = 'Filter periode wajib dipilih.';

            // Validasi input spesifik periode
            if ($request->periode === 'tanggal') {
                if (! $request->filled('dari_tanggal'))   $errors[] = 'Dari tanggal wajib diisi.';
                if (! $request->filled('sampai_tanggal')) $errors[] = 'Sampai tanggal wajib diisi.';
            } elseif ($request->periode === 'bulan') {
                if (! $request->filled('bulan')) $errors[] = 'Bulan wajib dipilih.';
                if (! $request->filled('tahun')) $errors[] = 'Tahun wajib diisi.';
            }

            if (! empty($errors)) {
                return back()
                    ->withInput()
                    ->withErrors($errors);
            }

            // ==============================================================
            // Ambil data siswa yang dipilih
            // ==============================================================
            $selectedStudent = Student::with(['user', 'kelastahfidz'])
                ->findOrFail($request->student_id);

            // ==============================================================
            // Query penilaian dengan eager loading semua relasi yang dibutuhkan
            // ==============================================================
            $query = Penilaian::with([
                    // Untuk penilaian langsung: surah-surah hafalannya
                    'surahHafalanPenilaian.surah',
                    // Untuk penilaian pengumpulan: tugas → surah hafalan tugas
                    'tugasHafalan.surahHafalan.surah',
                ])
                ->where('student_id', $request->student_id)
                ->orderBy('assessed_at', 'desc');

            // ==============================================================
            // Filter Periode
            // ==============================================================
            if ($request->periode === 'tanggal') {
                $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
                $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();
                $query->whereBetween('assessed_at', [$dari, $sampai]);

            } elseif ($request->periode === 'bulan') {
                $query->whereMonth('assessed_at', $request->bulan)
                      ->whereYear('assessed_at', $request->tahun);
            }

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

    /**
     * AJAX endpoint — kembalikan daftar siswa berdasarkan kelas_tahfidz_id.
     * Route: GET /teacher/laporan/siswa-by-kelas?kelas_tahfidz_id=X
     */
    public function siswaByKelas(Request $request)
{
    abort_if(! $request->filled('kelas_tahfidz_id'), 400, 'kelas_tahfidz_id diperlukan');

    // Cari siswa yang terdaftar di kelas tersebut lewat tabel pivot siswa_kelas
    // Filter juga berdasarkan tahun ajaran aktif (opsional tapi direkomendasikan)
    $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

    $siswa = Student::with('user')
        ->whereHas('riwayatKelas', function ($q) use ($request, $tahunAjaranAktif) {
            $q->where('kelas_tahfidz_id', $request->kelas_tahfidz_id);

            // Kalau mau dibatasi tahun ajaran aktif, uncomment baris ini:
            // if ($tahunAjaranAktif) {
            //     $q->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            // }
        })
        ->whereHas('user') // pastikan data user tidak null
        ->get()
        ->sortBy('user.name')
        ->map(fn($s) => [
            'id'   => $s->id,
            'name' => $s->user->name,
        ])
        ->values();

    return response()->json($siswa);
}

    /**
     * Halaman cetak / PDF — gunakan view terpisah yang print-friendly.
     */
    public function cetak(Request $request)
    {
        // Validasi minimal
        abort_if(! $request->filled('student_id'), 400, 'student_id diperlukan');

        // $selectedStudent = Student::with(['user', 'kelastahfidz'])->findOrFail($request->student_id);
        $selectedStudent = Student::with(['user', 'riwayatKelas.kelasTahfidz'])->findOrFail($request->student_id);

        $query = Penilaian::with([
                'surahHafalanPenilaian.surah',
                'tugasHafalan.surahHafalan.surah',
            ])
            ->where('student_id', $request->student_id)
            ->orderBy('assessed_at', 'asc'); // asc untuk laporan cetak

        if ($request->periode === 'tanggal') {
            $query->whereBetween('assessed_at', [
                Carbon::parse($request->dari_tanggal)->startOfDay(),
                Carbon::parse($request->sampai_tanggal)->endOfDay(),
            ]);
        } elseif ($request->periode === 'bulan') {
            $query->whereMonth('assessed_at', $request->bulan)
                  ->whereYear('assessed_at', $request->tahun);
        }

        $penilaian = $query->get();

        return view('teacher.laporan.cetak', compact('selectedStudent', 'penilaian'));
    }
}
