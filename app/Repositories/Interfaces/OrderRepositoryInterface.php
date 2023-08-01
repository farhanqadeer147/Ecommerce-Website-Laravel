<?php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function all(): Collection;

    public function findByOrderCode(string $orderCode);

    public function updateStatus(string $orderCode, int $status);

    public function delete(string $orderCode);
}
