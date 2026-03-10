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
        'message',
        'order_id',
        'transaction_id',
        'qr_code_url',
        'qr_string',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'integer',
        'paid_at' => 'datetime',
    ];

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
