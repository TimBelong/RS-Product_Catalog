<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): Collection|array;

    public function find($id): Collection|array|null|Model;

    public function create($attributes): Model;

    public function update($id, array $attributes): bool|null;

    public function delete($id): ?bool;
}