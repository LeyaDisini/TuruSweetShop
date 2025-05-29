@extends('layout.menu')
@section('konten')
<div class="max-w-6xl mx-auto mt-10">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#683100]">Daftar Produk</h1>
        <a href="" class="bg-[#af5100] text-white px-4 py-2 rounded">Tambah Produk</a>
    </div>

    @if (session('success'))
        <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-white p-5 rounded-xl shadow">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-[#683100] text-xl font-bold">{{ $product->name }}</h3>
                <p class="text-[#af5100]">{{ $product->desc }}</p>
                <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="mt-4 flex gap-2">
                    <a href="" class="text-blue-600">Edit</a>
                    <form action="" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
