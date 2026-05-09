<?php

namespace App\Services;

use App\Repositories\StockTransactionRepository;
use App\Repositories\ProductRepository;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function __construct(
        protected StockTransactionRepository $transactionRepository,
        protected ProductRepository $productRepository
    ) {}

    public function getAll(int $perPage = 15)
    {
        return $this->transactionRepository->getAll($perPage);
    }

    public function getByType(string $type, int $perPage = 15)
    {
        return $this->transactionRepository->getByType($type, $perPage);
    }

    public function findById(int $id)
    {
        return $this->transactionRepository->findById($id);
    }

    public function stockIn(array $data): StockTransaction
    {
        return DB::transaction(function () use ($data) {
            $data['type']    = 'in';
            $data['user_id'] = auth()->id();

            $transaction = $this->transactionRepository->create($data);

            $product = $this->productRepository->findById($data['product_id']);
            $product->increment('stock', $data['quantity']);

            return $transaction;
        });
    }

    public function stockOut(array $data): StockTransaction
    {
        return DB::transaction(function () use ($data) {
            $product = $this->productRepository->findById($data['product_id']);

            if ($product->stock < $data['quantity']) {
                throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $product->stock . ' ' . $product->unit);
            }

            $data['type']    = 'out';
            $data['user_id'] = auth()->id();

            $transaction = $this->transactionRepository->create($data);

            $product->decrement('stock', $data['quantity']);

            return $transaction;
        });
    }

    public function getTodayIn(): int
    {
        return $this->transactionRepository->getTodayIn();
    }

    public function getTodayOut(): int
    {
        return $this->transactionRepository->getTodayOut();
    }
}