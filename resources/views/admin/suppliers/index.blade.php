<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Supplier</h2>
            <a href="{{ route('admin.suppliers.create') }}"
               class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                + Tambah Supplier
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-5xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-primary-50 text-primary-800 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">Nama Supplier</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Telepon</th>
                        <th class="px-4 py-3">Jumlah Produk</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $i => $supplier)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                       
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $supplier->name }}</td>
                        <td class="px-4 py-3">{{ $supplier->email ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $supplier->phone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium text-primary-800 bg-primary-50 rounded-full">
                                {{ $supplier->products_count }} produk
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                                   class="text-amber-600 hover:underline text-xs">Edit</a>
                                <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                                      onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada supplier.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>