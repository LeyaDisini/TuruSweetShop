
@extends('layout.menu')
@section('konten')
<div class="max-w-2xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-[#683100]">Edit Produk</h2>
    <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="desc" class="w-full border rounded px-3 py-2" required>{{ $product->desc }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Stok</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Gambar Baru (Opsional)</label>
            <input type="file" name="image" class="w-full">
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="Produk" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
        </div>
        <button type="submit" class="bg-[#af5100] text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) {
        console.error('Form tidak ditemukan');
        return;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const productId = @json($product->id);

        for (let pair of formData.entries()) {
            console.log(`${pair[0]}: ${pair[1]}`);
        }

        formData.append('_method', 'PUT');

        fetch(`/api/products/${productId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
            },
            body: formData,
        })
        .then(async res => {
            const text = await res.text();
            console.log('Response status:', res.status);
            console.log('Response body:', text);

            if (!res.ok) {
                throw new Error(text || 'Gagal update produk');
            }

            return JSON.parse(text);
        })


        .then(data => {
            console.log('Data diterima:', data);
            alert(data.message);
            window.location.href = '/admin/index';
        })
        .catch(err => {
            console.error('Error saat update:', err);
            alert(err.message);
        });
    });
});
</script>