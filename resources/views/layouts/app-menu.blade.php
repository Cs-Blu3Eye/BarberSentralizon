<!-- resources/views/layouts/app-menu.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking - Barber Shop XYZ')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800">
    <header class="bg-gray-900 text-white p-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Barber Shop XYZ</h1>
            <nav>
                <a href="{{ url('/') }}" class="text-white hover:text-gray-300 mx-2">Booking</a>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard.admin') }}" class="text-white hover:text-gray-300 mx-2">Admin Panel</a>
                    @elseif (auth()->user()->role === 'barber')
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-300 mx-2">Barber Panel</a>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-300 mx-2">Login</a>
                @endguest


            </nav>
        </div>
    </header>

    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white p-6 mt-10 text-center">
        <div class="container mx-auto">
            <p>&copy; {{ date('Y') }} Barber Shop XYZ. All rights reserved.</p>
            <p>Kontak: +62 812-3456-7890 | Alamat: Jl. Contoh No. 123, Kota Anda</p>
        </div>
    </footer>
</body>

</html>
