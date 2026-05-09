<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(protected CategoryRepository $repository) {}

    public function getAll(int $perPage = 10)
    {
        return $this->repository->getAll($perPage);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): \App\Models\Category
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): \App\Models\Category
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}