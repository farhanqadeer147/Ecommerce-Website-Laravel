<?php
namespace App\Repositories;

use App\Models\OrderDetail;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use Illuminate\Support\Collection;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    public function getByOrderCode(string $orderCode): Collection
    {
        return OrderDetail::where('order_code', $orderCode)->get();
    }
}
