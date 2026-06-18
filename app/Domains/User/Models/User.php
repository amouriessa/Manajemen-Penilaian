<?php

namespace App\Domains\User\Models;

use App\Models\Student;
use App\Models\Teacher;
use App\Shared\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * User model.
 *
 * @method bool hasRole(string|array|\Spatie\Permission\Models\Role $roles, string|null $guard = null)
 * @method bool hasAnyRole(string|array|\Spatie\Permission\Models\Role $roles, string|null $guard = null)
 * @method bool hasAllRoles(string|array|\Spatie\Permission\Models\Role $roles, string|null $guard = null)
 * @method \Illuminate\Database\Eloquent\Collection roles()
 * @method bool assignRole(string|array|\Spatie\Permission\Models\Role $roles)
 * @method bool removeRole(\Spatie\Permission\Models\Role|string $role)
 * @method bool syncRoles(array|\Spatie\Permission\Models\Role|string ...$roles)
 * @method bool hasPermissionTo(string|\Spatie\Permission\Models\Permission $permission, string|null $guardName = null)
 */
/**
 * @property Teacher $guru
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Teacher::class);
    }

    public function siswa()
    {
        return $this->hasOne(Student::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->is_logged_in
                    ? 'Online'
                    : 'Offline'
        );
    }

    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->is_logged_in
                    ? 'text-green-600'
                    : 'text-red-600'
        );
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function roleEnum(): ?UserRole
    {
        $role = $this->roles->first()?->name;

        return $role
            ? UserRole::tryFrom($role)
            : null;
    }

    protected function roleLabel(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->roleEnum()?->label() ?? '-'
        );
    }

    protected function roleBadgeClass(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->roleEnum()?->badgeClass()
                ?? 'bg-gray-100 text-gray-800'
        );
    }
}
