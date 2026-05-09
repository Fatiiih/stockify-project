<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Produk</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Produk</label>
                        <input type="text" name="code" value="{{ old('code', $product->code) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">
                        @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                        <select name="supplier_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                                required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli</label>
                        <input type="number" name="buy_price" value="{{ old('buy_price', $product->buy_price) }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('buy_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
                        <input type="number" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('sell_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum</label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('min_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                        <input type="text" name="unit" value="{{ old('unit', $product->unit) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                               required>
                        @error('unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-20 h-20 object-cover rounded-lg mb-2 border border-gray-200">
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-sm text-gray-500">
                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                        Update Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>