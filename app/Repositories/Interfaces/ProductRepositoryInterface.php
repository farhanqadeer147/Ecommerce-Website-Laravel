<?php
namespace App\Repositories\Interfaces;
use App\Models\Product;
use Illuminate\Http\UploadedFile;


interface ProductRepositoryInterface
{
    // public function findByTitle(string $title);

    public function updateStock(string $title, int $quantity);
    public function all();

    public function create(array $data);

    public function findByTitle(string $title): ?Product;


    public function update(array $data, int $id);

    public function delete(int $id);
}

