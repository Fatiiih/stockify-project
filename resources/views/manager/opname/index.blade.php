<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Stock Opname</h2>
            <a href="{{ route('manager.opname.create') }}"
               class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                + Catat Opname
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-primary-50 text-primary-800 text-xs uppercase">
                    <tr>
                       
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Stok Sistem</th>
                        <th class="px-4 py-3">Stok Fisik</th>
                        <th class="px-4 py-3">Selisih</th>
                        <th class="px-4 py-3">Dicatat Oleh</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opnames as $i => $opname)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $opname->product->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $opname->system_stock }}</td>
                        <td class="px-4 py-3">{{ $opname->physical_stock }}</td>
                        <td class="px-4 py-3">
                            @if($opname->difference > 0)
                                <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">+{{ $opname->difference }}</span>
                            @elseif($opname->difference < 0)
                                <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">{{ $opname->difference }}</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">0</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $opname->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $opname->opname_date->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $opname->note ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-400">Belum ada data stock opname.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $opnames->links() }}
            </div>
        </div>
    </div>
</x-app-layout>