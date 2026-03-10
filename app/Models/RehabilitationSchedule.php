<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RehabilitationSchedule extends Model
{
    use HasUuids;
    protected $table = 'rehabilitation_schedules';

    protected $fillable = [
        'nama_kegiatan',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'pembimbing_id',
        'deskripsi',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public const HARI_LIST = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    public function pembimbingUser()
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function getHariLabelAttribute(): string
    {
        return self::HARI_LIST[$this->hari] ?? ucfirst($this->hari);
    }
}
