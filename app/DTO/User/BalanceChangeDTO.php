<?php

declare(strict_types=1);

namespace App\DTO\User;

use InvalidArgumentException;

final readonly class BalanceChangeDTO
{
    public function __construct(
        public string $userId,
        public int $amount,     // sempre positivo; o tipo define inc/dec
        public string $type,    // increase|decrease
        public ?string $reason = null,
        public ?string $referenceId = null,
    ) {
        if ($this->userId === '') {
            throw new InvalidArgumentException('userId is required');
        }
        if ($this->amount <= 0) {
            throw new InvalidArgumentException('amount must be > 0');
        }
        if (!in_array($this->type, ['increase', 'decrease'], true)) {
            throw new InvalidArgumentException('type must be increase or decrease');
        }
    }

    public static function increase(string $userId, int $amount, ?string $reason = null, ?string $referenceId = null): self
    {
        return new self($userId, $amount, 'increase', $reason, $referenceId);
    }

    public static function decrease(string $userId, int $amount, ?string $reason = null, ?string $referenceId = null): self
    {
        return new self($userId, $amount, 'decrease', $reason, $referenceId);
    }
}
