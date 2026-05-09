<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Pengguna</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                           required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                           required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400">(kosongkan jika tidak diganti)</span></label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary-400 focus:border-primary-400"
                            required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manajer_gudang" {{ old('role', $user->role) === 'manajer_gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                        <option value="staff_gudang" {{ old('role', $user->role) === 'staff_gudang' ? 'selected' : '' }}>Staff Gudang</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                        Update
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>