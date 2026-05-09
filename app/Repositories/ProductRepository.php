<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function __construct(protected Product $model) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with(['category', 'supplier'])
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): Product
    {
        return $this->model->with(['category', 'supplier'])->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->findById($id);
        return $product->delete();
    }

    public function getLowStock(): Collection
    {
        return $this->model
            ->whereColumn('stock', '<=', 'min_stock')
            ->with('category')
            ->get();
    }
}