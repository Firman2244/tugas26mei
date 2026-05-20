<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FutsalArena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Smooth transition untuk sidebar mobile */
        #sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>

<body class="bg-gray-50 lg:flex">

    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 p-6 transform -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen flex flex-col transition-transform duration-300 ease-in-out">
        <div class="mb-10 flex justify-between items-center">
            <span class="text-2xl font-bold text-white tracking-tight">Futsal<span class="text-cyan-500">Arena</span></span>
            <button onclick="toggleSidebar()" class="lg:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>

        <nav class="space-y-2 flex-1">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('*.dashboard') ? 'bg-cyan-500/10 text-cyan-500' : 'text-gray-400 hover:text-white' }} rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                Dashboard
            </a>

            @if(auth()->user()->role === 'admin')
                <div class="px-4 pt-4 pb-2">
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Manajemen</p>
                </div>
                <a href="{{ route('admin.fields') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.fields') ? 'bg-cyan-500/10 text-cyan-500' : 'text-gray-400 hover:text-white' }} rounded-2xl font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    Kelola Lapangan
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.orders') ? 'bg-cyan-500/10 text-cyan-500' : 'text-gray-400 hover:text-white' }} rounded-2xl font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Pesanan Masuk
                </a>
            @endif
        </nav>

        <div class="pt-6 border-t border-white/10 space-y-1">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile') : route('customer.profile') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('*.profile') ? 'bg-cyan-500/10 text-cyan-500' : 'text-gray-400 hover:text-white' }} rounded-2xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Profile
            </a>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-cyan-500 hover:bg-cyan-500/10 rounded-2xl transition-all font-semibold uppercase text-xs tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-4 py-3 w-full text-red-400 hover:bg-red-500/10 rounded-2xl transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 w-full lg:max-w-[calc(100%-18rem)]">
        
        <header class="flex justify-between items-center p-4 md:p-8 bg-white/50 backdrop-blur-md sticky top-0 z-30 lg:static lg:bg-transparent lg:mb-10 lg:p-8" data-aos="fade-down">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 bg-gray-900 text-white rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
                
                <div>
                    <h1 class="text-xl md:text-3xl font-bold text-gray-900 leading-tight">@yield('page_title')</h1>
                    <p class="text-xs md:text-sm text-gray-500 italic hidden sm:block">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-3 bg-white p-1.5 md:p-2 pr-4 md:pr-6 rounded-full shadow-sm border border-gray-100">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold uppercase text-xs md:text-base">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="font-semibold text-gray-700 text-xs md:text-sm capitalize">{{ auth()->user()->role }}</span>
            </div>
        </header>

        <div class="px-4 md:px-8 pb-10">
            @yield('content')
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });

        // Fungsi untuk toggle sidebar di mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>