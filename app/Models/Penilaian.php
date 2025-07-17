<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'pengumpulan_id',
        'student_id',
        'teacher_id',
        'tugas_hafalan_id',
        'jenis_penilaian',
        'jenis_hafalan',
        'nilai_tajwid',
        'nilai_harakat',
        'nilai_makhraj',
        'nilai_total',
        'predikat',
        'catatan',
        'assessed_at'

    ];
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function pengumpulan()
    {
        return $this->belongsTo(Pengumpulan::class, 'pengumpulan_id');
    }

    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class, 'tugas_hafalan_id');
    }

    // public function surahHafalan()
    // {
    //     return $this->belongsToMany(Surah::class, 'surah_hafalans')
    //         ->withPivot('ayat_awal', 'ayat_akhir');
    // }

    public function surahHafalanPenilaian()
    {
        return $this->hasMany(SurahHafalan::class, 'penilaian_id');
    }

    public function getPredikatLabelAttribute()
    {
        return match ($this->predikat) {
            'mumtaz' => 'Mumtaz',
            'jayyid_jiddan' => 'Jayyid Jiddan',
            'jiddan' => 'Jiddan',
            default => 'Jiddan',
        };
    }
}
