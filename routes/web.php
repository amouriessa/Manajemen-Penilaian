<?php

use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasTahfidzController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SiswaKelasController;
use App\Http\Controllers\Admin\SurahController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\TahunAngkatanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Student\TugasHafalanSiswaController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\LaporanController;
use App\Http\Controllers\Teacher\LaporanKelasController;
use App\Http\Controllers\Teacher\PengumpulanController;
use App\Http\Controllers\Teacher\PenilaianLangsungController;
use App\Http\Controllers\Teacher\TugasHafalanController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.tugas_hafalan.index');
    }

    abort(403);
})->middleware('auth', 'verified')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Manajemen dashboard admin
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Link avatar
    Route::get('/avatar/{path}', [FileAccessController::class, 'show'])
    ->middleware('signed')
    ->where('path', '.*')
    ->name('avatar.show');

    // Manajemen user
    Route::resource('/users', UserController::class);
    Route::get('admin/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('admin/users/get', [UserController::class, 'getById'])->name('users.get');

    // Manajemen guru
    Route::resource('/guru', GuruController::class);
    Route::get('/admin/guru/user-search', [GuruController::class, 'searchUser'])->name('guru.searchUser');

    // Manajemen siswa
    Route::resource('/siswa', SiswaController::class);
    Route::get('/admin/siswa/user-search', [SiswaController::class, 'searchUser'])->name('siswa.searchUser');

    // Manajemen kelas
    Route::resource('/kelas_tahfidz', KelasTahfidzController::class);

    // Manajemen tahun ajaran
    Route::resource('/tahun_ajaran', TahunAjaranController::class);

    // Manajemen tahun angkatan
    Route::resource('/tahun_angkatan', TahunAngkatanController::class);

    // Manajemen surah al quran
    Route::resource('/surah', SurahController::class);

    // Manajemen siswa kelas (penempatan siswa ke kelas dengan tahun ajaran tertentu)
    Route::resource('/manajemen_siswa_kelas', SiswaKelasController::class)->except(['show']);
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Manajemen dashboard guru
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');

    // Manajemen tugas
    Route::resource('/tugas_hafalan', TugasHafalanController::class);
    // Route BARU untuk daftar tugas yang diarsipkan
    // Route::get('/teacher/tugas-hafalan/arsip', [TugasHafalanController::class, 'archivedTasks'])->name('tugas_hafalan.archived');
    // // Route BARU untuk mengarsipkan/mengembalikan tugas
    // Route::post('/teacher/tugas-hafalan/{tugasHafalan}/toggle-arsip', [TugasHafalanController::class, 'toggleArchive'])->name('tugas_hafalan.toggle-archive');

    Route::patch('tugas_hafalan/{tugasHafalan}/toggle-archive', [TugasHafalanController::class, 'toggleArchive'])
        ->name('tugas_hafalan.toggle-archive');
    Route::put('tugas_hafalan/{tugasHafalan}/toggle-archive', [TugasHafalanController::class, 'toggleArchive'])
        ->name('tugas_hafalan.toggle-archive');

    // Ambil siswa
    Route::get('/get-siswa-by-kelas/{kelasTahfidzId}', [TugasHafalanController::class, 'getSiswaByKelas']);

    // Manajemen pengumpulan
    Route::get('/pengumpulan', [PengumpulanController::class, 'index'])->name('pengumpulan.index');
    Route::get('/pengumpulan/{pengumpulan}', [PengumpulanController::class, 'show'])->name('pengumpulan.show');
    Route::get('/pengumpulan/{pengumpulan}/buat-penilaian', [PengumpulanController::class, 'create'])->name('penilaian.pengumpulan.create');
    Route::post('/pengumpulan/{pengumpulan}/penilaian', [PengumpulanController::class, 'storePenilaian'])->name('penilaian.pengumpulan.store');
    Route::get('/pengumpulan/{pengumpulan}/edit-penilaian', [PengumpulanController::class, 'edit'])->name('penilaian.pengumpulan.edit');
    Route::put('/pengumpulan/{pengumpulan}/penilaian', [PengumpulanController::class, 'updatePenilaian'])->name('penilaian.pengumpulan.update');
    Route::get('/pengumpulan/{pengumpulan}/download', [PengumpulanController::class, 'downloadFile'])->name('pengumpulan.download');

    // Penilaian Langsung
    Route::get('penilaian/langsung', [PenilaianLangsungController::class, 'index'])->name('penilaian.langsung.index');
    Route::get('penilaian/langsung/create', [PenilaianLangsungController::class, 'create'])->name('penilaian.langsung.create');
    Route::post('penilaian/langsung', [PenilaianLangsungController::class, 'store'])->name('penilaian.langsung.store');
    Route::get('penilaian/langsung/{penilaian}/edit', [PenilaianLangsungController::class, 'edit'])->name('penilaian.langsung.edit');
    Route::put('penilaian/langsung/{penilaian}', [PenilaianLangsungController::class, 'update'])->name('penilaian.langsung.update');
    Route::get('penilaian/langsung/{penilaian}', [PenilaianLangsungController::class, 'show'])->name('penilaian.langsung.show');
    Route::delete('penilaian/langsung/{penilaian}', [PenilaianLangsungController::class, 'destroy'])->name('penilaian.langsung.destroy');
    Route::get('/admin/siswa/user-search', [PenilaianLangsungController::class, 'searchStudentUser'])->name('siswa.searchUser');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan', [LaporanKelasController::class, 'index'])->name('laporankelas.index');
    // Route::get('/api/students-by-class', [LaporanController::class, 'byClass'])
    // ->name('api.students.by-class');
    // // routes/web.php
    // Route::get('/teacher/laporan/siswa-by-kelas', [LaporanController::class, 'byClass'])->name('laporan.siswa-by-kelas');

    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // Manajemen halaman hafalan siswa (tampilan awal)
    Route::get('/tugas_hafalan', [TugasHafalanSiswaController::class, 'index'])->name('tugas_hafalan.index');

    Route::get('/tugas_hafalan/archive', [TugasHafalanSiswaController::class, 'archive'])->name('tugas_hafalan.archive');
    Route::put('/tugas_hafalan/archive', [TugasHafalanSiswaController::class, 'archive'])->name('tugas_hafalan.archive.put');

    Route::get('/tugas_hafalan/{id}/edit', [TugasHafalanSiswaController::class, 'edit'])->name('tugas_hafalan.edit');
    Route::put('/tugas_hafalan/{id}/update', [TugasHafalanSiswaController::class, 'update'])->name('tugas_hafalan.update');

    Route::get('/tugas_hafalan/{tugasHafalan}', [TugasHafalanSiswaController::class, 'show'])->name('tugas_hafalan.show');

    Route::post('/tugas_hafalan/{tugasHafalan}/submit_hafalan', [TugasHafalanSiswaController::class, 'storeSubmission'])->name('tugas_hafalan.submit_hafalan');

    Route::get('pengumpulan/{pengumpulan}', [TugasHafalanSiswaController::class, 'showPengumpulan'])
        ->name('pengumpulan.show');

    Route::get('/tugas_hafalan/archive-redirect', function () {
    session()->put('hide_archive_notification', true);
    return redirect()->route('tugas_hafalan.archive');
        })->name('tugas_hafalan.archive.redirect');

});

require __DIR__.'/auth.php';
