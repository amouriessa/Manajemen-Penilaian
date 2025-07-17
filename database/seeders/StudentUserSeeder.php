<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StudentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );

        $user->assignRole('student');
    }
}
