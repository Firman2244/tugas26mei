<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Lapangan - FutsalArena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-cyan-500 tracking-tighter">FutsalArena</div>
                
                <div class="hidden lg:flex space-x-8">
                    <a href="/" class="text-gray-400 hover:text-cyan-500 font-semibold transition-colors">Beranda</a>
                    <a href="{{ route('fields.explore') }}" class="text-cyan-500 font-bold">Cari Lapangan</a>
                    <a href="/#partner"
                        class="text-gray-400 hover:text-cyan-500 font-semibold transition-colors">Partner</a>
                </div>

                <div class="flex items-center space-x-2 md:space-x-4">
                    @if(auth()->guard('api')->check())
                        <div class="flex items-center gap-2 md:gap-3 bg-gray-50 px-3 md:px-4 py-2 rounded-2xl border border-gray-100">
                            <div
                                class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xs uppercase">
                                {{ substr(auth()->guard('api')->user()->name, 0, 1) }}
                            </div>
                            <span
                                class="text-gray-700 text-xs font-black hidden sm:block uppercase tracking-tighter">{{ auth()->guard('api')->user()->name }}</span>
                        </div>

                        <a href="{{ auth()->guard('api')->user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard') }}">
                            <button
                                class="bg-cyan-500 text-white px-4 md:px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all font-bold text-xs md:text-sm shadow-lg shadow-cyan-100">
                                Dashboard
                            </button>
                        </a>
                    @else
                        <a href="{{ route('LoginPage') }}"
                            class="text-gray-600 hover:text-gray-900 font-bold text-xs md:text-sm px-2">Masuk</a>
                        <a href="{{ route('RegisterPage') }}">
                            <button
                                class="bg-cyan-500 text-white px-4 md:px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all font-bold text-xs md:text-sm shadow-lg shadow-cyan-100">
                                Daftar
                            </button>
                        </a>
                    @endif

                    <button id="mobile-menu-btn" class="lg:hidden text-gray-400 p-2 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t px-4 py-4 space-y-3 shadow-xl">
            <a href="/" class="block text-gray-600 font-bold px-2 py-1">Beranda</a>
            <a href="{{ route('fields.explore') }}" class="block text-cyan-500 font-bold px-2 py-1">Cari Lapangan</a>
            <a href="/#partner" class="block text-gray-600 font-bold px-2 py-1">Partner</a>
        </div>
    </nav>

    <main class="pt-24 md:pt-32 pb-20 px-4 md:px-10">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col lg:flex-row justify-between items-center mb-10 gap-8">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Explore Lapangan</h1>
                    <p class="text-gray-400 font-medium text-xs md:text-sm mt-1 uppercase tracking-widest italic">Temukan arena terbaikmu hari ini</p>
                </div>

                <form action="{{ route('fields.explore') }}" method="GET" class="w-full lg:w-auto relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lapangan..."
                        class="w-full lg:w-80 pl-12 pr-6 py-4 bg-white border border-gray-100 rounded-[2rem] text-sm shadow-sm outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition-all font-semibold">
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-cyan-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </form>
            </div>

            <div class="flex gap-3 mb-10 overflow-x-auto pb-4 scrollbar-hide">
                <a href="{{ route('fields.explore') }}"
                    class="px-8 py-3 {{ !request('ukuran') ? 'bg-cyan-500 text-white shadow-xl shadow-cyan-100' : 'bg-white text-gray-400 border border-gray-100' }} rounded-full text-[10px] font-black transition-all whitespace-nowrap tracking-widest">SEMUA</a>
                <a href="?ukuran=Besar"
                    class="px-8 py-3 {{ request('ukuran') == 'Besar' ? 'bg-cyan-500 text-white shadow-xl shadow-cyan-100' : 'bg-white text-gray-400 border border-gray-100' }} rounded-full text-[10px] font-black transition-all whitespace-nowrap uppercase tracking-widest">BESAR</a>
                <a href="?ukuran=Sedang"
                    class="px-8 py-3 {{ request('ukuran') == 'Sedang' ? 'bg-cyan-500 text-white shadow-xl shadow-cyan-100' : 'bg-white text-gray-400 border border-gray-100' }} rounded-full text-[10px] font-black transition-all whitespace-nowrap uppercase tracking-widest">SEDANG</a>
                <a href="?ukuran=Kecil"
                    class="px-8 py-3 {{ request('ukuran') == 'Kecil' ? 'bg-cyan-500 text-white shadow-xl shadow-cyan-100' : 'bg-white text-gray-400 border border-gray-100' }} rounded-full text-[10px] font-black transition-all whitespace-nowrap uppercase tracking-widest">KECIL</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @forelse($fields as $field)
                    <div
                        class="bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $field->image_url ? asset('storage/' . $field->image_url) : 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=600' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Type</span>
                                    <span
                                        class="text-[10px] font-black text-gray-900 uppercase italic">{{ $field->tipe_lapangan }}</span>
                                </div>
                                <div class="flex-1 px-4 flex items-center">
                                    <div class="h-[1px] flex-1 bg-gray-100 border-t border-dashed border-gray-300"></div>
                                    <div class="mx-2 text-cyan-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5Z" />
                                        </svg>
                                    </div>
                                    <div class="h-[1px] flex-1 bg-gray-100 border-t border-dashed border-gray-300"></div>
                                </div>
                                <div class="flex flex-col text-right">
                                    <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Field</span>
                                    <span
                                        class="text-[10px] font-black text-gray-900 uppercase italic">{{ $field->ukuran_lapangan }}</span>
                                </div>
                            </div>

                            <h3 class="text-lg font-black text-gray-900 mb-1 leading-tight tracking-tight uppercase">
                                {{ $field->nama_lapangan }}
                            </h3>
                            <p class="text-[10px] font-bold text-gray-400 italic mb-6">Premium Futsal Arena Center</p>

                            <div class="pt-4 border-t border-dashed border-gray-100 flex justify-between items-center">
                                <div>
                                    <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Price / Hour</p>
                                    <p class="text-base md:text-lg font-black text-cyan-500">Rp
                                        {{ number_format($field->harga_per_jam, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('booking.page', $field->id) }}"
                                    class="px-5 py-2.5 bg-gray-900 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-cyan-500 shadow-lg shadow-gray-100 hover:shadow-cyan-100 transition-all">
                                    Booking
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <p class="text-gray-400 font-bold italic">Maaf, lapangan tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-16 flex justify-center">
                {{ $fields->links() }}
            </div>
        </div>
    </main>

    <footer class="bg-white py-20 px-4 md:px-6 border-t border-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-12 md:gap-16">
                <div class="lg:col-span-2">
                    <div class="text-3xl font-black text-cyan-500 mb-8 tracking-tighter uppercase">FutsalArena</div>
                    <p class="text-gray-400 text-sm mb-8 max-w-xs leading-relaxed font-bold">
                        Rasakan pengalaman bertanding di tempat paling indah di planet ini. Booking lapangan favoritmu sekarang.
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

                <div class="space-y-6">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Tentang</h3>
                    <ul class="space-y-4 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Tentang kami</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Fitur</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Berita</a></li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Perusahaan</h3>
                    <ul class="space-y-4 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Mitra Kami</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="font-black text-gray-900 uppercase text-[10px] tracking-[0.3em]">Dukungan</h3>
                    <ul class="space-y-4 text-gray-400 text-sm font-bold">
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Bantuan</a></li>
                        <li><a href="#" class="hover:text-cyan-500 transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-20 pt-8 border-t border-gray-50 text-center">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.4em]">&copy; 2025 FutsalArena International Group</p>
            </div>
        </div>
    </footer>

    <script>
        // Logika Toggle Mobile Menu
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>