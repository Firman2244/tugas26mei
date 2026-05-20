<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $field->nama_lapangan }} - FutsalArena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-[#F8FAFC]">

    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-cyan-500 tracking-tighter">FutsalArena</div>

                <div class="hidden lg:flex space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-400 hover:text-cyan-500 font-semibold transition-colors">Beranda</a>
                    <a href="/#jelajahi_lapangan" class="text-gray-400 hover:text-cyan-500 font-semibold">Cari
                        Lapangan</a>
                    <a href="/#partner" class="text-gray-400 hover:text-cyan-500 font-semibold">Partner</a>
                </div>

                <div class="flex items-center space-x-2 md:space-x-4">
                    @auth('api')
                        <div
                            class="flex items-center gap-2 md:gap-3 bg-gray-50 px-3 md:px-4 py-2 rounded-2xl border border-gray-100">
                            <div
                                class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xs uppercase">
                                {{ substr(auth()->guard('api')->user()->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700 text-xs font-black hidden sm:block uppercase tracking-tighter">
                                {{ explode(' ', auth()->guard('api')->user()->name)[0] }}
                            </span>
                        </div>
                        <a
                            href="{{ auth()->guard('api')->user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard') }}">
                            <button
                                class="bg-cyan-500 text-white px-4 md:px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all font-bold text-xs md:text-sm shadow-lg shadow-cyan-100">
                                Dashboard
                            </button>
                        </a>
                    @endauth

                    @guest('api')
                        <a href="{{ route('LoginPage') }}"
                            class="text-gray-600 hover:text-gray-900 font-bold text-xs md:text-sm px-2">Masuk</a>
                        <a href="{{ route('RegisterPage') }}">
                            <button
                                class="bg-cyan-500 text-white px-4 md:px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all font-bold text-xs md:text-sm shadow-lg shadow-cyan-100">
                                Daftar
                            </button>
                        </a>
                    @endguest

                    <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t px-4 py-4 space-y-3 shadow-xl">
            <a href="{{ route('home') }}" class="block text-gray-600 font-bold">Beranda</a>
            <a href="/#jelajahi_lapangan" class="block text-gray-600 font-bold">Cari Lapangan</a>
            <a href="/#partner" class="block text-gray-600 font-bold">Partner</a>
        </div>
    </nav>

    <main class="pt-24 md:pt-32 pb-20 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 md:mb-12 gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Booking Lapangan</h1>
                    <p class="text-gray-400 font-medium text-xs md:text-sm mt-1 uppercase tracking-widest italic">Segera
                        sebelum kehabisan slot hari ini</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">

                <div class="lg:col-span-7 space-y-8 md:space-y-10">

                    <div class="relative group">
                        <div class="overflow-hidden rounded-[2.5rem] md:rounded-[3.5rem] shadow-2xl shadow-gray-200">
                            <img src="{{ $field->image_url ? asset('storage/' . $field->image_url) : 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?q=80&w=1200' }}"
                                class="w-full h-[300px] md:h-[500px] object-cover group-hover:scale-105 transition-transform duration-1000">
                        </div>

                        <div
                            class="relative lg:absolute -mt-16 lg:mt-0 lg:bottom-8 lg:left-8 lg:right-8 p-6 md:p-8 glass rounded-[2rem] md:rounded-[2.5rem] border border-white/40 shadow-xl mx-4 lg:mx-0">
                            <div
                                class="flex flex-col md:flex-row justify-between items-center md:items-end gap-4 text-center md:text-left">
                                <div>
                                    <span
                                        class="px-4 py-1.5 bg-cyan-500 text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-lg mb-3 inline-block shadow-lg shadow-cyan-500/30">
                                        {{ $field->tipe_lapangan }}
                                    </span>
                                    <h1
                                        class="text-2xl md:text-4xl font-black text-gray-900 leading-none uppercase tracking-tight">
                                        {{ $field->nama_lapangan }}
                                    </h1>
                                    <p
                                        class="text-gray-500 font-bold mt-2 flex items-center justify-center md:justify-start gap-2 text-xs">
                                        <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                stroke-width="2.5" />
                                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5" />
                                        </svg>
                                        Premium Arena, Indonesia
                                    </p>
                                </div>
                                <div class="bg-white/50 px-6 py-3 rounded-2xl border border-white hidden md:block">
                                    <p class="text-[9px] font-black text-gray-400 uppercase text-center mb-1">Ukuran</p>
                                    <p class="text-base font-black text-gray-900 uppercase">
                                        {{ $field->ukuran_lapangan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3
                                    class="text-lg md:text-xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                                    <span
                                        class="w-10 h-10 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" />
                                        </svg>
                                    </span>
                                    Jadwal Terisi
                                </h3>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($existingBookings as $booked)
                                <div class="flex items-center p-4 bg-gray-50 rounded-3xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 bg-white rounded-xl flex flex-col items-center justify-center border border-gray-100 shadow-sm mr-4">
                                        <span
                                            class="text-[8px] font-black text-cyan-500 uppercase">{{ \Carbon\Carbon::parse($booked->tanggal_main)->format('M') }}</span>
                                        <span
                                            class="text-sm font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($booked->tanggal_main)->format('d') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Waktu</p>
                                        <p class="text-xs font-black text-gray-800">{{ $booked->jam_mulai }} -
                                            {{ $booked->jam_selesai }}</p>
                                    </div>
                                    <span
                                        class="text-[8px] font-black bg-red-100 text-red-500 px-2 py-1 rounded-md uppercase tracking-tighter">Booked</span>
                                </div>
                            @empty
                                <div
                                    class="col-span-full py-10 text-center bg-cyan-50/50 rounded-3xl border-2 border-dashed border-cyan-100">
                                    <p class="text-cyan-600 font-bold italic text-sm">Semua jam masih tersedia!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div
                        class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3.5rem] shadow-2xl shadow-cyan-900/5 border border-gray-50 lg:sticky lg:top-32">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 pb-8 border-b border-dashed border-gray-100">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 tracking-tight">Form Reservasi</h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Lengkapi
                                    data booking</p>
                            </div>
                            <div class="sm:text-right">
                                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Harga / Jam
                                </p>
                                <p class="text-xl font-black text-cyan-500">Rp
                                    {{ number_format($field->harga_per_jam, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-5">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field->id }}">

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Tanggal
                                        Main</label>
                                    <input type="date" name="tanggal_main" id="tanggal_main" required
                                        class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none font-bold text-sm focus:ring-4 focus:ring-cyan-500/10 outline-none">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" required
                                            class="w-full px-4 py-4 rounded-2xl bg-gray-50 border-none font-bold text-sm focus:ring-4 focus:ring-cyan-500/10 outline-none text-center">
                                    </div>
                                    <div>
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" required
                                            class="w-full px-4 py-4 rounded-2xl bg-gray-50 border-none font-bold text-sm focus:ring-4 focus:ring-cyan-500/10 outline-none text-center">
                                    </div>
                                </div>

                                @if(session('success'))
                                    <div class="mb-6 flex items-center p-4 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm shadow-emerald-50/50 animate-bounce-short">
                                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white mr-3 shadow-lg shadow-emerald-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 italic text-sm font-bold text-emerald-800">
                                            {{ session('success') }}
                                        </div>
                                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="max-w-7xl mx-auto px-4 mt-4">
                                        <div
                                            class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center gap-3 shadow-sm shadow-red-100">
                                            <div class="text-red-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-red-800 font-bold text-sm">{{ session('error') }}</p>
                                        </div>
                                    </div>
                                @endif

                                
                            </div>

                            <div class="pt-4 border-t border-dashed border-gray-100">
                                <label
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Metode
                                    Bayar</label>
                                <select name="metode_bayar" id="metode_bayar" required
                                    class="w-full px-6 py-4 mt-1 rounded-2xl bg-gray-50 border-none font-bold text-sm focus:ring-4 focus:ring-cyan-500/10 outline-none appearance-none cursor-pointer">
                                    <option value="Cash">Cash (Bayar di Tempat)</option>
                                    <option value="Transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <div id="bukti_transfer_container" class="hidden animate-pulse">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Bukti
                                    Transfer</label>
                                <div class="relative mt-1">
                                    <input type="file" name="bukti_transfer" id="bukti_transfer"
                                        class="w-full px-6 py-4 rounded-2xl bg-cyan-50/50 border-2 border-dashed border-cyan-100 font-bold text-xs text-cyan-600 file:hidden cursor-pointer">
                                </div>
                            </div>

                            <div class="p-5 bg-gray-50 rounded-3xl border border-gray-100">
                                <div class="flex justify-between items-center pt-2">
                                    <p class="text-[10px] font-black text-cyan-500 uppercase tracking-widest">Total
                                        Bayar</p>
                                    <p id="display_total" class="text-xl font-black text-cyan-500">Rp 0</p>
                                    <input type="hidden" name="jumlah_bayar" id="jumlah_bayar" value="0">
                                </div>
                            </div>

                            @if(auth()->guard('api')->check())
                                <button type="submit" id="btn-submit-booking"
                                    class="w-full py-5 bg-gray-900 text-white rounded-[2rem] font-black uppercase tracking-[0.2em] text-[10px] shadow-2xl hover:bg-cyan-500 transition-all active:scale-95">
                                    <span id="text-normal">Konfirmasi Reservasi</span>
                                    <span id="text-loading" class="hidden">Sedang Memproses...</span>
                                </button>
                            @else
                                <a href="{{ route('LoginPage') }}"
                                    class="block w-full py-5 bg-gray-100 text-gray-400 text-center rounded-[2rem] font-black uppercase tracking-[0.2em] text-[10px]">
                                    Login Untuk Booking
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-white py-16 px-4 md:px-6 border-t border-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-16">
                <div class="lg:col-span-2">
                    <div class="text-3xl font-black text-cyan-500 mb-6 tracking-tighter uppercase">FutsalArena</div>
                    <p class="text-gray-400 text-sm mb-8 max-w-xs leading-relaxed font-bold">
                        Rasakan pengalaman bertanding di tempat terbaik. Booking lapangan favoritmu sekarang juga.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>

                        <a href="#"
                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>

                        <a href="#"
                            class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .018 5.394 0 12.03c0 2.12.551 4.189 1.597 6.048L0 24l6.103-1.602a11.83 11.83 0 005.94 1.583h.006c6.635 0 12.028-5.394 12.031-12.03a11.79 11.79 0 00-3.483-8.508z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Tentang</h3>
                    <ul class="space-y-2 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Tentang kami</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Fitur</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Perusahaan</h3>
                    <ul class="space-y-2 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Mitra Kami</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Dukungan</h3>
                    <ul class="space-y-2 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Bantuan</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-gray-50 text-center">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.4em]">&copy; 2025 FutsalArena
                    International Group</p>
            </div>
        </div>
    </footer>

    <script>
        const jamMulai = document.getElementById('jam_mulai');
        const jamSelesai = document.getElementById('jam_selesai');
        const metodeBayar = document.getElementById('metode_bayar');
        const buktiContainer = document.getElementById('bukti_transfer_container');
        const displayTotal = document.getElementById('display_total');
        const inputTotal = document.getElementById('jumlah_bayar');
        const hargaPerJam = {{ $field->harga_per_jam }};
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle Mobile Menu
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // 1. Tampilkan/Sembunyikan Bukti Transfer
        metodeBayar.addEventListener('change', function () {
            if (this.value === 'Transfer') {
                buktiContainer.classList.remove('hidden');
            } else {
                buktiContainer.classList.add('hidden');
            }
        });

        // 2. Hitung Total Harga Otomatis
        function hitungTotal() {
            if (jamMulai.value && jamSelesai.value) {
                const start = new Date(`2024-01-01 ${jamMulai.value}`);
                const end = new Date(`2024-01-01 ${jamSelesai.value}`);
                let diff = (end - start) / (1000 * 60 * 60);

                if (diff > 0) {
                    const total = diff * hargaPerJam;
                    displayTotal.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                    inputTotal.value = total;
                } else {
                    displayTotal.innerText = 'Rp 0';
                    inputTotal.value = 0;
                }
            }
        }

        jamMulai.addEventListener('change', hitungTotal);
        jamSelesai.addEventListener('change', hitungTotal);



        document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit-booking');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById('text-normal').classList.add('hidden');
        document.getElementById('text-loading').classList.remove('hidden');
    });
    </script>
</body>

</html>