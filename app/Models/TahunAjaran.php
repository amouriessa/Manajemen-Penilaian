<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'status'
    ];
    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'tahun_ajaran_id');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return $this->status ? 'Aktif' : 'Tidak Aktif';
        });
    }
}
