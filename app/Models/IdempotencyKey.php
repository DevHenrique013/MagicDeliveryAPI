<?php

namespace App\Models;

use App\Enums\IdempotencyStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdempotencyKey extends Model
{
    use HasFactory;

    protected $table = 'idempotency_keys';

    protected $fillable = [
        'idempotency_key',
        'method',
        'request_endpoint',
        'request_hash',
        'response_body',
        'response_status_code',
        'status',
        'locked_until',
        'expires_at',
        'user_id',
    ];

    protected $casts = [
        'response_body' => 'array',
        'response_status_code' => 'integer',
        'locked_until' => 'datetime',
        'expires_at' => 'datetime',
        'status' => IdempotencyStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function isLocked(): bool
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
