<?php

namespace App\Repositories;

use App\Models\StockTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

class StockTransactionRepository
{
    public function __construct(protected StockTransaction $model) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['product', 'user'])
            ->latest('transaction_date')
            ->paginate($perPage);
    }

    public function getByType(string $type, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['product', 'user'])
            ->where('type', $type)
            ->latest('transaction_date')
            ->paginate($perPage);
    }

    public function findById(int $id): StockTransaction
    {
        return $this->model->with(['product', 'user'])->findOrFail($id);
    }

    public function create(array $data): StockTransaction
    {
        return $this->model->create($data);
    }

    public function getTodayIn(): int
    {
        return $this->model
            ->where('type', 'in')
            ->whereDate('transaction_date', today())
            ->sum('quantity');
    }

    public function getTodayOut(): int
    {
        return $this->model
            ->where('type', 'out')
            ->whereDate('transaction_date', today())
            ->sum('quantity');
    }
}