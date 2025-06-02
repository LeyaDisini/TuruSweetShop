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
            <img src="{{ asset('/storage/images/turuu.png') }}" alt="Sweet Cake" class="w-72" />
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

            <form id="login-form" class="space-y-6">
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
            
                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-[#af5100] border-gray-300 rounded focus:ring-[#683100]">
                    <label for="remember" class="ml-2 block text-sm text-[#683100] font-semibold">
                        Remember Me
                    </label>
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
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
    
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;
            const remember_me = document.querySelector('#remember').checked;
    
            fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    remember_me: remember_me
                })
            })
            .then(async (res) => {
                const data = await res.json();
    
                if (!res.ok) {
                    if (data.errors) {
                        const messages = Object.values(data.errors).flat().join('\n');
                        alert(messages);
                    } else {
                        alert(data.message || 'Gagal login.');
                    }
                    return;
                }
    
                localStorage.setItem('token', data.token);
                localStorage.setItem('role', data.user.is_admin ? 'admin' : 'user');
    
                if(data.user.is_admin){
                    window.location.href = '/admin/index';
                } else {
                    window.location.href = '/home';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat login.');
            });
        });
    </script>
    </body>
</html>
