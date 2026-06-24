<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'nama',
        'komentar',
        'balasan_admin',
        'dibalas_pada',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'dibalas_pada' => 'datetime',
    ];
}
