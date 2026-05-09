<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Barang</h2>
            <p class="text-sm text-gray-400 mt-0.5">Konfirmasi penerimaan dan pengeluaran barang</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('success'))
            <div class="flex items-center gap-3 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Barang Masuk --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16l4 4 4-4M7 20V4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-700">Barang Masuk - Perlu Dikonfirmasi</h3>
                </div>
                <span class="px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-lg">
                    {{ $incoming->total() }} pending
                </span>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Dicatat Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($incoming as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $trx->product->code ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-green-600">+{{ $trx->quantity }}</span>
                            <span class="text-xs text-gray-400 ml-1">{{ $trx->product->unit ?? '' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $trx->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $trx->transaction_date->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $trx->note ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('staff.confirm.store', $trx->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Konfirmasi barang masuk ini sudah diterima?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-colors"
                                        style="background-color: #F97316;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tidak ada barang masuk yang perlu dikonfirmasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($incoming->hasPages())
                <div class="px-6 py-3 border-t border-gray-50">{{ $incoming->links() }}</div>
            @endif
        </div>

        {{-- Barang Keluar --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l4-4 4 4M7 4v16"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-700">Barang Keluar - Perlu Dikonfirmasi</h3>
                </div>
                <span class="px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-lg">
                    {{ $outgoing->total() }} pending
                </span>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Dicatat Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($outgoing as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $trx->product->code ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-red-600">-{{ $trx->quantity }}</span>
                            <span class="text-xs text-gray-400 ml-1">{{ $trx->product->unit ?? '' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $trx->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $trx->transaction_date->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $trx->note ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('staff.confirm.store', $trx->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Konfirmasi barang keluar ini sudah disiapkan?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-colors"
                                        style="background-color: #F97316;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tidak ada barang keluar yang perlu dikonfirmasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($outgoing->hasPages())
                <div class="px-6 py-3 border-t border-gray-50">{{ $outgoing->links() }}</div>
            @endif
        </div>

    </div>
</x-app-layout>