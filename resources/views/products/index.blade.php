@extends('layout.menu')
@section('konten')
   
    <div class="max-w-6xl mx-auto mt-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @for ($i = 1; $i <= 9; $i++)
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
  