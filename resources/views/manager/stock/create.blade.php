<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $type === 'in' ? 'Catat Barang Masuk' : 'Catat Barang Keluar' }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form action="{{ route('manager.stock.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                    <select name="product_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                            required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stok: {{ $product->stock }} {{ $product->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                           required>
                    @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400">(opsional)</span></label>
                    <textarea name="note" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">{{ old('note') }}</textarea>
                    @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white {{ $type === 'in' ? 'bg-primary-600 hover:bg-primary-800' : 'bg-red-500 hover:bg-red-700' }} rounded-lg">
                        {{ $type === 'in' ? 'Simpan Barang Masuk' : 'Simpan Barang Keluar' }}
                    </button>
                    <a href="{{ route('manager.stock.index') }}"
                       class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>