<?php

namespace App\Services;

use App\Repositories\SupplierRepository;
use App\Models\Supplier;

class SupplierService
{
    public function __construct(protected SupplierRepository $repository) {}

    public function getAll(int $perPage = 10)
    {
        return $this->repository->getAll($perPage);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): Supplier
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Supplier
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}