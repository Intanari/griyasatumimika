<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DonationExpense extends Model
{
    use HasUuids;
    protected $table = 'donation_expenses';

    protected $fillable = [
        'keterangan',
        'jumlah',
        'bukti_path',
        'tanggal_pengeluaran',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_pengeluaran' => 'date',
    ];

    public function getFormattedJumlahAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getBuktiUrlAttribute(): ?string
    {
        if (empty($this->bukti_path)) {
            return null;
        }
        return asset('storage/' . $this->bukti_path);
    }
}
