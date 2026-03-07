<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLibur extends Model
{
    protected $table = 'jadwal_libur';

    protected $fillable = ['user_id', 'tanggal', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
