<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_balita';

    protected $fillable = [
        'balita_id',
        'berat',
        'tinggi',
        'imunisasi_id',
        'tanggal_pemeriksaan',
        'catatan'
    ];


    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }

    public function imunisasi()
    {
        return $this->belongsTo(Imunisasi::class, 'imunisasi_id');
    }
}
