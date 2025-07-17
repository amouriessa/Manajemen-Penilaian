<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'tahun_angkatan_id',
        'nis',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tahunAngkatan()
    {
        return $this->belongsTo(TahunAngkatan::class, 'tahun_angkatan_id');
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'student_id', 'id');
    }

    // Siswa.php
    public function kelasTahfidz()
    {
        return $this->belongsToMany(KelasTahfidz::class, 'siswa_kelas')
                    ->withPivot('tahun_ajaran_id')
                    ->withTimestamps();
    }

    public function getKelasTahfidzAktif()
    {
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaranAktif) return null;

        return $this->riwayatKelas()
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->with('kelasTahfidz')
            ->first();
    }

    public function riwayatKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'student_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'student_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'student_id');
    }

    public function tugasSiswa()
    {
        return $this->belongsToMany(TugasHafalan::class, 'tugas_siswas', 'student_id', 'tugas_hafalan_id');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return $this->status ? 'Aktif' : 'Tidak Aktif';
        });
    }

    public function hafalanSubmissions() // Relasi baru ke HafalanSubmission
    {
        return $this->hasMany(HafalanSubmission::class);
    }
}
