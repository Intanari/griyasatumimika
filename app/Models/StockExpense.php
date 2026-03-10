<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StockExpense extends Model
{
    use HasUuids;
    protected $table = 'stock_expenses';

    protected $fillable = ['nama', 'jumlah', 'gambar'];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    public function getGambarUrlAttribute(): ?string
    {
        if (empty($this->gambar)) {
            return null;
        }
        return asset('storage/' . $this->gambar);
    }
}
