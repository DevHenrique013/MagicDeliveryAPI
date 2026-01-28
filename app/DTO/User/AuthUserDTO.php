<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Models\User;

final readonly class AuthUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public int $balance,
        public string $createdAt,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: (string)$user->id,
            name: (string)$user->name,
            email: (string)$user->email,
            balance: (int)($user->balance ?? 0),
            createdAt: (string)$user->created_at?->toISOString(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'balance' => $this->balance,
            'createdAt' => $this->createdAt,
        ];
    }
}
