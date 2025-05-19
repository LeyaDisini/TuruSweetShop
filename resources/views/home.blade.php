<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Turu SweetShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fff6da] min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-[#ffb64f] text-[#683100] font-bold px-8 py-4 flex justify-between items-center shadow-md">
        <h1 class="text-2xl tracking-wide">🍰 Turu SweetShop</h1>
        <div class="space-x-6">
            <a href="#" class="hover:underline">Dashboard</a>
            <a href="#" class="hover:underline">Produk</a>
            <a href="#" class="hover:underline">Pesanan</a>
            <a href="#" class="hover:underline text-red-600">Logout</a>
        </div>
    </nav>

    <!-- Carousel -->
    <div class="relative w-full max-w-5xl mx-auto mt-10 rounded-xl overflow-hidden shadow-lg">
        <div class="w-full h-64 bg-cover bg-center transition-all duration-500" style="background-image: url('{{ asset('images/kue1.jpg') }}');" id="carousel-image">
        </div>
    </div>

    <!-- Script carousel sederhana -->
    <script>
        const images = [
            "{{ asset('images/kue1.jpg') }}",
            "{{ asset('images/kue2.jpg') }}",
            "{{ asset('images/kue3.jpg') }}"
        ];
        let index = 0;
        setInterval(() => {
            index = (index + 1) % images.length;
            document.getElementById("carousel-image").style.backgroundImage = `url('${images[index]}')`;
        }, 3000);
    </script>

    <!-- Konten Produk -->
    <div class="max-w-6xl mx-auto mt-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition duration-300">
                <img src="{{ asset('images/kue' . $i . '.jpg') }}" alt="Kue" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-[#683100] text-xl font-bold mb-2">Kue Manis #{{ $i }}</h3>
                <p class="text-[#af5100] mb-4">Rasakan manisnya tiap gigitan dari kue spesial kami.</p>
                <button class="bg-[#af5100] text-white font-semibold px-4 py-2 rounded hover:bg-[#683100] transition duration-300">
                    Beli Sekarang
                </button>
            </div>
        @endfor
    </div>

    <!-- Footer -->
    <footer class="mt-16 bg-[#ffb64f] text-center text-[#683100] py-4 font-semibold">
        &copy; 2025 Turu SweetShop. All rights reserved.
    </footer>
</body>
</html>
