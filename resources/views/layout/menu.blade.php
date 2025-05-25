<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Turu SweetShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff6da] min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-[#ffb64f] text-[#683100] font-bold px-8 py-4 flex items-center shadow-md relative">
        <h1 class="text-2xl tracking-wide mr-6">🍰 Turu SweetShop</h1>
    
        <div class="absolute left-1/2 transform -translate-x-1/2 flex space-x-6">
            <a href="#" class="hover:underline">Dashboard</a>
            <a href="#" class="hover:underline">Produk</a>
            <a href="#" class="hover:underline">Pesanan</a>
        </div>
    
        <div class="ml-auto flex items-center space-x-6">
            @guest
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            @endguest
    
            @auth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline text-red-600">Logout</button>
                </form>
            @endauth
        </div>
    </nav>
    
    
    <!--Konten-->
    <div class="">
        @yield('konten')
    </div>

    <!-- Footer -->
    <footer class="mt-16 bg-[#ffb64f] text-center text-[#683100] py-4 font-semibold">
        &copy; 2025 Turu SweetShop. All rights reserved.
    </footer>
</body>

</html>
