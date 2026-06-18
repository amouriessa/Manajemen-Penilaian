<?php

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction
{
    public function execute(
        User $user,
        array $data
    ): User {

        if (! empty($data['password'])) {
            $data['password'] =
                Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (! empty($data['avatar'])) {

            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            $data['avatar'] =
                $data['avatar']->store(
                    'avatars',
                    'private'
                );
        }

        $role = $data['role'];

        unset($data['role']);

        $user->update($data);

        $user->syncRoles([$role]);

        return $user;
    }
}
