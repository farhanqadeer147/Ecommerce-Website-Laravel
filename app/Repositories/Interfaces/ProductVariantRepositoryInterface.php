<?php
namespace App\Repositories\Interfaces;

use App\Models\ProductVariant;

interface ProductVariantRepositoryInterface
{
    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);
}
