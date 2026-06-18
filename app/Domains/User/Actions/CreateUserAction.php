<?php

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class CreateUserAction
{
    public function __construct(
        private UploadAvatarAction $uploadAvatar
    ) {}

    public function execute(array $data): User
    {
        if (isset($data['avatar'])) {
            $data['avatar'] =
                $this->uploadAvatar->execute($data['avatar']);
        }

        $role = $data['role'];

        unset($data['role']);

        $data['password'] =
            Hash::make($data['password']);

        $user = User::create($data);

        $user->assignRole($role);

        event(new Registered($user));

        return $user;
    }
}
