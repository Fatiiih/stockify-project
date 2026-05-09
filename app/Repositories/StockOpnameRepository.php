<?php

namespace App\Repositories;

use App\Models\StockOpname;
use Illuminate\Pagination\LengthAwarePaginator;

class StockOpnameRepository
{
    public function __construct(protected StockOpname $model) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['product', 'user'])
            ->latest('opname_date')
            ->paginate($perPage);
    }

    public function findById(int $id): StockOpname
    {
        return $this->model->with(['product', 'user'])->findOrFail($id);
    }

    public function create(array $data): StockOpname
    {
        return $this->model->create($data);
    }
}