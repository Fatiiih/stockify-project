<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service) {}

    public function index()
    {
        $suppliers = $this->service->getAll(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:suppliers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $this->service->create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $supplier = $this->service->findById($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:suppliers,email,' . $id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diupdate.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}