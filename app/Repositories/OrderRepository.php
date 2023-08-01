<?php
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function all(): Collection
    {
        return Order::orderByDesc('id')->get();
    }

    public function findByOrderCode(string $orderCode)
    {
        return Order::where('order_code', $orderCode)->first();
    }

    public function updateStatus(string $orderCode, int $status)
    {
        $order = Order::where('order_code', $orderCode)->first();
        $order->update(['status' => $status]);

        return $order;
    }

    public function delete(string $orderCode)
    {
        Order::where('order_code', $orderCode)->delete();
    }

}
