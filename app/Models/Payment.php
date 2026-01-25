<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'amount',
        'attempt_number',
        'status',
        'idempotency_key',
        'fk_order',
    ];

    protected $casts = [
        'amount' => 'integer',
        'attempt_number' => 'integer',
        'status' => PaymentStatusEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'fk_order');
    }
}
