<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Stok</h2>
            <div class="flex gap-2">
                <a href="{{ route('manager.stock.create', ['type' => 'in']) }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                    + Barang Masuk
                </a>
                <a href="{{ route('manager.stock.create', ['type' => 'out']) }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-700">
                    - Barang Keluar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <p class="text-xs text-gray-400 mb-1">Barang Masuk Hari Ini</p>
                <p class="text-2xl font-semibold text-primary-800">{{ $todayIn }}</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <p class="text-xs text-gray-400 mb-1">Barang Keluar Hari Ini</p>
                <p class="text-2xl font-semibold text-red-600">{{ $todayOut }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-primary-50 text-primary-800 text-xs uppercase">
                    <tr>
                        
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Dicatat Oleh</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $i => $trx)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                       
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $trx->product->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($trx->type === 'in')
                                <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Masuk</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Keluar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $trx->quantity }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $trx->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $trx->transaction_date->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $trx->note ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>