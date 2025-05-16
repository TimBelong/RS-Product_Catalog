<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements RepositoryInterface
{
    public function all(): Collection|array
    {
        return Product::all();
    }

    public function find($id): Model|Collection|Product|array|null
    {
        return Product::find($id);
    }

    public function create($attributes): Model|Product
    {
        return Product::create($attributes);
    }

    public function update($id, array $attributes): bool|null
    {
        return Product::find($id)->update($attributes);
    }

    public function delete($id): ?bool
    {
        return Product::find($id)->delete();
    }
}