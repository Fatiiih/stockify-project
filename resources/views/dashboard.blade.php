@php
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockTransaction;
use App\Models\User;
@endphp

<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Dashboard
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <div class="text-sm text-gray-400">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">

        @php
            $role = auth()->user()->role;
        @endphp

        {{-- ================= ADMIN ================= --}}
        @if($role === 'admin')

            {{-- CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                {{-- TOTAL PRODUK --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Total Produk</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ Product::count() }}</h2>
                </div>

                {{-- TOTAL KATEGORI --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Total Kategori</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ Category::count() }}</h2>
                </div>

                {{-- TOTAL SUPPLIER --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Total Supplier</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ Supplier::count() }}</h2>
                </div>

                {{-- STOK MENIPIS --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Stok Menipis</p>
                    <h2 class="text-3xl font-bold text-red-500">
                        {{ Product::whereColumn('stock', '<=', 'min_stock')->count() }}
                    </h2>
                </div>

            </div>

            {{-- DATA CHART --}}
            @php
                $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i));

                $labels = $days->map(fn($d) => $d->format('d M'))->toArray();

                $dataIn = $days->map(fn($d) => StockTransaction::where('type', 'in')
                    ->whereDate('transaction_date', $d)->sum('quantity'))->toArray();

                $dataOut = $days->map(fn($d) => StockTransaction::where('type', 'out')
                    ->whereDate('transaction_date', $d)->sum('quantity'))->toArray();

                $categoryStocks = Category::withSum('products', 'stock')->get();
                $catLabels = $categoryStocks->pluck('name')->toArray();
                $catData = $categoryStocks->pluck('products_sum_stock')->toArray();
            @endphp

            {{-- CHART --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

                {{-- TRANSACTION CHART --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-semibold text-gray-700">Transaksi 7 Hari Terakhir</h3>
                    </div>
                    <div class="relative h-64">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>

                {{-- CATEGORY CHART --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-semibold text-gray-700">Stok Per Kategori</h3>
                    </div>
                    <div class="relative h-64">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

            </div>

            {{-- STOK MENIPIS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">

                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Produk Stok Menipis</h3>
                </div>

                @php
                    $lowStocks = Product::whereColumn('stock', '<=', 'min_stock')
                        ->with('category')->take(5)->get();
                @endphp

                @forelse($lowStocks as $product)
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-400">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <div class="text-red-500 font-semibold">
                            {{ $product->stock }} {{ $product->unit }}
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-gray-400 text-sm">Semua stok aman</div>
                @endforelse

            </div>

            {{-- TRANSAKSI TERBARU --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Transaksi Terbaru</h3>
                </div>

                @php
                    $recentTransactions = StockTransaction::with(['product', 'user'])
                        ->latest('transaction_date')->take(5)->get();
                @endphp

                @forelse($recentTransactions as $trx)
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $trx->product->name ?? '-' }}</h4>
                            <p class="text-sm text-gray-400">Oleh {{ $trx->user->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            @if($trx->type === 'in')
                                <div class="text-green-500 font-semibold">+{{ $trx->quantity }}</div>
                            @else
                                <div class="text-red-500 font-semibold">-{{ $trx->quantity }}</div>
                            @endif
                            <p class="text-xs text-gray-400">{{ $trx->transaction_date->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-gray-400 text-sm">Belum ada transaksi</div>
                @endforelse

            </div>

            {{-- CHART JS --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const transactionChart = document.getElementById('transactionChart');
                new window.Chart(transactionChart, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($labels) !!},
                        datasets: [
                            {
                                label: 'Barang Masuk',
                                data: {!! json_encode($dataIn) !!},
                                borderColor: '#22c55e',
                                backgroundColor: 'rgba(34,197,94,0.1)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Barang Keluar',
                                data: {!! json_encode($dataOut) !!},
                                borderColor: '#F97316',
                                backgroundColor: 'rgba(249,115,22,0.1)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                const categoryChart = document.getElementById('categoryChart');
                new window.Chart(categoryChart, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($catLabels) !!},
                        datasets: [
                            {
                                data: {!! json_encode($catData) !!},
                                backgroundColor: [
                                    '#F97316',
                                    '#22c55e',
                                    '#3b82f6',
                                    '#a855f7',
                                    '#ef4444',
                                    '#14b8a6'
                                ]
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>

        @endif

        {{-- ================= MANAJER GUDANG ================= --}}
        @if($role === 'manajer_gudang')

            @php
                $todayIn  = StockTransaction::where('type', 'in')
                    ->whereDate('transaction_date', today())->sum('quantity');

                $todayOut = StockTransaction::where('type', 'out')
                    ->whereDate('transaction_date', today())->sum('quantity');

                $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

                $totalProducts = Product::count();

                // Chart data 7 hari
                $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i));
                $mgrLabels  = $days->map(fn($d) => $d->format('d M'))->toArray();
                $mgrDataIn  = $days->map(fn($d) => StockTransaction::where('type', 'in')
                    ->whereDate('transaction_date', $d)->sum('quantity'))->toArray();
                $mgrDataOut = $days->map(fn($d) => StockTransaction::where('type', 'out')
                    ->whereDate('transaction_date', $d)->sum('quantity'))->toArray();
            @endphp

            {{-- CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                {{-- STOK MENIPIS --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Stok Menipis</p>
                    <h2 class="text-3xl font-bold text-red-500">{{ $lowStockCount }}</h2>
                    <p class="text-xs text-gray-400 mt-1">produk perlu restock</p>
                </div>

                {{-- BARANG MASUK HARI INI --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Masuk Hari Ini</p>
                    <h2 class="text-3xl font-bold text-green-500">{{ $todayIn }}</h2>
                    <p class="text-xs text-gray-400 mt-1">unit diterima</p>
                </div>

                {{-- BARANG KELUAR HARI INI --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Keluar Hari Ini</p>
                    <h2 class="text-3xl font-bold text-orange-500">{{ $todayOut }}</h2>
                    <p class="text-xs text-gray-400 mt-1">unit dikeluarkan</p>
                </div>

                {{-- TOTAL PRODUK --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Total Produk</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</h2>
                    <p class="text-xs text-gray-400 mt-1">produk terdaftar</p>
                </div>

            </div>

            {{-- CHART TRANSAKSI --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm mb-6">
                <h3 class="font-semibold text-gray-700 mb-5">Transaksi 7 Hari Terakhir</h3>
                <div class="relative h-64">
                    <canvas id="mgrTransactionChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- STOK MENIPIS LIST --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Produk Stok Menipis</h3>
                        <a href="{{ route('admin.products.index') }}" class="text-xs text-blue-500 hover:underline">
                            Lihat Semua
                        </a>
                    </div>

                    @php
                        $mgrLowStocks = Product::whereColumn('stock', '<=', 'min_stock')
                            ->with('category')->take(6)->get();
                    @endphp

                    @forelse($mgrLowStocks as $product)
                        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">{{ $product->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $product->category->name ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-red-500 font-semibold text-sm">
                                    {{ $product->stock }} {{ $product->unit }}
                                </span>
                                <p class="text-xs text-gray-400">min: {{ $product->min_stock }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-gray-400 text-sm">Semua stok aman</div>
                    @endforelse

                </div>

                {{-- TRANSAKSI TERBARU --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Transaksi Terbaru</h3>
                        <a href="{{ route('manager.stock.index') }}" class="text-xs text-blue-500 hover:underline">
                            Lihat Semua
                        </a>
                    </div>

                    @php
                        $mgrRecentTrx = StockTransaction::with(['product', 'user'])
                            ->latest('transaction_date')->take(6)->get();
                    @endphp

                    @forelse($mgrRecentTrx as $trx)
                        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">
                                    {{ $trx->product->name ?? '-' }}
                                </h4>
                                <p class="text-xs text-gray-400">
                                    {{ $trx->transaction_date->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right">
                                @if($trx->type === 'in')
                                    <span class="inline-block bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">
                                        +{{ $trx->quantity }}
                                    </span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-500 text-xs font-semibold px-2 py-1 rounded-full">
                                        -{{ $trx->quantity }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-gray-400 text-sm">Belum ada transaksi</div>
                    @endforelse

                </div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const mgrTransactionChart = document.getElementById('mgrTransactionChart');
                new window.Chart(mgrTransactionChart, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($mgrLabels) !!},
                        datasets: [
                            {
                                label: 'Barang Masuk',
                                data: {!! json_encode($mgrDataIn) !!},
                                backgroundColor: 'rgba(34,197,94,0.7)',
                                borderRadius: 6
                            },
                            {
                                label: 'Barang Keluar',
                                data: {!! json_encode($mgrDataOut) !!},
                                backgroundColor: 'rgba(249,115,22,0.7)',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            </script>

        @endif

        {{-- ================= STAFF GUDANG ================= --}}
        @if($role === 'staff_gudang')

            @php
                $pendingIn = StockTransaction::where('type', 'in')
                    ->whereDate('transaction_date', today())
                    ->with(['product', 'user'])
                    ->latest()
                    ->take(5)
                    ->get();

                $pendingOut = StockTransaction::where('type', 'out')
                    ->whereDate('transaction_date', today())
                    ->with(['product', 'user'])
                    ->latest()
                    ->take(5)
                    ->get();

                $staffTodayIn  = StockTransaction::where('type', 'in')
                    ->whereDate('transaction_date', today())->count();

                $staffTodayOut = StockTransaction::where('type', 'out')
                    ->whereDate('transaction_date', today())->count();
            @endphp

            {{-- CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Transaksi Masuk Hari Ini</p>
                    <h2 class="text-3xl font-bold text-green-500">{{ $staffTodayIn }}</h2>
                    <p class="text-xs text-gray-400 mt-1">transaksi penerimaan</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-400 mb-2">Transaksi Keluar Hari Ini</p>
                    <h2 class="text-3xl font-bold text-orange-500">{{ $staffTodayOut }}</h2>
                    <p class="text-xs text-gray-400 mt-1">transaksi pengeluaran</p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- BARANG MASUK HARI INI --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                    <div class="p-5 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                        <h3 class="font-semibold text-gray-700">Barang Masuk Hari Ini</h3>
                    </div>

                    @forelse($pendingIn as $trx)
                        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">
                                    {{ $trx->product->name ?? '-' }}
                                </h4>
                                <p class="text-xs text-gray-400">
                                    Dicatat oleh {{ $trx->user->name ?? '-' }}
                                </p>
                            </div>
                            <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                                +{{ $trx->quantity }}
                            </span>
                        </div>
                    @empty
                        <div class="p-5 text-gray-400 text-sm">
                            Belum ada barang masuk hari ini
                        </div>
                    @endforelse

                    <div class="p-4">
                        <a href="{{ route('manager.stock.create') }}"
                            class="block text-center bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 rounded-xl transition">
                            + Catat Barang Masuk
                        </a>
                    </div>

                </div>

                {{-- BARANG KELUAR HARI INI --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                    <div class="p-5 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span>
                        <h3 class="font-semibold text-gray-700">Barang Keluar Hari Ini</h3>
                    </div>

                    @forelse($pendingOut as $trx)
                        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50">
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">
                                    {{ $trx->product->name ?? '-' }}
                                </h4>
                                <p class="text-xs text-gray-400">
                                    Dicatat oleh {{ $trx->user->name ?? '-' }}
                                </p>
                            </div>
                            <span class="bg-orange-100 text-orange-500 text-xs font-semibold px-3 py-1 rounded-full">
                                -{{ $trx->quantity }}
                            </span>
                        </div>
                    @empty
                        <div class="p-5 text-gray-400 text-sm">
                            Belum ada barang keluar hari ini
                        </div>
                    @endforelse

                    <div class="p-4">
                        <a href="{{ route('manager.stock.create') }}"
                            class="block text-center bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2 rounded-xl transition">
                            + Catat Barang Keluar
                        </a>
                    </div>

                </div>

            </div>

        @endif

    </div>

</x-app-layout>