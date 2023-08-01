<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;
    private $orderDetailRepository;
    private $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $data = [
            'orders' => $this->orderRepository->all(),
            'title' => 'Orders'
        ];

        return view('admin.order.index', $data);
    }

    public function detail($orderCode)
    {
        $data = [
            'order' => $this->orderRepository->findByOrderCode($orderCode),
            'orderDetail' => $this->orderDetailRepository->getByOrderCode($orderCode),
            'title' => 'Order Detail - ' . $orderCode
        ];

        return view('admin.order.detail', $data);
    }

    public function updateStatus(Request $request, $orderCode)
    {
        $status = $request->status;

        if ($status == 5) {
            $orderDetail = $this->orderDetailRepository->getByOrderCode($orderCode);

            foreach ($orderDetail as $item) {
                $product = $this->productRepository->findByTitle($item->title);
                $this->productRepository->updateStock($item->title, $item->quantity);
            }
        } else {
            $currentStatus = $this->orderRepository->findByOrderCode($orderCode)->status;

            if ($currentStatus == 5) {
                $orderDetail = $this->orderDetailRepository->getByOrderCode($orderCode);

                foreach ($orderDetail as $item) {
                    $product = $this->productRepository->findByTitle($item->title);
                    $this->productRepository->updateStock($item->title, -$item->quantity);
                }
            }
        }

        $this->orderRepository->updateStatus($orderCode, $status);

        return redirect()->route('orderDetail', $orderCode)->with('success', 'Order Status Changed');
    }

    public function delete($orderCode)
    {
        $this->orderRepository->delete($orderCode);
        $this->orderDetailRepository->delete($orderCode);

        return redirect()->route('orders')->with('success', 'Order Deleted');
    }
}

