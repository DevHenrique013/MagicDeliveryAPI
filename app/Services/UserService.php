<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\BalanceChangeDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\UserRepository;

final class UserService
{
    public function __construct(private readonly UserRepository $users) {}

    public function create(CreateUserDTO $dto): User
    {
        $exists = $this->users->existsByEmail($dto->email);
        if ($exists) {
            throw ValidationException::withMessages([
                'email' => ['Este e-mail já está em uso.'],
            ]);
        }

        $user = $this->users->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'balance' => $dto->balance ?? 0,
        ]);
        return $user;
    }

    public function findOrFail(string $id): User
    {
        /** @var User $user */
        $user = $this->users->findById($id);
        return $user;
    }

    /**
     * Listagem simples (se for só pra admin, proteja a rota)
     * @return Collection<int, User>
     */
    public function list(): Collection
    {
        return $this->users->listLatest();
    }

    public function applyBalanceChange(BalanceChangeDTO $dto): User
    {
        return DB::transaction(function () use ($dto): User {
            $user = $this->users->findByIdForUpdate($dto->userId);

            $current = (int)($user->balance ?? 0);

            if ($dto->type === 'increase') {
                $user->balance = $current + $dto->amount;
                $this->users->save($user);
                return $user;
            }

            if ($current < $dto->amount) {
                throw ValidationException::withMessages([
                    'balance' => ['Saldo insuficiente.'],
                ]);
            }

            $user->balance = $current - $dto->amount;
            $this->users->save($user);
            return $user;
        });
    }
}
