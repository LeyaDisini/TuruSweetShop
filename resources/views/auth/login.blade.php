<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>SweetShop Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fff6da] flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex max-w-6xl w-full my-8">
        <!-- Kiri -->
        <div class="w-1/2 bg-gradient-to-b from-[#ffe6bf] to-[#ffb64f] p-10 flex flex-col items-center justify-center space-y-6">
            <img src="{{ asset('images/turuu.png') }}" alt="Sweet Cake" class="w-72" />
            <h2 class="text-3xl font-extrabold text-[#683100] leading-snug text-center">
                Turn your sweet into reality
            </h2>
            <p class="text-[#af5100] text-center max-w-xs text-lg font-semibold">
                Start your journey with our delicious offers. The sweetest place to be!
            </p>
        </div>

        <!-- Kanan -->
        <div class="w-1/2 p-12 bg-[#fff6da] flex flex-col justify-center">
            <h2 class="text-4xl font-extrabold text-[#683100] mb-8 text-center">Login</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-[#683100] font-semibold mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        autocomplete="email"
                        class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm"
                        value="{{ old('email') }}"
                    />
                </div>

                <div>
                    <label for="password" class="block text-[#683100] font-semibold mb-2">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#af5100] hover:bg-[#683100] text-white font-bold py-3 rounded-xl transition duration-300"
                >
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-[#683100] font-semibold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#af5100] hover:underline font-bold ml-2">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>
</body>
</html>
