<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tugas_hafalan_id',
        'student_id',
        'file_pengumpulan',
        'status',
        'submitted_at'
    ];
    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class, 'tugas_hafalan_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'pengumpulan_id');
    }

    public function surahHafalan()
    {
        // If 'surah_hafalans' table has a 'pengumpulan_id' column
        return $this->hasOne(SurahHafalan::class, 'pengumpulan_id', 'id');
        // Default: return $this->hasOne(SurahHafalan::class); (if foreign key is 'pengumpulan_id' by convention)
    }
}
