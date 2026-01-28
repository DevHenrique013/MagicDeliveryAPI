<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository{
    public function create(array $attributes):User;
    public function existsByEmail(string $email):bool;
    public function findById(string $id): User;
    public function findByEmail(string $id): User;
    public function listLatest(): Collection;
    public function findByIdForUpdate(string $id): User;
    public function save(User $user):void;
}