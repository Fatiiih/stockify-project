<x-app-layout>
   <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800">Laporan Aktivitas Pengguna</h2>
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

        {{-- Ringkasan per User --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Ringkasan Aktivitas per Pengguna</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Barang Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Barang Keluar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #F97316;">
                                    <span class="text-xs font-semibold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="px-2.5 py-1 text-xs font-medium rounded-lg" style="background-color: #fff7ed; color: #F97316;">Admin</span>
                            @elseif($user->role === 'manajer_gudang')
                                <span class="px-2.5 py-1 text-xs font-medium text-amber-800 bg-amber-50 rounded-lg">Manajer Gudang</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg">Staff Gudang</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->stock_transactions_count }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">{{ $user->transactions_in_count }}</td>
                        <td class="px-6 py-4 font-semibold text-red-500">{{ $user->transactions_out_count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Filter Aktivitas --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5">
            <form method="GET" action="{{ route('manager.reports.activity') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Pengguna</label>
                    <select name="user_id"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                        <option value="">Semua Pengguna</option>
                        @foreach($allUsers as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                </div>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white rounded-lg"
                        style="background-color: #F97316;">
                    Filter
                </button>
                <a href="{{ route('manager.reports.activity') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Reset
                </a>
            </form>
        </div>

        {{-- Riwayat Aktivitas --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Riwayat Aktivitas</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentActivities as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $trx->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->user->role ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $trx->product->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($trx->type === 'in')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $trx->quantity }}</td>
                        <td class="px-6 py-4">
                            @if($trx->status === 'confirmed')
                                <span class="px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-lg">Dikonfirmasi</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-medium text-amber-700 bg-amber-50 rounded-lg">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $trx->transaction_date->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-gray-50">
                {{ $recentActivities->links() }}
            </div>
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