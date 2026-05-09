<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;

class ProductsImport
{
    public function import(string $path): array
    {
        $file    = fopen($path, 'r');
        $header  = fgetcsv($file);
        $success = 0;
        $errors  = [];

        while (($row = fgetcsv($file)) !== false) {
            try {
                if (count($row) < 2) continue;

                $data = array_combine($header, $row);

                $category = Category::firstOrCreate(
                    ['name' => $data['Kategori'] ?? 'Umum'],
                    ['slug' => Str::slug($data['Kategori'] ?? 'umum')]
                );

                $supplier = Supplier::firstOrCreate(
                    ['name' => $data['Supplier'] ?? 'Umum']
                );

                Product::updateOrCreate(
                    ['code' => $data['Kode'] ?? 'PRD-' . strtoupper(Str::random(6))],
                    [
                        'name'        => $data['Nama Produk'] ?? '',
                        'category_id' => $category->id,
                        'supplier_id' => $supplier->id,
                        'buy_price'   => $data['Harga Beli'] ?? 0,
                        'sell_price'  => $data['Harga Jual'] ?? 0,
                        'stock'       => $data['Stok'] ?? 0,
                        'min_stock'   => $data['Stok Minimum'] ?? 0,
                        'unit'        => $data['Satuan'] ?? 'pcs',
                        'description' => $data['Deskripsi'] ?? null,
                    ]
                );

                $success++;
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        fclose($file);

        return compact('success', 'errors');
    }
}