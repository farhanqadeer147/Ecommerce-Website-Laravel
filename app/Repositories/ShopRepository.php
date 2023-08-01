<?php

namespace App\Repositories;

use App\Models\Shop;
use Illuminate\Http\UploadedFile;
use App\Repositories\Interfaces\ShopRepositoryInterface;

class ShopRepository implements ShopRepositoryInterface
{
    public function create(array $data, UploadedFile $path): Shop
    {
        $full_name_path = $data['email'] . "-" . Str::random(20) . "." . $path->getClientOriginalExtension();
        $path->move(public_path('shop'), $full_name_path);

        return Shop::create([
            'user_id' => $data['user_id'],
            'name_shop' => $data['name_shop'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'desc' => $data['desc'],
            'path' => $full_name_path,
        ]);
    }

    public function findFirst(): ?Shop
    {
        return Shop::first();
    }

    public function update(array $data, ?UploadedFile $path): bool
    {
        if ($path) {
            $full_name_path = $data['email'] . "-" . Str::random(20) . "." . $path->getClientOriginalExtension();
            $path->move(public_path('shop'), $full_name_path);

            $paths = public_path() . '/shop/' . $data['old_path'];
            if (file_exists($paths)) {
                unlink($paths);
            }

            return Shop::where('id', $data['shop_id'])->update([
                'name_shop' => $data['name_shop'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'desc' => $data['desc'],
                'path' => $full_name_path,
            ]);
        } else {
            return Shop::where('id', $data['shop_id'])->update([
                'name_shop' => $data['name_shop'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'desc' => $data['desc'],
            ]);
        }
    }
}
