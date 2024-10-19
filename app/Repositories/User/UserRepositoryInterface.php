<?php

namespace App\Repositories\User;

use App\Models\Product;
use App\Models\User;

interface UserRepositoryInterface
{
    public function find($id): ?User;
    public function findByEmail($email): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}