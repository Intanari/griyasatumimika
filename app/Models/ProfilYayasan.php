<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilYayasan extends Model
{
    protected $table = 'profil_yayasan';

    protected $fillable = ['judul', 'keterangan'];
}
