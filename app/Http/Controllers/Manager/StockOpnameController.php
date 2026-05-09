<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\StockOpnameService;
use App\Models\Product;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function __construct(protected StockOpnameService $service) {}

    public function index()
    {
        $opnames = $this->service->getAll(15);
        return view('manager.opname.index', compact('opnames'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('manager.opname.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'     => 'required|exists:products,id',
            'physical_stock' => 'required|integer|min:0',
            'note'           => 'nullable|string|max:255',
        ]);

        $this->service->create($validated);

        return redirect()->route('manager.opname.index')
            ->with('success', 'Stock opname berhasil dicatat dan stok telah diperbarui.');
    }

    public function show(int $id)
    {
        $opname = $this->service->findById($id);
        return view('manager.opname.show', compact('opname'));
    }
}