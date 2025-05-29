@extends('layout.menu')
@section('konten')
<div class="max-w-6xl mx-auto mt-10">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#683100]">Daftar Produk</h1>
        <a href="/admin/tambah" class="bg-[#af5100] text-white px-4 py-2 rounded">Tambah Produk</a>
    </div>

    @if (session('success'))
        <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="produk-container">
        {{-- AJAX --}}
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/api/products')
            .then(response => response.json())
            .then(response => {
                const products = response.products;
                const container = document.getElementById('produk-container');
                let html = '';

                products.forEach(product => {
                    html += `
                    <div class="bg-white p-5 rounded-xl shadow">
                        <img src="/${product.image}" class="w-full h-40 object-cover rounded-lg mb-4">
                        <h3 class="text-[#683100] text-xl font-bold">${product.name}</h3>
                        <p class="text-[#af5100]">${product.desc}</p>
                        <p class="text-sm text-gray-500">Stock: ${product.stock}</p>
                        <p class="text-sm text-gray-500">Rp ${Number(product.price).toLocaleString('id-ID')}</p>
                        <div class="mt-4 flex gap-2">
                            <a href="/produk/${product.id}/edit" class="text-blue-600">Edit</a>
                            <button onclick="deleteProduct('${product.id}')" class="text-red-600">Hapus</button>
                        </div>
                    </div>`;
                });

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Gagal ambil produk:', error);
                document.getElementById('produk-container').innerHTML = '<p class="text-red-500">Gagal memuat data produk.</p>';
            });
    });


    function deleteProduct(id) {
        if (!confirm('Hapus produk ini?')) return;

        fetch(`/api/products/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal menghapus produk');
            return response.json();
        })
        .then(data => {
            alert(data.message || 'Produk berhasil dihapus');
            window.location.href = '/admin/index';
        })
        .catch(error => {
            alert(error.message);
        });
    }

</script>