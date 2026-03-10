<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manajer';
    public const ROLE_PETUGAS = 'petugas_rehabilitasi';

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_CUTI = 'cuti';
    public const STATUS_NONAKTIF = 'nonaktif';

    public const SHIFT_PAGI = 'pagi';
    public const SHIFT_SIANG = 'siang';
    public const SHIFT_MALAM = 'malam';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'nip',
        'jabatan',
        'no_hp',
        'is_active',
        'foto',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'tanggal_bergabung',
        'status_kerja',
        'shift_jaga',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'tanggal_lahir'     => 'date',
            'tanggal_bergabung' => 'date',
        ];
    }

    public function scopePetugasYayasan(Builder $query): Builder
    {
        return $query->whereIn('role', [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_PETUGAS]);
    }

    public function isPetugasRehabilitasi(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function getStatusKerjaLabelAttribute(): string
    {
        return match ($this->status_kerja ?? '') {
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_CUTI => 'Cuti',
            self::STATUS_NONAKTIF => 'Nonaktif',
            default => '-',
        };
    }

    public function getShiftJagaLabelAttribute(): string
    {
        return match ($this->shift_jaga ?? '') {
            self::SHIFT_PAGI => 'Pagi',
            self::SHIFT_SIANG => 'Siang',
            self::SHIFT_MALAM => 'Malam',
            default => '-',
        };
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return match ($this->jenis_kelamin ?? '') {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MANAGER => 'Manajer',
            self::ROLE_PETUGAS => 'Petugas',
            default => 'Petugas',
        };
    }

    public function getFotoUrlAttribute(): bool|string
    {
        if (empty($this->foto)) {
            return false;
        }
        return asset('storage/' . $this->foto);
    }

    public function jadwalPetugas()
    {
        return $this->hasMany(JadwalPetugas::class);
    }

    public function jadwalLibur()
    {
        return $this->hasMany(JadwalLibur::class);
    }
}
