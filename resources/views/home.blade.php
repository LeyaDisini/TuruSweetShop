@extends('layout.menu')
@section('konten')
    <!-- Carousel -->
    <div class="relative w-full max-w-5xl mx-auto mt-10 rounded-xl overflow-hidden shadow-lg">
        <div class="w-full h-64 bg-cover bg-center transition-all duration-500" style="background-image: url('{{ asset('images/kue1.jpg') }}');" id="carousel-image"></div>
    </div>

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

    <!-- Produk -->
    <div class="max-w-6xl mx-auto mt-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition duration-300">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-45 object-cover rounded-lg mb-4">
            <h3 class="text-[#683100] text-xl font-bold mb-2">{{ $product->name }}</h3>
            <p class="text-[#af5100] mb-4">{{ $product->desc }}</p>
            <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
            <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            
            <div class="flex items-center gap-2 mb-3">
                <label for="qty-{{ $product->id }}" class="text-sm">Jumlah:</label>
                <input 
                    id="qty-{{ $product->id }}" 
                    type="number" 
                    min="1" 
                    max="{{ $product->stock }}" 
                    value="1" 
                    class="w-16 border rounded px-2 py-1 text-sm"
                >
            </div>

            <button 
                onclick="addToCart('{{ $product->id }}')" 
                class="bg-[#af5100] text-white font-semibold px-4 py-2 rounded hover:bg-[#683100] transition duration-300"
            >
                Add
            </button>
        </div>
        @endforeach
    </div>

    <!-- Tombol Lihat Keranjang -->
    <button 
        onclick="showCart()" 
        class="fixed bottom-5 right-5 bg-[#af5100] text-white px-4 py-2 rounded shadow-lg hover:bg-[#683100] transition"
    >
        Lihat Keranjang
    </button>

    <!-- Modal Keranjang -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg w-96 p-6 max-h-[80vh] overflow-auto relative">
            <button onclick="hideCart()" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800 font-bold text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-[#683100]">Keranjang Belanja</h2>
            <div id="cartContent">
                <p>Memuat keranjang...</p>
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
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
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
                    if(data.cart && Object.keys(data.cart).length > 0) {
                        let html = '<table class="w-full text-left border-collapse">';
                        html += '<thead><tr class="border-b"><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead><tbody>';
                        let total = 0;
                        for(let id in data.cart) {
                            let item = data.cart[id];
                            let subtotal = item.price * item.quantity;
                            total += subtotal;
                            html += `<tr class="border-b align-middle">
                                <td class="py-2 flex items-center gap-3">
                                    <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded" />
                                    ${item.name}
                                </td>
                                <td class="py-2">Rp ${formatRupiah(item.price)}</td>
                                <td class="py-2">
                                    <input 
                                        type="number" 
                                        min="1" 
                                        value="${item.quantity}" 
                                        onchange="updateQuantity('${id}', this.value)"
                                        class="w-16 border rounded px-1 py-1 text-sm"
                                    >
                                </td>
                                <td class="py-2">Rp ${formatRupiah(subtotal)}</td>
                                <td class="py-2">
                                    <button onclick="removeItem('${id}')" class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</button>
                                </td>
                            </tr>`;
                        }
                        html += `<tr><td colspan="3" class="text-right font-bold py-3">Total:</td><td class="font-bold py-3">Rp ${formatRupiah(total)}</td><td></td></tr>`;
                        html += '</tbody></table>';
                        html += `
                            <div class="mt-4 text-right">
                                <button 
                                    onclick="checkLoginAndRedirect()" 
                                    class="bg-[#af5100] hover:bg-[#683100] text-white font-bold py-2 px-6 rounded transition duration-300"
                                >
                                    Bayar
                                </button>
                            </div>
                        `;
                        document.getElementById('cartContent').innerHTML = html;
                    } else {
                        document.getElementById('cartContent').innerHTML = '<p>Keranjang kosong.</p>';
                    }
                })
                .catch(() => {
                    document.getElementById('cartContent').innerHTML = '<p>Gagal memuat keranjang.</p>';
                });
        }

        function checkLoginAndRedirect(){
            if(localStorage.getItem('token')!== null){
                window.location.href = '/invoice';
            }
            else{
                alert('Mohon Login sebelum melanjutkan proses pembayaran.')
                window.location.href = '/login';
            }
        }

        function updateQuantity(productId, quantity) {
            quantity = parseInt(quantity);
            if(isNaN(quantity) || quantity < 1) {
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
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    loadCart();
                } else {
                    alert('Gagal update jumlah: ' + data.message);
                    loadCart();
                }
            })
            .catch(() => alert('Terjadi kesalahan saat update jumlah.'));
        }

        function removeItem(productId) {
            if(!confirm('Yakin ingin menghapus produk ini dari keranjang?')) return;

            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
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
    </script>
@endsection
