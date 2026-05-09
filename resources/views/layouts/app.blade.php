<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Stockify Project') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
</head>
<body class="bg-gray-50 antialiased">

    @auth
        @include('layouts.navigation')
        <div class="ml-64 min-h-screen flex flex-col">
            @isset($header)
            <header class="bg-white border-b border-gray-100 px-8 py-4 sticky top-0 z-10">
                {{ $header }}
            </header>
            @endisset
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>
            <footer class="px-8 py-3 text-xs text-gray-400 border-t border-gray-100 bg-white">
                Stockify Project &copy; {{ date('Y') }}
            </footer>
        </div>
    @else
        {{ $slot }}
    @endauth

</body>
</html>