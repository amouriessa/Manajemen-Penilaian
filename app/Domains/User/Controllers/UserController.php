<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Requests\StoreUserRequest;
use App\Domains\User\Actions\CreateUserAction;
use App\Domains\User\Actions\GetUsersAction;
use App\Domains\User\Actions\GetUserStatisticsAction;
use App\Domains\User\Actions\UpdateUserAction;
use App\Domains\User\Requests\UpdateUserRequest;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        GetUsersAction $getUsers,
        GetUserStatisticsAction $getStatistics
    ) {

        $users = $getUsers->handle(
            $request->all()
        );

        $users->appends(
            $request->query()
        );

        $statistics = $getStatistics->handle();

        return view(
            'admin.users.index',
            [
                'users' => $users,
                ...$statistics,
            ]
        );
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(
        StoreUserRequest $request,
        CreateUserAction $action
    ) {
        $action->execute($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $avatarUrl = $user->avatar
        ? URL::signedRoute('admin.avatar.show', ['path' => $user->avatar], now()->addMinutes(15))
        : null;

        $user->load('roles');
        $this->authorize('view', $user);
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

    public function update(
    UpdateUserRequest $request,
    User $user,
    UpdateUserAction $action
    ) {
        $action->execute(
            $user,
            $request->validated()
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
