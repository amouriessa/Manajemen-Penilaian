<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $adminsCount = User::role('admin')->count();
        $teachersCount = User::role('teacher')->count();
        $studentsCount = User::role('student')->count();
        $totalUsers = User::count();

        $usersQuery = User::when($roleFilter, function ($query) use ($roleFilter) {
            return $query->whereHas('roles', function ($query) use ($roleFilter) {
                $query->where('name', $roleFilter);
            });
        })
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        });

        if ($sort == 'name_asc') {
            $usersQuery->orderBy('name', 'asc');
        } elseif ($sort == 'name_desc') {
            $usersQuery->orderBy('name', 'desc');
        } elseif ($sort == 'newest') {
            $usersQuery->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $usersQuery->orderBy('created_at', 'asc');
        }

        $users = $usersQuery->paginate($perPage)->appends($request->query());

        $users->getCollection()->transform(function ($userItem) {
            $userItem->status = $userItem->is_logged_in ? 'Online' : 'Offline';
            $userItem->status_class = $userItem->is_logged_in ? 'text-green-500' : 'text-red-500';
            return $userItem;
        });

        //$users = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users', 'adminsCount', 'teachersCount', 'studentsCount', 'totalUsers'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|string|in:admin,teacher,student',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            //'email_verified_at' => Carbon::now(),
        ]);

        // Simpan file avatar jika ada
        if ($request->hasFile('avatar')) {
            $filename = 'avatar_' . Str::uuid() . '.' . $request->file('avatar')->extension();

            // Simpan ke storage/app/avatars
            $path = $request->file('avatar')->storeAs('avatars', $filename, 'private');

            // Simpan path ke database
            $validated['avatar'] = $path;
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole($validated['role']);

        event(new Registered($user));

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $avatarUrl = $user->avatar
        ? URL::signedRoute('admin.avatar.show', ['path' => $user->avatar], now()->addMinutes(15))
        : null;

        $user->load('roles');
        return view('admin.users.show', compact('user', 'avatarUrl'));
    }

    public function edit(User $user)
    {
        $avatarUrl = $user->avatar
        ? URL::signedRoute('admin.avatar.show', ['path' => $user->avatar], now()->addMinutes(15))
        : null;

        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles', 'avatarUrl'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|string|in:admin,teacher,student',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle avatar
        if ($request->hasFile('avatar')) {
            // Hapus file lama jika ada
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }

            // Simpan avatar baru dengan UUID ke disk default (storage/app/avatars)
            $filename = 'avatar_' . Str::uuid() . '.' . $request->file('avatar')->extension();
            $path = $request->file('avatar')->storeAs('avatars', $filename, 'private');
            $validated['avatar'] = $path;
        }

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
