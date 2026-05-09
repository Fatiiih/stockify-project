<aside class="fixed top-0 left-0 z-40 w-64 h-screen flex flex-col" style="background-color: #1E293B;">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #F97316;">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-white">Stockify</p>
            <p class="text-xs text-white/40">Project</p>
        </div>
    </div>

    {{-- User Info --}}
    <div class="mx-4 mt-4 mb-2 p-3 rounded-xl border border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #F97316;">
                <span class="text-xs font-semibold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/40">
                    @if(auth()->user()->role === 'admin') Admin
                    @elseif(auth()->user()->role === 'manajer_gudang') Manajer Gudang
                    @else Staff Gudang
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-2 overflow-y-auto">

        @php
            $navLink = 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-0.5 transition-colors';
            $active  = 'text-white font-medium';
            $inactive = 'text-white/50 hover:text-white hover:bg-white/5';
            $label   = 'text-xs text-white/30 uppercase tracking-wider px-3 mb-1 mt-5 block';
        @endphp

        <a href="{{ route('dashboard') }}"
           class="{{ $navLink }} {{ request()->routeIs('dashboard') ? $active : $inactive }}"
           @if(request()->routeIs('dashboard')) style="background-color: #F97316;" @endif>
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        @if(auth()->user()->role === 'admin')

            <span class="{{ $label }}">Master Data</span>

            <a href="{{ route('admin.products.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.products.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.products.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Produk
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.categories.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.categories.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.suppliers.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.suppliers.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.suppliers.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Supplier
            </a>

            <span class="{{ $label }}">Pengguna</span>

            <a href="{{ route('admin.users.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.users.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.users.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Manajemen Pengguna
            </a>

            <span class="{{ $label }}">Gudang</span>

            <a href="{{ route('manager.stock.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.stock.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.stock.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Transaksi Stok
            </a>

            <a href="{{ route('manager.opname.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.opname.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.opname.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Stock Opname
            </a>

            <span class="{{ $label }}">Laporan</span>

            <a href="{{ route('manager.reports.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.reports.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.reports.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan
            </a>
            <span class="{{ $label }}">Pengaturan</span>

<a href="{{ route('admin.settings.index') }}"
   class="{{ $navLink }} {{ request()->routeIs('admin.settings.*') ? $active : $inactive }}"
   @if(request()->routeIs('admin.settings.*')) style="background-color: #F97316;" @endif>
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Pengaturan
</a>

        @elseif(auth()->user()->role === 'manajer_gudang')

            <span class="{{ $label }}">Produk</span>

            <a href="{{ route('admin.products.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.products.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.products.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Daftar Produk
            </a>

            <a href="{{ route('admin.suppliers.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('admin.suppliers.*') ? $active : $inactive }}"
               @if(request()->routeIs('admin.suppliers.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Supplier
            </a>

            <span class="{{ $label }}">Gudang</span>

            <a href="{{ route('manager.stock.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.stock.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.stock.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Transaksi Stok
            </a>

            <a href="{{ route('manager.opname.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.opname.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.opname.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Stock Opname
            </a>

            <span class="{{ $label }}">Laporan</span>

            <a href="{{ route('manager.reports.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.reports.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.reports.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan
            </a>

        @elseif(auth()->user()->role === 'staff_gudang')

            <span class="{{ $label }}">Gudang</span>

            <a href="{{ route('manager.stock.index') }}"
               class="{{ $navLink }} {{ request()->routeIs('manager.stock.*') ? $active : $inactive }}"
               @if(request()->routeIs('manager.stock.*')) style="background-color: #F97316;" @endif>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Riwayat Transaksi
            </a>
            <a href="{{ route('staff.confirm.index') }}"
   class="{{ $navLink }} {{ request()->routeIs('staff.confirm.*') ? $active : $inactive }}"
   @if(request()->routeIs('staff.confirm.*')) style="background-color: #F97316;" @endif>
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Konfirmasi Barang
</a>

        @endif

    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 w-full transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>