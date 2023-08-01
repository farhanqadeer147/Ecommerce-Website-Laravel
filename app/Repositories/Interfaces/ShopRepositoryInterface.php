<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\UploadedFile;
use App\Models\Shop;

interface ShopRepositoryInterface
{
    public function create(array $data, UploadedFile $path): Shop;

    public function findFirst(): ?Shop;

    public function update(array $data, ?UploadedFile $path): bool;
}
