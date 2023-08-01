<?php
namespace App\Repositories\Interfaces;

use App\Models\ProductImage;

interface ProductImageRepositoryInterface
{
    public function getByProductId(int $productId);

    public function create(array $data);

    public function delete(int $id);
}
