<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HafalanSubmission extends Model
{
    use HasFactory;

    protected $table = 'hafalan_submissions';

    protected $fillable = [
        'tugas_hafalan_id',
        'student_id',
        'status',
        'file_path_rekaman',
        'tanggal_dikumpulkan',
        'catatan_siswa',
        'nilai_total',
        'predikat',
    ];

    protected $casts = [
        'tanggal_dikumpulkan' => 'datetime',
    ];

    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
