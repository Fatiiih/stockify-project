<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800">Pengaturan Aplikasi</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">

        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Logo --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Aplikasi</label>
                    @if($settings['app_logo'])
                        <img src="{{ Storage::url($settings['app_logo']) }}"
                             alt="Logo"
                             class="w-24 h-24 object-contain rounded-xl border border-gray-100 mb-3">
                    @else
                        <div class="w-24 h-24 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <input type="file" name="app_logo" accept="image/*"
                           class="text-sm text-gray-500">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                    @error('app_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Aplikasi --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aplikasi</label>
                    <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400"
                           required>
                    @error('app_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="app_description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">{{ old('app_description', $settings['app_description']) }}</textarea>
                    @error('app_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Notifikasi Stok --}}
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="low_stock_notification"
                               {{ $settings['low_stock_notification'] === 'true' ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Notifikasi Stok Menipis</p>
                            <p class="text-xs text-gray-400">Tampilkan peringatan ketika stok produk di bawah minimum</p>
                        </div>
                    </label>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-colors"
                            style="background-color: #F97316;">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>