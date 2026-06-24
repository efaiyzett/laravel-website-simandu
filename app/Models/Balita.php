<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'balita';

    protected $fillable = [
        'nama',
        'nik',
        'nama_ortu',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(PemeriksaanBalita::class);
    }

    
}
