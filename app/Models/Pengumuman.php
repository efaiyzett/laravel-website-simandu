<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'keterangan',
        'status',
    ];

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'pengumuman_id');
    }

}
