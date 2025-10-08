<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

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

    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
