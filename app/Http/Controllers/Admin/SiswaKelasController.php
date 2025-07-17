<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAjaranId = $request->get('tahun_ajaran_id');
        $kelasTahfidzId = $request->get('kelas_tahfidz_id');
        $search = $request->get('search');
        $sort = $request->get('sort', 'newest'); // default
        $perPage = $request->get('per_page', 10); // default 10

        $tahunAjaran = TahunAjaran::all();
        $kelasTahfidz = KelasTahfidz::all();

        $query = SiswaKelas::with('siswa.user')
            ->when($tahunAjaranId, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->when($kelasTahfidzId, fn ($q) => $q->where('kelas_tahfidz_id', $kelasTahfidzId))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('siswa.user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });

        // Sort berdasarkan opsi
        if ($sort == 'name_asc') {
            $query->join('students', 'siswa_kelas.student_id', '=', 'students.id')
                ->join('users', 'students.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc')
                ->select('siswa_kelas.*');
        } elseif ($sort == 'name_desc') {
            $query->join('students', 'siswa_kelas.student_id', '=', 'students.id')
                ->join('users', 'students.user_id', '=', 'users.id')
                ->orderBy('users.name', 'desc')
                ->select('siswa_kelas.*');
        } elseif ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else { // default: newest
            $query->orderBy('created_at', 'desc');
        }

        $assignedSiswa = $query->paginate($perPage)->appends($request->query());

        return view('admin.manajemen_siswa_kelas.index', compact(
            'assignedSiswa',
            'tahunAjaran',
            'kelasTahfidz',
            'tahunAjaranId',
            'kelasTahfidzId',
            'search',
            'sort'
        ));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        $kelasTahfidz = KelasTahfidz::all();
        $tahunAjaran = TahunAjaran::where('status', true)->get();

        return view('admin.manajemen_siswa_kelas.create', compact('students', 'kelasTahfidz', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'kelas_tahfidz_id' => 'required|exists:kelas_tahfidzs,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        foreach ($request->student_ids as $studentId) {
            SiswaKelas::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'tahun_ajaran_id' => $request->tahun_ajaran_id,
                ],
                [
                    'kelas_tahfidz_id' => $request->kelas_tahfidz_id,
                ]
            );
        }

        return redirect()->route('admin.manajemen_siswa_kelas.index')
            ->with('success', 'Penempatan siswa berhasil disimpan.');
    }

    public function edit($id)
    {
        $assignment = SiswaKelas::findOrFail($id);
        $students = Student::with('user')->get();
        $tahunAjaran = TahunAjaran::where('status', true)->get();
        $kelasTahfidz = KelasTahfidz::all();
        $selectedStudentIds = [];

        if ($assignment->kelas_tahfidz_id && $assignment->tahun_ajaran_id) {
            $selectedStudentIds = SiswaKelas::where('kelas_tahfidz_id', $assignment->kelas_tahfidz_id)
                ->where('tahun_ajaran_id', $assignment->tahun_ajaran_id)
                ->pluck('student_id')
                ->toArray();
        }

        return view('admin.manajemen_siswa_kelas.edit', compact(
            'assignment', 'students', 'tahunAjaran', 'kelasTahfidz', 'selectedStudentIds'
        ));
    }

    public function update(Request $request, $id)
    {
        $tahunAktifIds = TahunAjaran::where('status', true)->pluck('id')->toArray();

        $request->validate([
            // 'student_id' => 'required|exists:students,id',
            'kelas_tahfidz_id' => 'required|exists:kelas_tahfidzs,id',
            'tahun_ajaran_id' => ['required', Rule::in($tahunAktifIds)],
        ]);

        $assignment = SiswaKelas::findOrFail($id);
        $assignment->update($request->only('student_id', 'kelas_tahfidz_id', 'tahun_ajaran_id'));

        return redirect()->route('admin.manajemen_siswa_kelas.index')
            ->with('success', 'Data penempatan siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $assignment = SiswaKelas::findOrFail($id);
        $assignment->delete();

        return redirect()->route('admin.manajemen_siswa_kelas.index')
            ->with('success', 'Data penempatan siswa berhasil dihapus.');
    }
}
