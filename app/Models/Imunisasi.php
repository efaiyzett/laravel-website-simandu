<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    protected $table = 'imunisasi';

    protected $fillable = [
        'imunisasi',
        'jenis',
    ];

    public function balita()
    {
        return $this->hasMany(Balita::class, 'imunisasi_id');
    }
}
