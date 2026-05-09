<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Laporan Stok Barang</h2>
            <div class="flex gap-2">
                <button onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors no-print">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print / PDF
                </button>
                <a href="{{ route('manager.reports.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 no-print">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        {{-- Filter --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 no-print">
            <form method="GET" action="{{ route('manager.reports.stock') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kategori</label>
                    <select name="category_id"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Status Stok</label>
                    <select name="stock_status"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                        <option value="">Semua</option>
                        <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Stok Menipis</option>
                        <option value="safe" {{ request('stock_status') === 'safe' ? 'selected' : '' }}>Stok Aman</option>
                    </select>
                </div>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                        style="background-color: #F97316;">
                    Filter
                </button>
                <a href="{{ route('manager.reports.stock') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Reset
                </a>
            </form>
        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-3 gap-4 mb-5">
            <div class="bg-white rounded-2xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 mb-1">Total Produk</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $products->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 mb-1">Stok Menipis</p>
                <p class="text-2xl font-semibold text-red-600">{{ $products->filter(fn($p) => $p->stock <= $p->min_stock)->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 mb-1">Stok Aman</p>
                <p class="text-2xl font-semibold text-green-600">{{ $products->filter(fn($p) => $p->stock > $p->min_stock)->count() }}</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Min. Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $product->code }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $product->supplier->name ?? '-' }}</td>
                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $product->stock }} {{ $product->unit }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $product->min_stock }} {{ $product->unit }}</td>
                        <td class="px-6 py-3">
                            @if($product->stock <= $product->min_stock)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Menipis
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Aman
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
    @media print {
        aside, header, .no-print { display: none !important; }
        .ml-64 { margin-left: 0 !important; }
        body { background: white !important; }
        .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
        @page { margin: 1cm; size: A4 landscape; }
    }
    </style>
</x-app-layout>