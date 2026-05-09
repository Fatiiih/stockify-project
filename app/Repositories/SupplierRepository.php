<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository
{
    public function __construct(protected Supplier $model) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->withCount('products')->latest()->paginate($perPage);
    }

    public function findById(int $id): Supplier
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Supplier
    {
        $supplier = $this->findById($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id): bool
    {
        return $this->findById($id)->delete();
    }
}