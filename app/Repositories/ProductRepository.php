<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function findByTitle(string $title): ?Product
    {
        return Product::where('title', $title)->first();
    }

    public function all()
    {
        return Product::orderByDesc('id')->get();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, int $id)
    {
        return Product::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }

    public function updateStock(string $title, int $quantity)
    {
        $product = Product::where('title', $title)->first();
        $updatedStock = $product->stock + $quantity;
        $product->update(['stock' => $updatedStock]);

        return $product;
    }
}
