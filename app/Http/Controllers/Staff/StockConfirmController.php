<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;


class StockConfirmController extends Controller
{
    public function index()
    {
        $incoming = StockTransaction::with(['product', 'user'])
            ->where('type', 'in')
            ->where('status', 'pending')
            ->latest('transaction_date')
            ->paginate(10, ['*'], 'incoming');

        $outgoing = StockTransaction::with(['product', 'user'])
            ->where('type', 'out')
            ->where('status', 'pending')
            ->latest('transaction_date')
            ->paginate(10, ['*'], 'outgoing');

        return view('staff.confirm.index', compact('incoming', 'outgoing'));
    }

    public function confirm(int $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        if ($transaction->status === 'confirmed') {
            return back()->with('error', 'Transaksi ini sudah dikonfirmasi.');
        }

        $transaction->update([
            'status'       => 'confirmed',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        $type = $transaction->type === 'in' ? 'Barang masuk' : 'Barang keluar';

        return back()->with('success', $type . ' berhasil dikonfirmasi.');
    }
}