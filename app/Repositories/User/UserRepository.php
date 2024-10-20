<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function all($paginate = null)
    {
        if ($paginate) {
            return User::paginate($paginate);
        }
        return User::all();
    }

    public function find($id): ?User
    {
        return User::find($id);
    }

    public function findByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}