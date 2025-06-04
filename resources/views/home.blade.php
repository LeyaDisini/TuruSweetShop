@extends('layout.menu')
@section('konten')
    <!-- Carousel -->
    <div class="relative w-full max-w-5xl mx-auto mt-10 rounded-xl overflow-hidden shadow-lg">
        <div class="w-full h-80 bg-cover bg-center transition-all duration-500"
            style="background-image: url('{{ asset('image/Banner1.png') }}');" id="carousel-image"></div>
    </div>

    <script>
        const images = [
            "{{ asset('image/Banner1.png') }}",
            "{{ asset('image/Banner2.png') }}"
        ];

        let index = 0;
        setInterval(() => {
            index = (index + 1) % images.length;
            document.getElementById("carousel-image").style.backgroundImage = `url('${images[index]}')`;
        }, 3000);
    </script>

    <!-- Produk -->
    <div class="max-w-6xl mx-auto mt-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition duration-300">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                    class="w-full h-45 object-cover rounded-lg mb-4">
                <h3 class="text-[#683100] text-xl font-bold mb-2">{{ $product->name }}</h3>
                <p class="text-[#af5100] mb-4">{{ $product->desc }}</p>
                <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="flex items-center gap-2 mb-3">
                    <label for="qty-{{ $product->id }}" class="text-sm">Jumlah:</label>
                    <input id="qty-{{ $product->id }}" type="number" min="1" max="{{ $product->stock }}"
                        value="1" class="w-16 border rounded px-2 py-1 text-sm">
                </div>

                <button onclick="addToCart('{{ $product->id }}')"
                    class="bg-[#af5100] text-white font-semibold px-4 py-2 rounded hover:bg-[#683100] transition duration-300">
                    Add
                </button>
            </div>
        @endforeach
    </div>

    <!-- Tombol Lihat Keranjang -->
    <!-- Tombol Lihat Keranjang -->
    <button onclick="showCart()"
        class="fixed bottom-6 right-6 bg-[#af5100] hover:bg-[#683100] text-white p-4 rounded-full shadow-lg transition-all transform hover:scale-105">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span id="cartCount"
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
        </div>
    </button>

    <!-- Modal Keranjang -->
    <div id="cartModal" class="fixed inset-0 z-50 hidden">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="hideCart()"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md max-h-[90vh] flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-2xl font-bold text-[#683100]">Keranjang Belanja</h2>
                    <button onclick="hideCart()" class="text-gray-500 hover:text-gray-700 text-3xl font-bold">
                        &times;
                    </button>
                </div>

                <!-- Content -->
                <div id="cartContent" class="flex-1 overflow-y-auto p-6">
                    <p class="text-gray-500">Memuat keranjang...</p>
                </div>

                <!-- Footer -->
                <div class="border-t p-6 bg-gray-50">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-semibold">Total:</span>
                        <span id="cartTotal" class="text-xl font-bold text-[#683100]">Rp 0</span>
                    </div>
                    <button onclick="checkLoginAndRedirect()"
                        class="w-full bg-[#af5100] hover:bg-[#683100] text-white py-3 rounded-lg font-bold transition-colors">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(productId) {
            const qtyInput = document.getElementById('qty-' + productId);
            const quantity = parseInt(qtyInput.value) || 1;

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Produk berhasil ditambahkan ke keranjang!');
                    } else {
                        alert('Gagal menambahkan produk: ' + data.message);
                    }
                })
                .catch(() => alert('Terjadi kesalahan saat menambahkan produk.'));
        }

        function showCart() {
            document.getElementById('cartModal').classList.remove('hidden');
            loadCart();
        }

        function hideCart() {
            document.getElementById('cartModal').classList.add('hidden');
        }

        function loadCart() {
            fetch('/cart/data')
                .then(res => res.json())
                .then(data => {
                    const cartContent = document.getElementById('cartContent');
                    const cartTotal = document.getElementById('cartTotal');

                    if (data.cart && Object.keys(data.cart).length > 0) {
                        let html = '';
                        let total = 0;

                        for (let id in data.cart) {
                            let item = data.cart[id];
                            let subtotal = item.price * item.quantity;
                            total += subtotal;

                            html += `
                    <div class="flex gap-4 py-4 border-b last:border-0">
                        <img src="${item.image}" alt="${item.name}" 
                             class="w-20 h-20 object-cover rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-bold text-[#683100]">${item.name}</h3>
                            <p class="text-[#af5100]">Rp ${formatRupiah(item.price)}</p>
                            
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center gap-2">
                                    <button onclick="updateQuantity('${id}', ${item.quantity-1})" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        −
                                    </button>
                                    <span class="w-10 text-center">${item.quantity}</span>
                                    <button onclick="updateQuantity('${id}', ${item.quantity+1})" 
                                            class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        +
                                    </button>
                                </div>
                                <button onclick="removeItem('${id}')" 
                                        class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>`;
                        }

                        cartContent.innerHTML = html;
                        cartTotal.textContent = `Rp ${formatRupiah(total)}`;
                    } else {
                        cartContent.innerHTML = `
                <div class="text-center py-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Keranjang Kosong</h3>
                    <p class="mt-1 text-gray-500">Tambahkan produk untuk melanjutkan</p>
                    <button onclick="hideCart()" 
                            class="mt-6 bg-[#af5100] hover:bg-[#683100] text-white px-6 py-2 rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>`;
                        cartTotal.textContent = 'Rp 0';
                    }
                })
                .catch(() => {
                    document.getElementById('cartContent').innerHTML = `
            <div class="text-center py-10 text-red-500">
                Gagal memuat keranjang. Silakan coba lagi.
            </div>`;
                });
        }

        function checkLoginAndRedirect() {
            if (localStorage.getItem('token') !== null) {
                window.location.href = '/invoice';
            } else {
                alert('Mohon Login sebelum melanjutkan proses pembayaran.')
                window.location.href = '/login';
            }
        }

        function updateQuantity(productId, quantity) {
            quantity = parseInt(quantity);
            if (isNaN(quantity) || quantity < 1) {
                alert('Jumlah harus minimal 1');
                loadCart();
                return;
            }

            fetch('/cart/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadCart();
                    } else {
                        alert('Gagal update jumlah: ' + data.message);
                        loadCart();
                    }
                })
                .catch(() => alert('Terjadi kesalahan saat update jumlah.'));
        }

        function removeItem(productId) {
            if (!confirm('Yakin ingin menghapus produk ini dari keranjang?')) return;

            fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadCart();
                    } else {
                        alert('Gagal menghapus produk: ' + data.message);
                    }
                })
                .catch(() => alert('Terjadi kesalahan saat menghapus produk.'));
        }

        function formatRupiah(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        // Tambahkan di fungsi addToCart setelah berhasil menambahkan ke keranjang
        function updateCartCounter() {
            fetch('/cart/data')
                .then(res => res.json())
                .then(data => {
                    const count = data.cart ? Object.keys(data.cart).length : 0;
                    document.getElementById('cartCount').textContent = count;
                });
        }

        // Panggil saat pertama kali load halaman
        document.addEventListener('DOMContentLoaded', updateCartCounter);
    </script>
@endsection
