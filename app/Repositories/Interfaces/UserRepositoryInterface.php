<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function updatePassword(int $userId, string $password): bool;
}
