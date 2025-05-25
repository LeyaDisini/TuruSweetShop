@extends('layout.menu')
@section('konten')
    <!-- Carousel -->
    <div class="relative w-full max-w-5xl mx-auto mt-10 rounded-xl overflow-hidden shadow-lg">
        <div class="w-full h-64 bg-cover bg-center transition-all duration-500" style="background-image: url('{{ asset('images/kue1.jpg') }}');" id="carousel-image">
        </div>
    </div>

    <!-- Script carousel sederhana -->
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

    <!-- Konten Produk -->
    <div class="max-w-6xl mx-auto mt-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition duration-300">
                <img src="{{ asset('images/kue' . $i . '.jpg') }}" alt="Kue" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="text-[#683100] text-xl font-bold mb-2">Kue Manis #{{ $i }}</h3>
                <p class="text-[#af5100] mb-4">Rasakan manisnya tiap gigitan dari kue spesial kami.</p>
                <button class="bg-[#af5100] text-white font-semibold px-4 py-2 rounded hover:bg-[#683100] transition duration-300">
                    Beli Sekarang
                </button>
            </div>
        @endfor
    </div>

@endsection
  