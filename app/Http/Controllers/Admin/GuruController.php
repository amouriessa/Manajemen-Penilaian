<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $teachersQuery = Teacher::with('user')
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'teacher');
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            });

        if ($sort == 'name_asc') {
            $teachersQuery->whereHas('user', function ($q) {
                $q->orderBy('name', 'asc');
            });
        } elseif ($sort == 'name_desc') {
            $teachersQuery->whereHas('user', function ($q) {
                $q->orderBy('name', 'desc');
            });
        } elseif ($sort == 'newest') {
            $teachersQuery->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $teachersQuery->orderBy('created_at', 'asc');
        }

        $teachers = $teachersQuery->paginate($perPage)->appends($request->query());

        // $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.guru.index', compact('teachers'));
    }

    public function create()
    {
        // Hanya ambil user yang belum jadi guru
        $users = User::whereDoesntHave('guru')->get();
        return view('admin.guru.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => ['required', 'exists:users,id', Rule::unique('teachers', 'user_id')],
            'nip'           => ['required', 'digits:18', 'unique:teachers,nip'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat'        => ['nullable', 'string'],
            'no_telpon'     => ['nullable', 'string'],
            'status'        => ['required', 'boolean'],
        ]);

        Teacher::create($request->all());

        // Tambahkan role ke user (jika pakai spatie)
        $user = User::find($request->user_id);
        $user->assignRole('teacher');

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $avatarUrl = $teacher->user->avatar
            ? URL::signedRoute('admin.avatar.show', ['path' => $teacher->user->avatar], now()->addMinutes(15))
            : null;

        return view('admin.guru.show', compact('teacher', 'avatarUrl'));
    }

    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.guru.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'nip'           => ['required', 'digits:18', Rule::unique('teachers', 'nip')->ignore($teacher->id)],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat'        => ['nullable', 'string'],
            'no_telpon'     => ['nullable', 'string'],
            'status'        => ['required', 'boolean'],
        ]);

        $teacher->update($request->only([
            'nip', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_telpon', 'status'
        ]));

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        // Hapus role jika perlu
        if ($user) {
            $user->removeRole('teacher');
        }

        $teacher->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function searchUser(Request $request)
    {
        $search = $request->input('q');

        $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'teacher');
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
