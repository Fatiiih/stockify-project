<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Stockify Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #1E293B;">

    <div class="w-full max-w-md px-6">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background-color: #F97316;">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-white">Stockify Project</h1>
            <p class="text-sm text-white/40 mt-1">Sistem Manajemen Stok Barang</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Masuk ke akun kamu</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                           style="focus:ring-color: #F97316;"
                           required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
    <div class="relative">
        <input type="password" name="password" id="password"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent pr-10"
               required>
        <button type="button" onclick="togglePassword()"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg id="eye-off-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
            </svg>
        </button>
    </div>
    @error('password')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-gray-300"
                               style="accent-color: #F97316;">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm hover:underline" style="color: #F97316;">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-2.5 text-sm font-medium text-white rounded-xl transition-opacity hover:opacity-90"
                        style="background-color: #F97316;">
                    Masuk
                </button>
            </form>

            {{-- Info akun demo --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                <p class="text-xs font-medium text-gray-500 mb-2">Akun untuk testing:</p>
                <div class="space-y-1 text-xs text-gray-400">
                    <p>Admin: <span class="font-mono text-gray-600">admin@stockify.com</span></p>
                    <p>Manajer: <span class="font-mono text-gray-600">manajer@stockify.com</span></p>
                    <p>Staff: <span class="font-mono text-gray-600">staff@stockify.com</span></p>
                    <p class="mt-1">Password semua: <span class="font-mono text-gray-600">password</span></p>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-white/30 mt-6">
            Stockify Project &copy; {{ date('Y') }}
        </p>
    </div>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');

    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}
</script>
</body>
</html>