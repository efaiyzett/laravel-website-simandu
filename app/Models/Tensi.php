<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tensi extends Model
{
    protected $table = 'tensi';

    public $timestamps = false;

    protected $fillable = [
        'ibuhamil_id',
        'tensi',
        'tanggal_periksa',
    ];

    public function ibuhamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibuhamil_id');
    }
}
