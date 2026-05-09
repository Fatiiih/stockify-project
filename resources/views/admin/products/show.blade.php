<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Detail Produk</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg"
                   style="background-color: #F97316;">
                    Edit
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-4">

        @if(session('success'))
            <div class="flex items-center gap-3 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Info Produk --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex gap-5 mb-5">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}"
                         class="w-28 h-28 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                @else
                    <div class="w-28 h-28 rounded-xl border border-gray-100 bg-orange-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-400 font-mono mt-1">{{ $product->code }}</p>
                    <div class="mt-2">
                        @if($product->stock <= $product->min_stock)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Stok Menipis
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Stok Aman
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-3">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 border-t border-gray-50 pt-4">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Kategori</p>
                    <p class="text-sm font-medium text-gray-700">{{ $product->category->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Supplier</p>
                    <p class="text-sm font-medium text-gray-700">{{ $product->supplier->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Harga Beli</p>
                    <p class="text-sm font-medium text-gray-700">Rp {{ number_format($product->buy_price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Harga Jual</p>
                    <p class="text-sm font-medium text-gray-700">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl p-3" style="background-color: #fff7ed;">
                    <p class="text-xs mb-1" style="color: #F97316;">Stok Tersedia</p>
                    <p class="text-lg font-semibold" style="color: #F97316;">{{ $product->stock }} {{ $product->unit }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-1">Stok Minimum</p>
                    <p class="text-sm font-medium text-gray-700">{{ $product->min_stock }} {{ $product->unit }}</p>
                </div>
            </div>
        </div>

        {{-- Atribut Produk --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Atribut Produk</h3>

            {{-- Form tambah atribut --}}
            <form action="{{ route('admin.products.attributes.store', $product) }}" method="POST"
                  class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" placeholder="Nama atribut (contoh: Warna)"
                       value="{{ old('name') }}"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400"
                       required>
                <input type="text" name="value" placeholder="Nilai (contoh: Merah)"
                       value="{{ old('value') }}"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400"
                       required>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white rounded-lg flex-shrink-0"
                        style="background-color: #F97316;">
                    + Tambah
                </button>
            </form>

            @error('name') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror
            @error('value') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror

            {{-- Daftar atribut --}}
            @if($product->attributes->count() > 0)
                <div class="space-y-2">
                    @foreach($product->attributes as $attribute)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-medium text-gray-500 w-24 truncate">{{ $attribute->name }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm font-medium text-gray-800">{{ $attribute->value }}</span>
                            </div>
                            <form action="{{ route('admin.products.attributes.destroy', [$product, $attribute]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus atribut ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">Belum ada atribut. Tambahkan di atas.</p>
            @endif
        </div>

    </div>
</x-app-layout>