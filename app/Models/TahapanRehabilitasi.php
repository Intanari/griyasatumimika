<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapanRehabilitasi extends Model
{
    protected $table = 'tahapan_rehabilitasi';

    protected $fillable = ['no_urut', 'status', 'judul', 'keterangan'];

    protected $casts = [
        'no_urut' => 'integer',
    ];
}
