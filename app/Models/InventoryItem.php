<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory, HasUuids;

    public const CATEGORY_MAKANAN = 'makanan';
    public const CATEGORY_OBAT = 'obat';
    public const CATEGORY_ALAT_KESEHATAN = 'alat_kesehatan';
    public const CATEGORY_PERLENGKAPAN = 'perlengkapan';
    public const CATEGORY_KEBERSIHAN = 'kebersihan';
    public const CATEGORY_LAINNYA = 'lainnya';

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'min_stock',
        'date_in',
        'expiry_date',
        'supplier',
        'unit_price',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_in' => 'date',
            'expiry_date' => 'date',
            'unit_price' => 'decimal:2',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class, 'inventory_item_id');
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_MAKANAN => 'Makanan',
            self::CATEGORY_OBAT => 'Obat',
            self::CATEGORY_ALAT_KESEHATAN => 'Alat Kesehatan',
            self::CATEGORY_PERLENGKAPAN => 'Perlengkapan',
            self::CATEGORY_KEBERSIHAN => 'Alat Kebersihan',
            self::CATEGORY_LAINNYA => 'Lainnya',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::categories()[$this->category] ?? $this->category;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return 'habis';
        }
        if ($this->quantity <= $this->min_stock) {
            return 'low';
        }
        return 'aman';
    }

    public function getTotalValueAttribute(): ?float
    {
        if ($this->unit_price === null) {
            return null;
        }
        return (float) $this->unit_price * $this->quantity;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expiry_date && $this->expiry_date->isFuture() && $this->expiry_date->diffInDays(now()) <= $days;
    }
}
