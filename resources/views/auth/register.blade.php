<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>SweetShop Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff6da] flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex max-w-6xl w-full my-8">
        <!-- Kiri -->
        <div class="w-full bg-gradient-to-b from-[#ffe6bf] to-[#ffb64f] p-10 flex flex-col justify-center space-y-6">
            <h2 class="text-4xl font-extrabold text-[#683100] mb-8 text-center">Register</h2>

            <form id="register-form" class="space-y-6">
                @csrf

                <div class="flex gap-6">
                    <!--Kiri -->
                    <div class="w-1/2 space-y-4">
                        <div>
                            <label for="name" class="block text-[#683100] font-semibold mb-2">Full Name</label>
                            <input type="text" id="name" name="name" required autocomplete="name"
                                class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm"
                                value="{{ old('name') }}" />
                        </div>

                        <div>
                            <label for="email" class="block text-[#683100] font-semibold mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required autocomplete="email"
                                class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm"
                                value="{{ old('email') }}" />
                        </div>
                    </div>

                    <!--Kanan -->
                    <div class="w-1/2 space-y-4">
                        <div>
                            <label for="password" class="block text-[#683100] font-semibold mb-2">Password</label>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[#683100] font-semibold mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password"
                                class="w-full px-5 py-3 border border-[#ffb64f] rounded-xl focus:outline-none focus:ring-4 focus:ring-[#af5100] shadow-sm" />
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#af5100] hover:bg-[#683100] text-white font-bold py-3 rounded-xl transition duration-300">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-[#683100] font-semibold">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#af5100] hover:underline font-bold ml-2">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
    <script>
        document.querySelector('#register-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const name = document.querySelector('#name').value.trim();
            const email = document.querySelector('#email').value.trim();
            const password = document.querySelector('#password').value;
            const confirm = document.querySelector('#password_confirmation').value;

            if (!name || !email || !password || !confirm) { //Validasi dari FE jaga"
                alert('Semua field harus diisi.');
                return;
            }

            if (password !== confirm) {
                alert('Password dan konfirmasi tidak sama.');
                return;
            }

            fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: confirm,
                }),
            })
                .then(async (res) => {
                    const data = await res.json();

                    if (!res.ok) {
                        if (data.errors) {
                            const messages = Object.values(data.errors).flat().join('\n');
                            alert(messages);
                        } else {
                            alert(data.message || 'Gagal register.');
                        }
                        return;
                    }
                    alert('Berhasil daftar! Silakan login.');
                    window.location.href = '/login';
                })
                .catch((error) => {
                    console.error(error);
                    alert('Catch gagal');
                });
        });
    </script>


</body>

</html>
