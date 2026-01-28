<?php
declare(strict_types = 1);

namespace App\Repositories\Implementations;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UserRepository;

final class EloquentUserRepository implements UserRepository{
    public function create(array $attributes):User{
        $user = User::query()->create($attributes);
        return $user;
    }
    public function existsByEmail(string $email): bool{
        return $user = User::query()->where('email',$email)->exists();
    }
    public function findById(string $id): User{
        $user = User::query()->findOrFail($id);
        return $user;
    }
    public function findByEmail(string $email): User{
        $user = User::query()->where('email',$email)->first();
        return $user;
    }
    public function listLatest(): Collection{
        return User::query()->orderByDesc('created_at')->get();
    }
    public function findByIdForUpdate(string $id): User{
        $user = User::query()->lockForUpdate()->findOrFail($id);
        return $user;
    }
    public function save(User $user):void{
        $user->save();
    }
}