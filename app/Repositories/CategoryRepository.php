<?php
namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::orderByDesc('id')->get();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function create($data)
    {
        return Category::create($data);
    }

    public function check($name)
    {
        return Category::where('name', $name)->exists();
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return false;
        }

        $category->delete();

        return true;
    }
}


