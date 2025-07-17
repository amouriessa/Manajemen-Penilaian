<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class KelasTahfidz extends Model
{
    protected $fillable = [
        'teacher_id',
        'nama',
        'tingkatan_kelas'
    ];
    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'kelas_tahfidz_id');
    }

    public function siswaKelasTahunAjaran($tahunAjaranId)
    {
        return $this->siswaKelas()->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function tugasHafalan()
    {
        return $this->hasMany(TugasHafalan::class, 'kelas_tahfidz_id');
    }

    public function siswaAktif()
    {
        return $this->siswaKelas()->whereHas('student', function ($q) {
            $q->where('status', 'aktif');
        });
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,      // model relasi
            'siswa_kelas',       // nama tabel pivot
            'kelas_tahfidz_id',  // foreign key di tabel pivot yang merujuk ke model ini
            'student_id'         // foreign key di tabel pivot yang merujuk ke model Student
        );
    }
    public function getTingkatanLabelAttribute()
    {
        return [
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
        ][$this->tingkatan_kelas] ?? $this->tingkatan_kelas;
    }

}
