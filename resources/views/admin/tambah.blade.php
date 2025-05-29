
@extends('layout.menu')
@section('konten')
<div class="max-w-2xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#683100]">Tambah Produk</h2>
    <form id="form-produk" action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nama Produk</label>
            <input id="name" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea id="desc" name="desc" class="w-full border rounded px-3 py-2" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input id="price" type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Stok</label>
            <input id="stock" type="number" name="stock" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input name="image" type="file" name="image" class="w-full">
        </div>
        <button type="submit" class="bg-[#af5100] text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection

<script>
    window.addEventListener('DOMContentLoaded', function() {
        document.getElementById('form-produk').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name', document.querySelector('[name=name]').value);
            formData.append('desc', document.querySelector('[name=desc]').value);
            formData.append('price', document.querySelector('[name=price]').value);
            formData.append('stock', document.querySelector('[name=stock]').value);
            formData.append('image', document.querySelector('[name=image]').files[0]);

            fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal menambahkan produk');
                return response.json();
            })
            .then(data => {
                alert('Produk berhasil ditambahkan');
                window.location.href = '/admin/index';
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });
</script>
