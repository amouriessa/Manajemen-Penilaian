<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    protected $table = 'siswa_kelas';
    protected $fillable = [
        'student_id',
        'kelas_tahfidz_id',
        'tahun_ajaran_id'
    ];
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function kelasTahfidz()
    {
        return $this->belongsTo(KelasTahfidz::class, 'kelas_tahfidz_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
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
