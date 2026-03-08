<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSupply extends Model
{
    protected $table = 'stock_supplies';

    protected $fillable = ['nama', 'jumlah', 'harga', 'gambar'];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
    ];

    public function getGambarUrlAttribute(): ?string
    {
        if (empty($this->gambar)) {
            return null;
        }
        return asset('storage/' . $this->gambar);
    }
}
