<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurahHafalan extends Model
{
    protected $fillable = [
        'tugas_hafalan_id',
        'penilaian_id',
        'surah_id',
        'ayat_awal',
        'ayat_akhir'
    ];

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function tugasHafalan()
    {
        return $this->belongsTo(TugasHafalan::class, 'tugas_hafalan_id');
    }

    public function pengumpulan()
    {
        return $this->belongsTo(Pengumpulan::class, 'pengumpulan_id', 'id');
    }

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
