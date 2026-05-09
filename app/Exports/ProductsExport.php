<?php

namespace App\Exports;

use App\Models\Product;

class ProductsExport
{
    public function download()
    {
        $filename = 'produk-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Header kolom
            fputcsv($file, [
                'Kode', 'Nama Produk', 'Kategori', 'Supplier',
                'Harga Beli', 'Harga Jual', 'Stok', 'Stok Minimum',
                'Satuan', 'Deskripsi'
            ]);

            // Data produk
            Product::with(['category', 'supplier'])->chunk(100, function ($products) use ($file) {
                foreach ($products as $product) {
                    fputcsv($file, [
                        $product->code,
                        $product->name,
                        $product->category->name ?? '-',
                        $product->supplier->name ?? '-',
                        $product->buy_price,
                        $product->sell_price,
                        $product->stock,
                        $product->min_stock,
                        $product->unit,
                        $product->description ?? '',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}