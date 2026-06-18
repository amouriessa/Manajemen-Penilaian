<?php

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUsersAction
{
    public function handle(array $filters): LengthAwarePaginator
    {
        $roleFilter = $filters['role'] ?? null;
        $search = $filters['search'] ?? null;
        $sort = $filters['sort'] ?? null;
        $perPage = $filters['perPage'] ?? 10;

        $query = User::query()

            ->when($roleFilter, function ($query) use ($roleFilter) {
                $query->whereHas('roles', function ($query) use ($roleFilter) {
                    $query->where('name', $roleFilter);
                });
            })

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });

        match ($sort) {
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->latest(),
        };

        $users = $query->paginate($perPage);

        return $users;
    }
}
