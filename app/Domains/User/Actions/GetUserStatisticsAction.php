<?php

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;

class GetUserStatisticsAction
{
    public function handle(): array
    {
        return [
            'adminsCount' => User::role('admin')->count(),
            'teachersCount' => User::role('teacher')->count(),
            'studentsCount' => User::role('student')->count(),
            'totalUsers' => User::count(),
        ];
    }
}
