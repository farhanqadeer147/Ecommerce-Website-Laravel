<?php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface OrderDetailRepositoryInterface
{
    public function getByOrderCode(string $orderCode): Collection;
}
