<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - FutsalArena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-pattern {
            background-color: #f0f4ff;
            background-image: radial-gradient(circle at 20% 150%, #dbeafe 0%, transparent 50%),
                radial-gradient(circle at 80% -10%, #eff6ff 0%, transparent 50%);
        }
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center">

    <div class="w-full min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex w-1/2 flex-col justify-between relative overflow-hidden bg-gray-900">

            <img src="https://i.pinimg.com/1200x/6d/3e/a5/6d3ea5bb71fd1d1bc9b45ae364c16a74.jpg" alt="Background"
                class="absolute inset-0 w-full h-full object-cover opacity-80 shadow-2xl">

            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>

            <div class="z-10 p-12 flex flex-col h-full justify-between">
                <div data-aos="fade-down">
                    <span class="text-2xl font-bold text-white drop-shadow-md">FutsalArena</span>
                </div>

                <div></div>

                <div class="z-10" data-aos="fade-up">
                    <p class="text-sm text-gray-200 font-medium drop-shadow-md">© 2025 Sistem Pemesanan FutsalArena</p>
                </div>
            </div>

            <div
                class="absolute -bottom-20 -left-20 w-64 h-64 bg-cyan-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30">
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-24 bg-white">
            <div class="max-w-md w-full" data-aos="fade-left">
                <div class="mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">Masuk</h1>
                    <p class="text-gray-400">Selamat datang kembali!<br>Silakan masukkan detail akun Anda untuk masuk.
                    </p>
                </div>

                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <p style="color: red;">{{ session('error') }}</p>
                @endif

                @if(session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-8">
                    @csrf
                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-2">
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                            class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1">
                    </div>

                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-2">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-semibold text-gray-500 mb-1">Kata Sandi</label>
                        </div>
                        <div class="flex items-center">
                            <input type="password" name="password" placeholder="Masukkan kata sandi"
                                class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="#" class="text-sm font-semibold text-cyan-500 hover:text-cyan-600">Lupa Kata Sandi?</a>

                        <button type="submit"
                            class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-10 rounded-2xl shadow-lg shadow-cyan-100 transition-all transform hover:-translate-y-1 active:scale-95">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-20 text-center">
                    <p class="text-sm text-gray-400">Belum punya akun? <a href="{{ route('RegisterPage') }}"
                            class="text-cyan-600 font-bold hover:underline">Daftar sekarang</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>