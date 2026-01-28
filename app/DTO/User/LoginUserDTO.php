<?php

declare(strict_types=1);

namespace App\DTO\User;

use InvalidArgumentException;

final readonly class LoginUserDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {
        if ($this->email === '' || $this->password === '') {
            throw new InvalidArgumentException('email and password are required');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: (string)($data['email'] ?? ''),
            password: (string)($data['password'] ?? ''),
        );
    }
}
