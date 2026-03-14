<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasUuids;
    protected $fillable = [
        'kode_pasien',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
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

    public function schedules()
    {
        return $this->hasMany(PatientSchedule::class);
    }

    public function activities()
    {
        return $this->hasMany(PatientActivity::class);
    }
}

