<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TahunAngkatan extends Model
{
    protected $fillable = [
        'tahun_angkatan',
        'status'
    ];
    public function siswa()
    {
        return $this->hasMany(Student::class, 'tahun_angkatan_id');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return $this->status ? 'Aktif' : 'Tidak Aktif';
        });
    }
}
