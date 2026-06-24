<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'dokumentasi';

    protected $fillable = [
        'pengumuman_id',
        'path',
    ];

    public $timestamps = false;

    public function pengumuman()
    {
        return $this->belongsTo(Pengumuman::class, 'pengumuman_id');
    }
}
