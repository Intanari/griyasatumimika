<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesLaporanOdgj extends Model
{
    protected $table = 'proses_laporan_odgj';

    protected $fillable = ['no_urut', 'judul', 'keterangan'];

    protected $casts = [
        'no_urut' => 'integer',
    ];
}
