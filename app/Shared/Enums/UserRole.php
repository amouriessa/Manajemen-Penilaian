<?php

namespace App\Shared\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case PARENT = 'parent';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::TEACHER => 'Guru',
            self::STUDENT => 'Siswa',
            self::PARENT => 'Orang Tua',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::ADMIN =>
                'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',

            self::TEACHER =>
                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',

            self::STUDENT =>
                'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',

            self::PARENT =>
                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        };
    }
}
