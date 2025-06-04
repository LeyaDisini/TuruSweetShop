@extends('layout.menu')
@section('konten')
   
    <div class="min-h-screen  py-10 px-4">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-md">
            <h2 class="text-2xl md:text-3xl font-bold text-[#683100] mb-6 border-b pb-2">Invoice Pembelian</h2>

            @if(count($cart) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-[#fff3e8] text-[#683100]">
                                <th class="py-2">Produk</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cart as $item)
                                @php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                @endphp
                                <tr class="border-b">
                                    <td class="py-3 flex items-center gap-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded" />
                                        <span class="text-[#683100] font-semibold">{{ $item['name'] }}</span>
                                    </td>
                                    <td class="py-3 text-[#af5100]">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td class="py-3">{{ $item['quantity'] }}</td>
                                    <td class="py-3 font-semibold text-[#683100]">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right font-bold py-4 text-lg text-[#683100]">Total:</td>
                                <td class="font-bold text-lg text-[#af5100]">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500">Keranjang kosong.</p>
            @endif

            <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="flex justify-end gap-4 mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded transition duration-300">
                        Bayar
                    </button> 
                    {{-- belom bisa bayar krn user auth masih bermasalah --}}
                    <a href="/home" class="bg-gray-300 hover:bg-gray-400 text-[#683100] font-semibold px-6 py-2 rounded transition duration-300">
                        Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                body: JSON.stringify({ })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'insufficient') {
                    showTopUpModal();
                } else if (data.status === 'success') {
                    showSuccessModal();
                }
            });
        });

        function showTopUpModal() {
            alert('Saldo tidak cukup. Silakan top up terlebih dahulu.');
        }

        function showSuccessModal() {
            alert('Transaksi berhasil!');
            window.location.href = '/home';
        }
    </script>

@endsection
  