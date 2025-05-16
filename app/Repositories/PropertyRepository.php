<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PropertyRepository implements RepositoryInterface
{
    public function all(): Collection|array
    {
        return Property::all();
    }

    public function find($id): Model|Collection|Property|array|null
    {
        return Property::find($id);
    }

    public function create($attributes): Model|Property
    {
        return Property::create($attributes);
    }

    public function update($id, array $attributes): bool|null
    {
        return Property::find($id)->update($attributes);
    }

    public function delete($id): ?bool
    {
        return Property::find($id)->delete();
    }

    public function findByName(string $name): ?Property
    {
        return Property::where('name', $name)->first();
    }
}