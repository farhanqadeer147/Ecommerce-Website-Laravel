<?php
namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();

    public function find($id);

    public function create($data);

    public function check($name);

    public function delete($id);
}
