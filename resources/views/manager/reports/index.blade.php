<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Laporan</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <a href="{{ route('manager.reports.stock') }}"
               class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-orange-300 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: #fff7ed;">
                        <svg class="w-6 h-6" style="color: #F97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Laporan Stok Barang</p>
                        <p class="text-xs text-gray-400 mt-1">Kondisi stok per produk dan kategori</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('manager.reports.transactions') }}"
               class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-orange-300 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: #fff7ed;">
                        <svg class="w-6 h-6" style="color: #F97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Laporan Transaksi</p>
                        <p class="text-xs text-gray-400 mt-1">Riwayat barang masuk dan keluar</p>
                    </div>
                </div>
            </a>

            @if(auth()->user()->role === 'admin')
            <a href="{{ route('manager.reports.activity') }}"
               class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-orange-300 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: #fff7ed;">
                        <svg class="w-6 h-6" style="color: #F97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Laporan Aktivitas</p>
                        <p class="text-xs text-gray-400 mt-1">Aktivitas pengguna dan transaksi</p>
                    </div>
                </div>
            </a>
            @endif

        </div>
    </div>
</x-app-layout>