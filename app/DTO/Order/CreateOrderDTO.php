<?php

declare(strict_types=1);

namespace  App\DTO\Order;

use InvalidArgumentException;

final readonly class CreateOrderDTO
{
    public function __construct(
        public string $userId,
        public string $idempotencyKey,
        public array $items
    ) {
        if ($this->userId === '') {
            throw new InvalidArgumentException('userID é necessário');
        }

        if ($this->idempotencyKey === '') {
            throw new InvalidArgumentException('idempotencyKey é necessário');
        }

        if (count($this->items) === 0) {
            throw new InvalidArgumentException('items não pode estar vazio');
        }
    }
}
