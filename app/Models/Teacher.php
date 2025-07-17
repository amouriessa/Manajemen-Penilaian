<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nomor_telp',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasTahfidz()
    {
        return $this->hasMany(KelasTahfidz::class, 'teacher_id');
    }

    public function tugasHafalan()
    {
        return $this->hasMany(TugasHafalan::class, 'teacher_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'teacher_id');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return $this->status ? 'Aktif' : 'Tidak Aktif';
        });
    }
}
