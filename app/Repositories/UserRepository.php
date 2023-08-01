<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function updatePassword(int $userId, string $password): bool
    {
        return User::where('id', $userId)->update([
            'password' => Hash::make($password),
        ]);
    }
}
