<?php

namespace App\Services;

use App\Repositories\StockOpnameRepository;
use App\Repositories\ProductRepository;
use App\Models\StockOpname;
use Illuminate\Support\Facades\DB;

class StockOpnameService
{
    public function __construct(
        protected StockOpnameRepository $opnameRepository,
        protected ProductRepository $productRepository
    ) {}

    public function getAll(int $perPage = 15)
    {
        return $this->opnameRepository->getAll($perPage);
    }

    public function findById(int $id)
    {
        return $this->opnameRepository->findById($id);
    }

    public function create(array $data): StockOpname
    {
        return DB::transaction(function () use ($data) {
            $product = $this->productRepository->findById($data['product_id']);

            $data['user_id']       = auth()->id();
            $data['system_stock']  = $product->stock;
            $data['difference']    = $data['physical_stock'] - $product->stock;

            $opname = $this->opnameRepository->create($data);

            // Update stok produk sesuai stok fisik
            $product->update(['stock' => $data['physical_stock']]);

            return $opname;
        });
    }
}