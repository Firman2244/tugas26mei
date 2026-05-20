<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - FutsalArena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

                <div data-aos="fade-right" data-aos-delay="200">
                    <h2 class="text-4xl font-bold text-white mb-4">Bergabunglah dengan Komunitas Futsal Terbesar</h2>
                    <p class="text-gray-200 opacity-80 max-w-sm">Dapatkan akses ke lapangan terbaik dan turnamen
                        eksklusif di kota Anda.</p>
                </div>

                <div class="z-10" data-aos="fade-up">
                    <p class="text-sm text-gray-200 font-medium drop-shadow-md">© 2025 Sistem Pemesanan FutsalArena</p>
                </div>
            </div>

            <div
                class="absolute -bottom-20 -left-20 w-64 h-64 bg-cyan-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30">
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-16 lg:p-24 bg-white overflow-y-auto">
            <div class="max-w-md w-full my-auto" data-aos="fade-left">
                <div class="mb-10">
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">Daftar Akun</h1>
                    <p class="text-gray-400">Silakan lengkapi data diri Anda untuk memulai petualangan di FutsalArena.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm"
                        data-aos="fade-in">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-1">
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                            class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1"
                            required>
                    </div>

                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-1">
                        <label class="block text-sm font-semibold text-gray-500 mb-1">No. WhatsApp / HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789"
                            class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1"
                            required>
                    </div>

                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-1">
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email aktif"
                            class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1"
                            required>
                    </div>

                    <div
                        class="group relative border-b border-gray-200 focus-within:border-cyan-500 transition-all pb-1">
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Kata Sandi</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full bg-transparent text-gray-800 outline-none placeholder:text-gray-300 py-1"
                            required>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-100 transition-all transform hover:-translate-y-1 active:scale-95">
                            Daftar Akun
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-sm text-gray-400">Sudah punya akun? <a href="{{ route('LoginPage') }}"
                            class="text-cyan-600 font-bold hover:underline">Masuk sekarang</a></p>
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