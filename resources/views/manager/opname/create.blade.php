<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Catat Stock Opname</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 p-6">

            <div class="mb-5 p-4 bg-primary-50 rounded-lg border border-primary-100">
                <p class="text-sm text-primary-800">
                    Stock opname akan <strong>memperbarui stok produk</strong> sesuai stok fisik yang kamu masukkan. Pastikan data sudah benar sebelum menyimpan.
                </p>
            </div>

            <form action="{{ route('manager.opname.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                    <select name="product_id" id="product_select"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                            required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    data-unit="{{ $product->unit }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4 p-3 bg-gray-50 rounded-lg" id="system_stock_info" style="display:none">
                    <p class="text-xs text-gray-400">Stok sistem saat ini</p>
                    <p class="text-lg font-semibold text-gray-800" id="system_stock_value">-</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Fisik (hasil hitung)</label>
                    <input type="number" name="physical_stock" value="{{ old('physical_stock', 0) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                           required>
                    @error('physical_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400">(opsional)</span></label>
                    <textarea name="note" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">{{ old('note') }}</textarea>
                    @error('note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                        Simpan Opname
                    </button>
                    <a href="{{ route('manager.opname.index') }}"
                       class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('product_select').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const stock = selected.getAttribute('data-stock');
            const unit = selected.getAttribute('data-unit');
            const info = document.getElementById('system_stock_info');
            const value = document.getElementById('system_stock_value');

            if (stock !== null) {
                info.style.display = 'block';
                value.textContent = stock + ' ' + unit;
            } else {
                info.style.display = 'none';
            }
        });
    </script>
</x-app-layout>