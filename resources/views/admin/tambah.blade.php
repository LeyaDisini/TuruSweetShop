
@extends('layout.menu')
@section('konten')
<div class="max-w-2xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#683100]">Tambah Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nama Produk</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="desc" class="w-full border rounded px-3 py-2" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Stok</label>
            <input type="number" name="stock" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input type="file" name="image" class="w-full">
        </div>
        <button type="submit" class="bg-[#af5100] text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection