<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasHafalan extends Model
{
    protected $fillable = [
        'teacher_id',
        'kelas_tahfidz_id',
        'nama',
        'deskripsi',
        'jenis_tugas',
        'tenggat_waktu',
        'status',
        'is_archived',
        'is_for_all_student'
    ];
    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function kelasTahfidz()
    {
        return $this->belongsTo(KelasTahfidz::class, 'kelas_tahfidz_id');
    }

    // public function surah()
    // {
    //     return $this->belongsToMany(Surah::class, 'surah_hafalans')
    //         ->withPivot('ayat_awal', 'ayat_akhir')
    //         ->withTimestamps();
    // }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'tugas_hafalan_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'tugas_hafalan_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Student::class, 'tugas_siswas', 'tugas_hafalan_id', 'student_id');
    }

    // public function surahHafalan()
    // {
    //     return $this->hasMany(SurahHafalan::class, 'surah_hafalan_id');
    // }

    // public function surahHafalan()
    // {
    //     return $this->belongsToMany(Surah::class, 'surah_hafalans')
    //         ->withPivot('ayat_awal', 'ayat_akhir');
    // }

    public function surahHafalan() // Ini harusnya relasi ke SurahHafalan untuk tugas tersebut
    {
        // Asumsi satu tugas hafalan bisa punya banyak surah yang dihafalkan
        return $this->hasMany(SurahHafalan::class, 'tugas_hafalan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function hafalanSubmissions() // Relasi baru ke HafalanSubmission
    {
        return $this->hasMany(HafalanSubmission::class);
    }
}
