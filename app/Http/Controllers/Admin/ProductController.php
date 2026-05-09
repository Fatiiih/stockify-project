<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {}

    public function index()
    {
        $products = $this->service->getAll(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers   = Supplier::all();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|unique:products,code',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'buy_price'   => 'required|numeric|min:0',
            'sell_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048',
        ]);

        $this->service->create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $product = $this->service->findById($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit(int $id)
    {
        $product    = $this->service->findById($id);
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|unique:products,code,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'buy_price'   => 'required|numeric|min:0',
            'sell_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function export()
    {
        return (new ProductsExport)->download();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv|max:2048',
        ]);

        try {
            $path   = $request->file('file')->getRealPath();
            $result = (new ProductsImport)->import($path);

            $message = $result['success'] . ' produk berhasil diimport.';

            if (!empty($result['errors'])) {
                $message .= ' ' . count($result['errors']) . ' baris gagal.';
            }

            return redirect()->route('admin.products.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}