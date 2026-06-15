<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasUuids;
    protected $fillable = [
        'program',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'total_amount',
        'message',
        'order_id',
        'transaction_id',
        'payment_gateway',
        'qr_code_url',
        'qr_string',
        'status',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'amount'       => 'integer',
        'total_amount' => 'integer',
        'paid_at'      => 'datetime',
        'expired_at'   => 'datetime',
    ];

    public function getPayableAmountAttribute(): int
    {
        return $this->total_amount ?? $this->amount;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->payable_amount, 0, ',', '.');
    }
}
