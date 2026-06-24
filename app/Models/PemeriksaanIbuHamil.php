<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanIbuHamil extends Model
{
    protected $table = 'pemeriksaan_ibuhamil';

    protected $fillable = [
        'ibuhamil_id',
        'hpht',
        'hpl',
        'berat',
        'pemeriksaan_darah',
        'tanggal_pemeriksaan',
    ];

    public function ibuhamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibuhamil_id');
    }
}
