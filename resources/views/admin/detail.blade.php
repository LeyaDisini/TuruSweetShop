@extends('layout.menu')
@section('konten')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <h2 class="text-3xl font-bold mb-4 text-[#683100]">Detail Produk</h2>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
            class="w-full h-64 object-cover rounded mb-4">
        <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
        <p class="text-gray-700">{{ $product->desc }}</p>
        <p class="mt-2 text-sm text-gray-500">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
        <a href="" class="mt-4 inline-block text-[#af5100]">Kembali ke daftar</a>
    </div>
@endsection
