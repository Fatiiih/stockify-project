<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store(Request $request, int $productId)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'value' => 'required|string|max:255',
        ]);

        ProductAttribute::create([
            'product_id' => $productId,
            'name'       => $request->name,
            'value'      => $request->value,
        ]);

        return redirect()->route('admin.products.show', $productId)
            ->with('success', 'Atribut berhasil ditambahkan.');
    }

    public function destroy(int $productId, int $id)
    {
        ProductAttribute::where('product_id', $productId)
            ->findOrFail($id)
            ->delete();

        return redirect()->route('admin.products.show', $productId)
            ->with('success', 'Atribut berhasil dihapus.');
    }
}