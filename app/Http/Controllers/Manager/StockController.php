<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\StockService;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct(protected StockService $service) {}

    public function index()
    {
        $transactions = $this->service->getAll(15);
        $todayIn      = $this->service->getTodayIn();
        $todayOut     = $this->service->getTodayOut();
        return view('manager.stock.index', compact('transactions', 'todayIn', 'todayOut'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $type     = request('type', 'in');
        return view('manager.stock.create', compact('products', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'type'       => 'required|in:in,out',
            'note'       => 'nullable|string|max:255',
        ]);

        try {
            if ($validated['type'] === 'in') {
                $this->service->stockIn($validated);
                $message = 'Barang masuk berhasil dicatat.';
            } else {
                $this->service->stockOut($validated);
                $message = 'Barang keluar berhasil dicatat.';
            }
        } catch (\Exception $e) {
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }

        return redirect()->route('manager.stock.index')->with('success', $message);
    }

    public function show(int $id)
    {
        $transaction = $this->service->findById($id);
        return view('manager.stock.show', compact('transaction'));
    }
}