<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(protected ProductRepository $repository) {}

    public function getAll(int $perPage = 10)
    {
        return $this->repository->getAll($perPage);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): Product
    {
        $data['code'] = $data['code'] ?? 'PRD-' . strtoupper(Str::random(6));
        $data['image'] = $this->uploadImage($data['image'] ?? null);

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->repository->findById($id);

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        } else {
            unset($data['image']);
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $product = $this->repository->findById($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->repository->delete($id);
    }

    public function getLowStock()
    {
        return $this->repository->getLowStock();
    }

    private function uploadImage(?UploadedFile $file): ?string
    {
        if (!$file) return null;
        return $file->store('products', 'public');
    }
}