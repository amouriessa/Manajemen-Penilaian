<?php

namespace App\Domains\User\Policies;

use App\Domains\User\Models\User;

class UserPolicy
{
    public function view(User $authUser, User $student): bool
    {
        if ($authUser->hasRole('admin')) {
            return true;
        }

        if (!$authUser->hasRole('teacher')) {
            return false;
        }

        return $authUser->students()
            ->where('users.id', $student->id)
            ->exists();
    }
}
