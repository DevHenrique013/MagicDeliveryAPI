<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\User\LoginUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class AuthService
{
    public function __construct(private readonly UserRepository $users) {}
    
    public function login(LoginUserDTO $dto): array
    {
        $user = $this->users->findByEmail($dto->email);
        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $user->createToken($dto->deviceName ?? 'postman')->plainTextToken;


        return [
            'token' => $token,
            'user'  => $user,
        ];
    }

    public function logoutCurrentToken(User $user): void
    {
    
        $user->currentAccessToken()?->delete();
    }

    public function logoutAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
