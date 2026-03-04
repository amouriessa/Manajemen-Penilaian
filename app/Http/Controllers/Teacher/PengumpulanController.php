<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Pengumpulan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengumpulanController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::user()->guru->id;

        $query = Pengumpulan::with(['surahHafalan.surah', 'siswa.user', 'penilaian'])
            ->whereHas('tugasHafalan', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            });

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('surahHafalan.surah', function ($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%");
                })

                ->orWhereHas('siswa.user', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('filter')) {

            switch ($request->filter) {

                case 'status:dinilai':
                    $query->whereHas('penilaian');
                    break;

                case 'status:belum_dinilai':
                    $query->whereDoesntHave('penilaian');
                    break;

                case 'sort:oldest':
                    $query->orderBy('submitted_at', 'asc');
                    break;

                case 'sort:newest':
                default:
                    $query->orderBy('submitted_at', 'desc');
                    break;
            }

        } else {

            $query->orderBy('submitted_at', 'desc');

        }

        if ($request->filter === 'sort:oldest') {
            $query->orderBy('submitted_at', 'asc');
        } else {
            $query->orderBy('submitted_at', 'desc');
        }

        $perPage = $request->get('perPage', 10);

        $pengumpulans = $query->paginate($perPage)->withQueryString();

        $totalBelumDinilai = Pengumpulan::whereHas('tugasHafalan', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->whereDoesntHave('penilaian')->count();

        return view('teacher.pengumpulan.index', compact('pengumpulans', 'totalBelumDinilai'));
    }

    public function create(Pengumpulan $pengumpulan)
    {
        if ($pengumpulan->penilaian()->exists()) {
            return redirect()
                ->route('teacher.pengumpulan.show', $pengumpulan)
                ->with('info', 'Pengumpulan ini sudah memiliki penilaian.');
        }

        $pengumpulan->load('surahHafalan.surah', 'tugasHafalan', 'siswa.user');

        if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
            abort(403);
        }

        return view('teacher.penilaian.pengumpulan.create', compact('pengumpulan'));
    }

    public function storePenilaian(Request $request, Pengumpulan $pengumpulan)
    {
        $request->validate([
            'nilai_tajwid'  => 'required|numeric|min:0|max:100',
            'nilai_harakat' => 'required|numeric|min:0|max:100',
            'nilai_makhraj' => 'required|numeric|min:0|max:100',
            'catatan'       => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {

            $guru = Auth::user()->guru;

            if (!$guru) {
                throw new \Exception('Data guru tidak ditemukan.');
            }

            if ($pengumpulan->penilaian()->exists()) {
                throw new \Exception('Pengumpulan sudah dinilai.');
            }

            if ($guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
                throw new \Exception('Anda tidak memiliki akses.');
            }

            $nilaiTotal = round(
                ($request->nilai_tajwid +
                 $request->nilai_harakat +
                 $request->nilai_makhraj) / 3
            );

            $predikat = match (true) {
                $nilaiTotal >= 90 => 'mumtaz',
                $nilaiTotal >= 80 => 'jayyid_jiddan',
                default => 'jiddan'
            };

            Penilaian::create([
                'pengumpulan_id'   => $pengumpulan->id,
                'student_id'       => $pengumpulan->student_id,
                'tugas_hafalan_id' => $pengumpulan->tugas_hafalan_id,
                'teacher_id'       => $guru->id,
                'jenis_penilaian'  => 'pengumpulan',
                'jenis_hafalan'    => $pengumpulan->tugasHafalan->jenis_tugas,
                'nilai_tajwid'     => $request->nilai_tajwid,
                'nilai_harakat'    => $request->nilai_harakat,
                'nilai_makhraj'    => $request->nilai_makhraj,
                'nilai_total'      => $nilaiTotal,
                'predikat'         => $predikat,
                'catatan'          => $request->catatan,
                'assessed_at'      => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('teacher.pengumpulan.index')
                ->with('success', 'Penilaian berhasil disimpan.');

        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan penilaian.');
        }
    }

    public function show(Pengumpulan $pengumpulan)
    {
        $pengumpulan->load('tugasHafalan', 'siswa.user', 'penilaian');

        if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
            abort(403);
        }

        return view('teacher.pengumpulan.show', compact('pengumpulan'));
    }

    public function edit(Pengumpulan $pengumpulan)
    {
        $penilaian = $pengumpulan->penilaian;

        if (!$penilaian) {
            return back()->with('error', 'Penilaian belum tersedia.');
        }

        if (Auth::user()->guru->id !== $penilaian->teacher_id) {
            abort(403);
        }

        return view('teacher.penilaian.pengumpulan.edit', compact('pengumpulan', 'penilaian'));
    }

    public function updatePenilaian(Request $request, Pengumpulan $pengumpulan)
    {
        $request->validate([
            'nilai_tajwid'  => 'required|numeric|min:0|max:100',
            'nilai_harakat' => 'required|numeric|min:0|max:100',
            'nilai_makhraj' => 'required|numeric|min:0|max:100',
            'catatan'       => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {

            $penilaian = $pengumpulan->penilaian;

            if (!$penilaian) {
                throw new \Exception('Penilaian tidak ditemukan.');
            }

            if (Auth::user()->guru->id !== $penilaian->teacher_id) {
                throw new \Exception('Akses tidak diizinkan.');
            }

            $nilaiTotal = round(
                ($request->nilai_tajwid +
                 $request->nilai_harakat +
                 $request->nilai_makhraj) / 3
            );

            $predikat = match (true) {
                $nilaiTotal >= 90 => 'mumtaz',
                $nilaiTotal >= 80 => 'jayyid_jiddan',
                default => 'jiddan'
            };

            $penilaian->update([
                'nilai_tajwid'  => $request->nilai_tajwid,
                'nilai_harakat' => $request->nilai_harakat,
                'nilai_makhraj' => $request->nilai_makhraj,
                'nilai_total'   => $nilaiTotal,
                'predikat'      => $predikat,
                'catatan'       => $request->catatan,
                'assessed_at'   => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('teacher.pengumpulan.index')
                ->with('success', 'Penilaian berhasil diperbarui.');

        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Gagal memperbarui penilaian.');
        }
    }

    public function destroy(Pengumpulan $pengumpulan)
    {
        DB::beginTransaction();

        try {

            $pengumpulan->load('tugasHafalan');

            if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
                throw new \Exception('Akses tidak diizinkan.');
            }

            if ($pengumpulan->penilaian) {
                $pengumpulan->penilaian->delete();
            }

            $pengumpulan->delete();

            DB::commit();

            return redirect()
                ->route('teacher.pengumpulan.index')
                ->with('success', 'Pengumpulan berhasil dihapus.');

        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Gagal menghapus pengumpulan.');
        }
    }

    public function downloadFile(Pengumpulan $pengumpulan)
    {
        $filePath = storage_path('app/public/' . $pengumpulan->file_pengumpulan);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath);
    }
}
