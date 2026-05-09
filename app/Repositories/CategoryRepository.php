<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository
{
    public function __construct(protected Category $model) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->withCount('products')->latest()->paginate($perPage);
    }

    public function findById(int $id): Category
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): bool
    {
        return $this->findById($id)->delete();
    }
}