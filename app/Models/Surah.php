<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $fillable = [
        'nama',
        'total_ayat'
    ];
    public function tugasHafalan()
    {
        return $this->belongsToMany(TugasHafalan::class, 'surah_hafalans')
            ->withPivot('ayat_awal', 'ayat_akhir')
            ->withTimestamps();
    }
}
