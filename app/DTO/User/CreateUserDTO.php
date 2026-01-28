<?php

declare(strict_types=1);

namespace App\DTO\User;

use InvalidArgumentException;

final readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $balance,
    ) {
        if ($this->name === '' || $this->email === '' || $this->password === '') {
            throw new InvalidArgumentException('name, email and password are required');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string)($data['name'] ?? ''),
            email: (string)($data['email'] ?? ''),
            password: (string)($data['password'] ?? ''),
            balance: (int)($data['balance'] ?? '')
        );
    }
}
