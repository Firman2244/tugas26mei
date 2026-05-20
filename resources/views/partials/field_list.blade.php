@forelse($fields as $field)
{{-- Logika Penentuan URL: Jika login ke booking, jika tidak ke login --}}
@php
    $targetUrl = auth()->guard('api')->check() 
                 ? route('booking.page', $field->id) 
                 : route('LoginPage');
@endphp

<a href="{{ $targetUrl }}" class="group cursor-pointer block" data-aos="zoom-in">
    <div class="relative overflow-hidden rounded-[2rem] mb-4 shadow-lg shadow-gray-200/50">
        <img src="{{ $field->image_url ? asset('storage/' . $field->image_url) : 'https://via.placeholder.com/600x400' }}"
            class="w-full h-64 object-cover transform group-hover:scale-110 transition-all duration-500">
        
        {{-- Overlay Hover --}}
        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
             <span class="bg-white text-gray-900 px-6 py-2 rounded-full font-black text-[10px] uppercase tracking-widest shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform">
                {{ auth()->guard('api')->check() ? 'Booking Sekarang' : 'Login Untuk Booking' }}
             </span>
        </div>

        <div class="absolute top-4 left-4">
            <span class="px-4 py-1.5 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-widest text-gray-900 rounded-full shadow-sm">
                {{ $field->tipe_lapangan }}
            </span>
        </div>
    </div>

    <div class="flex justify-between items-start px-2">
        <div>
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-cyan-500 transition-colors uppercase">
                {{ $field->nama_lapangan }}
            </h3>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-tighter">Ukuran {{ $field->ukuran_lapangan }}</p>
        </div>
        <div class="text-right">
            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Per Jam</p>
            <p class="text-lg font-black text-gray-900 group-hover:text-cyan-500 transition-colors">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}</p>
        </div>
    </div>
</a>
@empty
<div class="col-span-full text-center py-20">
    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/></svg>
    </div>
    <p class="text-gray-400 italic font-bold">Tidak ada lapangan kategori ini.</p>
</div>
@endforelse