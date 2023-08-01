<?php
namespace App\Repositories;

use App\Models\ProductVariant;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface;

class ProductVariantRepository implements ProductVariantRepositoryInterface
{
    public function create(array $data)
    {
        return ProductVariant::create($data);
    }

    public function update(array $data, int $id)
    {
        return ProductVariant::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return ProductVariant::destroy($id);
    }
    
}
