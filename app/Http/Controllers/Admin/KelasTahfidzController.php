<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\TahunAjaran;
use App\Models\Teacher;
use Illuminate\Http\Request;

class KelasTahfidzController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $tahunAjaranId = $request->input('tahun_ajaran_id');

        $kelasTahfidzQuery = KelasTahfidz::with('guru.user', 'tahunAjaran', )
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('tahun_ajaran', function ($q) use ($search) {
                        $q->where('tahun_ajaran', 'like', "%{$search}%");
                    })
                    ->orWhereHas('guru.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->withCount('siswaKelas as total_siswa');
            // ->withCount(['siswaKelas as total_siswa' => function ($query) use ($tahunAjaranId) {
            //     if ($tahunAjaranId) {
            //         $query->wherePivot('tahun_ajaran_id', $tahunAjaranId);
            //     }
            // }]);

        if ($sort == 'name_asc') {
            $kelasTahfidzQuery->orderBy('nama', 'asc');
        } elseif ($sort == 'name_desc') {
            $kelasTahfidzQuery->orderBy('nama', 'desc');
        } elseif ($sort == 'newest') {
            $kelasTahfidzQuery->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $kelasTahfidzQuery->orderBy('created_at', 'asc');
        }

        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        $kelasTahfidz = KelasTahfidz::withCount(['students as total_siswa' => function ($query) use ($tahunAjaranAktif) {
            $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
        }])->get();

        $kelasTahfidz = $kelasTahfidzQuery->paginate($perPage)->appends($request->query());

        $tahunAjaran = TahunAjaran::all();

        // $kelasTahfidz = KelasTahfidz::with('tahunAjaran')->get();
        return view('admin.kelas_tahfidz.index', compact('kelasTahfidz', 'tahunAjaran', 'tahunAjaranAktif'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaranAktif) {
            return redirect()->route('admin.kelas_tahfidz.index')->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        return view('admin.kelas_tahfidz.create', compact('tahunAjaranAktif', 'teachers'));
    }

    public function store(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $request->validate([
            'nama' => 'required|string',
            'tingkatan_kelas' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        KelasTahfidz::create([
            'nama' => $request->nama,
            'tingkatan_kelas' => $request->tingkatan_kelas,
            'teacher_id' => $request->teacher_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
        ]);

        return redirect()->route('admin.kelas_tahfidz.index')->with('success', 'Kelas tahfidz berhasil dibuat.');
    }

    public function edit(KelasTahfidz $kelasTahfidz)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.kelas_tahfidz.edit', compact('kelasTahfidz', 'teachers'));
    }

    public function update(Request $request, KelasTahfidz $kelasTahfidz)
    {
        $request->validate([
            'nama' => 'required|string',
            'tingkatan_kelas' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
        ]);

        $kelasTahfidz->update([
            'nama' => $request->nama,
            'tingkatan_kelas' => $request->tingkatan_kelas,
            'teacher_id' => $request->teacher_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id
        ]);

        return redirect()->route('admin.kelas_tahfidz.index')->with('success', 'Kelas tahfidz berhasil diperbarui.');
    }

    public function destroy(KelasTahfidz $kelasTahfidz)
    {
        $kelasTahfidz->delete();
        return redirect()->route('admin.kelas_tahfidz.index')->with('success', 'Kelas tahfidz berhasil dihapus.');
    }
}
