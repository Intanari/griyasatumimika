<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OdgjReport extends Model
{
    protected $fillable = [
        'kategori',
        'lokasi',
        'lokasi_lat',
        'lokasi_lng',
        'deskripsi',
        'gambar',
        'email',
        'kontak',
        'status',
        'nomor_laporan',
    ];

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'penjemputan' => 'Penjemputan ODGJ',
            'pengantaran' => 'Pengantaran ODGJ',
            default => $this->kategori,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }
}
