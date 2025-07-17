<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\TahunAjaran;
use App\Models\TahunAngkatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        // Ubah eager loading di sini
        $studentsQuery = Student::with(['user', 'tahunAngkatan'])
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'student');
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            });

        // Perbaikan pada sorting untuk relasi (jika ingin sorting berdasarkan nama user)
        if ($sort == 'name_asc') {
            $studentsQuery->join('users', 'students.user_id', '=', 'users.id')
                          ->orderBy('users.name', 'asc')
                          ->select('students.*'); // Penting untuk memilih kembali kolom asli Student
        } elseif ($sort == 'name_desc') {
            $studentsQuery->join('users', 'students.user_id', '=', 'users.id')
                          ->orderBy('users.name', 'desc')
                          ->select('students.*');
        } elseif ($sort == 'newest') {
            $studentsQuery->orderBy('students.created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $studentsQuery->orderBy('students.created_at', 'asc');
        }

        // Tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Kelas saat ini
        // $kelasAktif = $studentsQuery->riwayatKelas()
        // ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
        // ->with('kelasTahfidz') // ini perlu jika ingin eager-load kelasTahfidz
        // ->first();
        // $kelasAktif = $studentsQuery->siswaKelas
        //         ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
        //         ->where('status', true)
        //         ->first();


        $students = $studentsQuery->paginate($perPage)->appends($request->query());

        $students->getCollection()->transform(function ($student) use ($tahunAjaranAktif) {
            $student->kelas_aktif = $student->getKelasTahfidzAktif(); // method dari model Student
            return $student;
        });
        // $students = Student::with('user', 'tahunAngkatan')->latest()->paginate(10);
        return view('admin.siswa.index', compact('students', 'tahunAjaranAktif'));
    }

    public function create()
    {
        // Ambil user yang belum jadi siswa
        $users = User::whereDoesntHave('siswa')->get();
        $tahunAngkatan = TahunAngkatan::all();

        return view('admin.siswa.create', compact('users', 'tahunAngkatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => ['required', 'exists:users,id', Rule::unique('students', 'user_id')],
            'tahun_angkatan_id' => ['required', 'exists:tahun_angkatans,id'],
            'nis'             => ['required', 'digits:7', 'unique:students,nis'],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'tanggal_lahir'   => ['required', 'date'],
            'alamat'          => ['nullable', 'string'],
            'status'          => ['required', 'in:aktif,lulus,keluar,pindah'],
        ]);

        $student = Student::create($request->all());

        // Cari tahun ajaran aktif
        // $tahunAjaranAktif = TahunAjaran::where('status', 'aktif')->first();

        // if ($tahunAjaranAktif) {
        //     // Cari kelas tahfidz yang aktif (bisa pakai kelas default atau dipilih dari input)
        //     $kelasTahfidz = KelasTahfidz::where('status', 'aktif')->first(); // atau pakai inputan

        //     if ($kelasTahfidz) {
        //         // Hubungkan ke tabel pivot siswa_kelas
        //         SiswaKelas::create([
        //             'id_siswa'        => $student->id,
        //             'id_kelas_tahfidz'=> $kelasTahfidz->id,
        //             'id_tahun_ajaran' => $tahunAjaranAktif->id,
        //         ]);
        //     }
        // }

        // Beri role siswa ke user
        $user = User::find($request->user_id);
        $user->assignRole('student');

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $student = Student::with('user', 'tahunAngkatan', 'riwayatKelas')->findOrFail($id);
        // Riwayat kelas
        $riwayat = $student->riwayatKelas()
            ->with(['kelasTahfidz', 'tahunAjaran'])
            ->get();

        // Kelas aktif (jika ada)
        $kelasAktif = $student->getKelasTahfidzAktif();

        $avatarUrl = $student->user->avatar
            ? URL::signedRoute('admin.avatar.show', ['path' => $student->user->avatar], now()->addMinutes(15))
            : null;

        return view('admin.siswa.show', compact('student', 'avatarUrl', 'riwayat', 'kelasAktif'));
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $tahunAngkatan = TahunAngkatan::all();

        return view('admin.siswa.edit', compact('student', 'tahunAngkatan'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'tahun_angkatan_id' => ['required', 'exists:tahun_angkatans,id'],
            'nis'             => ['required', 'digits:7', Rule::unique('students', 'nis')->ignore($student->id)],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'tanggal_lahir'   => ['required', 'date'],
            'alamat'          => ['nullable', 'string'],
            'status'          => ['required', 'in:aktif,lulus,keluar,pindah'],
        ]);

        $student->update($request->only([
            'tahun_angkatan_id', 'nis', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'status'
        ]));

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        // Hapus role jika perlu
        if ($user) {
            $user->removeRole('student');
        }

        $student->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function searchUser(Request $request)
    {
        $search = $request->input('q');

        $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'student');
            })
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'email']);

        $results = $users->map(function($user) {
            return [
                'value' => $user->id,
                'text' => $user->name,
                'email' => $user->email
            ];
        });

        return response()->json($results);
    }
}
