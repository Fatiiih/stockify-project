<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h2>
            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-800">
                + Tambah Pengguna
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
                        
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Dibuat</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 text-xs font-medium text-primary-800 bg-primary-50 rounded-full">Admin</span>
                            @elseif($user->role === 'manajer_gudang')
                                <span class="px-2 py-1 text-xs font-medium text-amber-800 bg-amber-50 rounded-full">Manajer Gudang</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">Staff Gudang</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-amber-600 hover:underline text-xs">Edit</a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>