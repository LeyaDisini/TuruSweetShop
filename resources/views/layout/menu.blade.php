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

        <div class="absolute left-1/2 transform -translate-x-1/2 flex space-x-6" id="nav-links">
            <!-- Will be filled by JavaScript -->
        </div>

        <div class="ml-auto flex items-center space-x-6" id="auth-section">
            <!-- Will be filled by JavaScript -->
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

    <script>
        const token = localStorage.getItem('token');
        const role = localStorage.getItem('role');
        const authSection = document.getElementById('auth-section');
        const navLinks = document.getElementById('nav-links');

        // Nav By Role
        if (role === 'admin') {
            navLinks.innerHTML = `
                <a href="/dashboard" class="hover:underline">Dashboard</a>
                <a href="/produk" class="hover:underline">Produk</a>
                <a href="/pesanan" class="hover:underline">Pesanan</a>
            `;
        } else if (role === 'user') {
            navLinks.innerHTML = `
                <a href="/dashboard" class="hover:underline">Beranda</a>
                <a href="/produk" class="hover:underline">Belanja</a>
                <a href="/pesanan" class="hover:underline">Pesanan Saya</a>
            `;
        }

        //////////////
        if (token && token !== 'null' && token !== '') {
            authSection.innerHTML = `
                <button onclick="logout()" class="hover:underline text-red-600">Logout</button>
            `;
        } else {
            authSection.innerHTML = `
                <a href="/login" class="hover:underline">Login</a>
            `;
        }


        function logout() {
            fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(data => {
                            throw new Error(data.message || 'Logout gagal');
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    alert('Logout berhasil!');
                    localStorage.removeItem('token');
                    localStorage.removeItem('role');
                    window.location.href = '/login';
                })
                .catch(err => {
                    alert('Logout gagal: ' + err.message);
                    console.error(err);
                });
        }
    </script>
</body>

</html>
