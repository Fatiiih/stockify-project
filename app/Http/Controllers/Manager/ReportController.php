<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('manager.reports.index');
    }

    public function stock(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->whereColumn('stock', '<=', 'min_stock');
            } elseif ($request->stock_status === 'safe') {
                $query->whereColumn('stock', '>', 'min_stock');
            }
        }

        $products   = $query->orderBy('name')->get();
        $categories = Category::all();

        return view('manager.reports.stock', compact('products', 'categories'));
    }

    public function transactions(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $transactions = $query->latest('transaction_date')->paginate(20);
        $products     = Product::orderBy('name')->get();

        return view('manager.reports.transactions', compact('transactions', 'products'));
    }
    public function activity(Request $request)
{
    $query = \App\Models\User::query();

    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    $users = $query->withCount([
        'stockTransactions',
        'stockTransactions as transactions_in_count'  => fn($q) => $q->where('type', 'in'),
        'stockTransactions as transactions_out_count' => fn($q) => $q->where('type', 'out'),
    ])->get();

    $recentActivities = \App\Models\StockTransaction::with(['product', 'user'])
        ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
        ->when($request->filled('start_date'), fn($q) => $q->whereDate('transaction_date', '>=', $request->start_date))
        ->when($request->filled('end_date'), fn($q) => $q->whereDate('transaction_date', '<=', $request->end_date))
        ->latest('transaction_date')
        ->paginate(15);

    $allUsers = \App\Models\User::orderBy('name')->get();

    return view('manager.reports.activity', compact('users', 'recentActivities', 'allUsers'));
}
}