<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JadwalPetugas extends Model
{
    use HasUuids;
    protected $table = 'jadwal_petugas';

    public const TIPE_RUTIN = 'rutin';
    public const TIPE_GANTI = 'ganti';

    protected $fillable = [
        'user_id',
        'shift_id',
        'tipe',
        'tanggal',
        'shift',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public const SHIFT_PAGI = 'pagi';
    public const SHIFT_SIANG = 'siang';
    public const SHIFT_MALAM = 'malam';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shiftModel()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function getShiftLabelAttribute(): string
    {
        return $this->shiftModel?->nama ?? match ($this->shift ?? '') {
            self::SHIFT_PAGI => 'Pagi',
            self::SHIFT_SIANG => 'Siang',
            self::SHIFT_MALAM => 'Malam',
            default => '-',
        };
    }

    public function getJamDisplayAttribute(): string
    {
        if ($this->shiftModel) {
            return \Carbon\Carbon::parse($this->shiftModel->jam_mulai)->format('H:i')
                . ' – '
                . \Carbon\Carbon::parse($this->shiftModel->jam_selesai)->format('H:i');
        }
        if ($this->jam_mulai) {
            return \Carbon\Carbon::parse($this->jam_mulai)->format('H:i')
                . ($this->jam_selesai ? ' – ' . \Carbon\Carbon::parse($this->jam_selesai)->format('H:i') : '');
        }
        return '-';
    }

    public function getHariAttribute(): string
    {
        return $this->tanggal?->translatedFormat('l') ?? '-';
    }
}
