<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Pengumpulan;
use App\Models\SiswaKelas;
use App\Models\TahunAjaran;
use App\Models\TugasHafalan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TugasHafalanSiswaController extends Controller
{
        /**
     * Menampilkan daftar tugas hafalan aktif untuk siswa yang login.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (! $user->siswa) abort(403, 'Akses ditolak. Anda bukan siswa.');

        $studentId = $user->siswa->id;
        $kelasId = null;
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
        $surahId = $request->surah_id;

        if (! $tahunAjaranAktif) {
            return view('student.tugas_hafalan.index', [
                'tugas' => collect(),
                'message' => 'Tidak ada tahun ajaran aktif saat ini. Tugas tidak dapat ditampilkan.'
            ]);
        }

        $siswaKelas = SiswaKelas::where('student_id', $studentId)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();
        if ($siswaKelas) $kelasId = $siswaKelas->kelas_tahfidz_id;

        $query = TugasHafalan::where(function($q) use ($studentId, $kelasId) {
            $q->whereHas('siswa', fn($qr) => $qr->where('students.id', $studentId));

            if ($kelasId) {
                $q->orWhere(fn($qr) => $qr->where('is_for_all_student', true)
                    ->where('kelas_tahfidz_id', $kelasId));
            }
        })
        ->where('is_archived', false)
        ->where('status', 'aktif')
        ->with(['surahHafalan', 'guru.user'])
        ->with(['pengumpulan' => fn($q) => $q->where('student_id', $studentId)])
        ->orderBy('tenggat_waktu', 'asc');

        $tugas = $query->paginate(10);

        $activeTasks = collect();
        $recentlyAssessedTasks = collect();
        $archivedTasks = collect();

        foreach ($tugas as $task) {
            $pengumpulan = $task->pengumpulan->first();
            $isSubmitted = ! is_null($pengumpulan);
            $hasAssessment = $isSubmitted && optional($pengumpulan)->penilaian;

            $task->is_submitted = $isSubmitted;
            $task->has_assessment = $hasAssessment;
            $task->submission = $pengumpulan;

            $deadline = Carbon::parse($task->tenggat_waktu);
            $task->days_left = $deadline->diffInDays(now());
            $task->is_urgent = $deadline->isPast() || $task->days_left <= 2;
            $task->parsed_deadline = $deadline;

            if ($hasAssessment) {
                $assessmentDate = Carbon::parse($pengumpulan->penilaian->assessed_at);
                $task->assessment_date = $assessmentDate;
                $task->days_until_archive = max(0, 3 - $assessmentDate->diffInDays(now()));

                if ($assessmentDate->diffInDays(now()) >= 3) {
                    $archivedTasks->push($task);
                } else {
                    $recentlyAssessedTasks->push($task);
                }
            } else {
                $activeTasks->push($task);
            }
        }

        return view('student.tugas_hafalan.index', compact(
            'tugas', 'kelasId', 'tahunAjaranAktif', 'studentId',
            'activeTasks', 'recentlyAssessedTasks', 'archivedTasks'
        ));
    }

    /**
     * Proses pengumpulan hafalan oleh siswa.
     */
    public function storeSubmission(Request $request, TugasHafalan $tugasHafalan)
    {

        $request->validate([
            'tugas_hafalan_id' => 'required|exists:tugas_hafalans,id',
            'file_pengumpulan' => 'required|file|mimes:mp3,wav,m4a,webm|max:20480',
            'catatan' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (! $user->siswa) abort(403, 'Akses ditolak. Profil siswa tidak ditemukan.');
        $student = $user->siswa;

        DB::beginTransaction();

        try {
            $filePath = null;
            if ($request->hasFile('file_pengumpulan')) {
                $file = $request->file('file_pengumpulan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengumpulan/audio/' . $student->id, $fileName, 'public');
            }

            $existingPengumpulan = Pengumpulan::where('tugas_hafalan_id', $tugasHafalan->id)
                ->where('student_id', $student->id)
                ->first();

            if ($existingPengumpulan && $existingPengumpulan->file_pengumpulan && Storage::disk('public')->exists($existingPengumpulan->file_pengumpulan)) {
                Storage::disk('public')->delete($existingPengumpulan->file_pengumpulan);
            }

            Pengumpulan::updateOrCreate(
                [
                    'tugas_hafalan_id' => $tugasHafalan->id,
                    'student_id' => $student->id,
                ],
                [
                    'file_pengumpulan' => $filePath,
                    'submitted_at' => now(),
                    'status' => 'dikumpulkan',
                    'catatan' => $request->catatan,
                    'nilai_total' => null,
                    'predikat' => null,
                ]
            );

            DB::commit();
            return redirect()->route('student.tugas_hafalan.index')->with('success', 'Hafalan berhasil dikumpulkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error storing submission for student {$student->id} and task {$tugasHafalan->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengumpulkan hafalan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pengumpulan hafalan siswa.
     */
    public function showPengumpulan(Pengumpulan $pengumpulan)
    {
        $user = Auth::user();
        if (! $user->siswa || $pengumpulan->student_id !== $user->siswa->id) {
            abort(403, 'Anda tidak memiliki akses ke detail pengumpulan tugas ini.');
        }

        $pengumpulan->load([
            'tugasHafalan.surahHafalan.surah',
            'penilaian',
            'siswa.user'
        ]);

        if (! $pengumpulan->penilaian) {
            abort(404, 'Penilaian untuk tugas ini belum tersedia.');
        }

        return view('student.pengumpulan.show', compact('pengumpulan'));
    }

    /**
     * Menampilkan form edit pengumpulan hafalan.
     */
    public function edit($tugasId)
    {
        $user = Auth::user();
        if (! $user->siswa) abort(403, 'Akses ditolak. Anda bukan siswa.');

        $pengumpulan = Pengumpulan::where('tugas_hafalan_id', $tugasId)
            ->where('student_id', $user->siswa->id)
            ->firstOrFail();

        return view('student.tugas_hafalan.edit', compact('pengumpulan'));
    }

    /**
     * Update file dan catatan pengumpulan hafalan.
     */
    public function update(Request $request, $tugasId)
    {
        $request->validate([
            'file_pengumpulan' => 'required|file|mimes:mp3,wav,m4a,webm|max:20480',
            'catatan_siswa' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (! $user->siswa) abort(403, 'Akses ditolak. Anda bukan siswa.');

        $pengumpulan = Pengumpulan::where('tugas_hafalan_id', $tugasId)
            ->where('student_id', $user->siswa->id)
            ->firstOrFail();

        if (! in_array($pengumpulan->status, ['dikumpulkan', 'menunggu_penilaian'])) {
            return redirect()->back()->with('error', 'Tugas sudah dinilai atau tidak bisa diedit.');
        }

        DB::beginTransaction();

        try {
            if ($pengumpulan->file_pengumpulan && Storage::disk('public')->exists($pengumpulan->file_pengumpulan) && $request->hasFile('file_pengumpulan')) {
                Storage::disk('public')->delete($pengumpulan->file_pengumpulan);
            }

            $filePath = null;
            if ($request->hasFile('file_pengumpulan')) {
                $file = $request->file('file_pengumpulan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengumpulan/audio/' . $user->siswa->id, $fileName, 'public');
            }

            $pengumpulan->update([
                'file_pengumpulan' => $filePath,
                'submitted_at' => now(),
                'status' => 'dikumpulkan',
                'catatan_siswa' => $request->catatan_siswa,
                'nilai_total' => null,
                'predikat' => null,
            ]);

            DB::commit();
            return redirect()->route('student.tugas_hafalan.index')->with('success', 'Tugas berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating submission for student {$user->siswa->id} and task {$tugasId}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui hafalan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan daftar tugas hafalan yang sudah dinilai dan melewati batas waktu pengarsipan.
     */
    public function archive(Request $request)
    {
        $student = Auth::user()->siswa;
        if (! $student) abort(403, 'Akun Anda belum terdaftar sebagai siswa.');

        $studentId = $student->id;
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        if (! $tahunAjaranAktif) {
            return view('student.tugas_hafalan.archive', [
                'tugas' => collect(),
                'studentId' => $studentId,
            ])->with('error', 'Tidak ada tahun ajaran aktif ditemukan.');
        }

        $siswaKelas = SiswaKelas::where('student_id', $studentId)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();

        if (! $siswaKelas) {
            return view('student.tugas_hafalan.archive', [
                'tugas' => collect(),
                'studentId' => $studentId,
            ]);
        }

        $search = $request->input('search');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $classId = $siswaKelas->kelas_tahfidz_id;

        $allTugas = TugasHafalan::where('kelas_tahfidz_id', $classId)
            ->with([
                'surahHafalan.surah',
                'guru.user',
                'kelasTahfidz',
                'pengumpulan' => fn($query) => $query->where('student_id', $studentId)->with('penilaian')
            ])
            ->get();

        $archivedTugas = $allTugas->filter(function ($task) {
            $pengumpulan = $task->pengumpulan->first();
            if (! $pengumpulan || ! $pengumpulan->penilaian) return false;

            $assessmentDate = Carbon::parse($pengumpulan->penilaian->assessed_at ?? $pengumpulan->penilaian->created_at);
            $task->submission = $pengumpulan;
            $task->assessmentDate = $assessmentDate;
            return $assessmentDate->diffInDays(now()) >= 3;
            // return true;
        });

        if ($search) {
            $archivedTugas = $archivedTugas->filter(function ($task) use ($search) {
                return $task->surahHafalan->contains(function ($surahHafalan) use ($search) {
                    return Str::contains(Str::lower(optional($surahHafalan->surah)->nama), Str::lower($search));
                });
            });
        }

        if ($tanggalAwal && $tanggalAkhir) {
            $archivedTugas = $archivedTugas->filter(function ($task) use ($tanggalAwal, $tanggalAkhir) {
                if (!$task->assessmentDate) return false;
                $assessmentDate = Carbon::parse($task->assessmentDate);
                return $assessmentDate->between($tanggalAwal, $tanggalAkhir);
            });
        } elseif ($tanggalAwal) {
            $archivedTugas = $archivedTugas->filter(function ($task) use ($tanggalAwal) {
                if (!$task->assessmentDate) return false;
                return Carbon::parse($task->assessmentDate)->gte($tanggalAwal);
            });
        } elseif ($tanggalAkhir) {
            $archivedTugas = $archivedTugas->filter(function ($task) use ($tanggalAkhir) {
                if (!$task->assessmentDate) return false;
                return Carbon::parse($task->assessmentDate)->lte($tanggalAkhir);
            });
        }

        $archivedTugas = $archivedTugas->sortByDesc(fn($task) => $task->assessmentDate ?? Carbon::minValue());

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $archivedTugas->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedTugas = new LengthAwarePaginator(
            $currentItems,
            $archivedTugas->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('student.tugas_hafalan.archive', [
            'tugas' => $paginatedTugas,
            'studentId' => $studentId,
        ]);
    }

    /**
     * Placeholder untuk fitur hapus (tidak diimplementasikan).
     */
    public function destroy(string $id)
    {
        abort(403, 'Fitur hapus tidak diizinkan atau tidak diimplementasikan.');
    }

    public function show(TugasHafalan $tugasHafalan)
    {
        $user = Auth::user();

        if (!$user->siswa) {
            abort(403, 'Akses ditolak. Anda bukan siswa.');
        }

        $studentId = $user->siswa->id;

        // Tambahkan validasi: tugas ini ditujukan untuk siswa ini atau kelasnya
        $isAssigned = $tugasHafalan->siswa()->where('students.id', $studentId)->exists();

        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
        $siswaKelas = SiswaKelas::where('student_id', $studentId)
                                ->where('tahun_ajaran_id', optional($tahunAjaranAktif)->id)
                                ->first();

        $isForClass = $tugasHafalan->is_for_all_student &&
                    $tugasHafalan->kelas_tahfidz_id === optional($siswaKelas)->kelas_tahfidz_id;

        if (!$isAssigned && !$isForClass) {
            abort(403, 'Tugas ini tidak ditujukan untuk Anda.');
        }

        // Cari pengumpulan dari siswa ini untuk tugas ini
    $pengumpulan = Pengumpulan::where('tugas_hafalan_id', $tugasHafalan->id)
                    ->where('student_id', $studentId)
                    ->with('penilaian')
                    ->first();


        $tugasHafalan->load('surahHafalan.surah', 'guru.user');

        return view('student.tugas_hafalan.show', compact('tugasHafalan', 'pengumpulan'));
    }
}
