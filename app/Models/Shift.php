<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['nama', 'jam_mulai', 'jam_selesai'];

    public function jadwalPetugas()
    {
        return $this->hasMany(JadwalPetugas::class);
    }

    public function getJamRangeAttribute(): string
    {
        return \Carbon\Carbon::parse($this->jam_mulai)->format('H:i')
            . ' – '
            . \Carbon\Carbon::parse($this->jam_selesai)->format('H:i');
    }
}
