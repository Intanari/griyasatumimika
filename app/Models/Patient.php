<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'kode_pasien',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
    ];

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return match ($this->jenis_kelamin) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'dirujuk' => 'Dirujuk',
            default => $this->status,
        };
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }
        return \Illuminate\Support\Facades\Storage::url($this->foto);
    }

    public function examinationHistories()
    {
        return $this->hasMany(ExaminationHistory::class);
    }
}
