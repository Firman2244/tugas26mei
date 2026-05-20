@extends('layouts.admin_layouts')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 shadow-cyan-100/50 transition-all hover:shadow-md" data-aos="zoom-in" data-aos-delay="100">
        <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wider">Total Lapangan</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalLapangan }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transition-all hover:shadow-md" data-aos="zoom-in" data-aos-delay="200">
        <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wider">Total Pengguna</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalPengguna }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sm:col-span-2 lg:col-span-1 transition-all hover:shadow-md" data-aos="zoom-in" data-aos-delay="300">
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium uppercase tracking-wider">Total Pendapatan</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
    <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <h3 class="text-lg md:text-xl font-bold text-gray-900">Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders') }}" class="w-full sm:w-auto text-center px-4 py-2 bg-cyan-50 text-cyan-500 font-bold text-xs rounded-xl hover:bg-cyan-500 hover:text-white transition-all">Lihat Semua</a>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-50">
                    <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pemesan</th>
                    <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Lapangan</th>
                    <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jadwal</th>
                    <th class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700 text-sm">
                @forelse($pesananTerbaru as $order)
                <tr class="hover:bg-gray-50/30 transition-colors">
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                        <div class="text-[9px] text-gray-400 font-medium">ID: #BK-{{ $order->id }}</div>
                    </td>
                    <td class="p-4">
                        <span class="text-sm font-semibold">{{ $order->field->nama_lapangan }}</span>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-xs">{{ \Carbon\Carbon::parse($order->tanggal_main)->format('d M Y') }}</div>
                        <div class="text-[10px] text-cyan-500 font-black uppercase">{{ $order->jam_mulai }} - {{ $order->jam_selesai }}</div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-wider 
                            {{ $order->status == 'confirmed' ? 'bg-green-100 text-green-600' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="p-16 text-center text-gray-400 italic font-medium" colspan="4">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            Belum ada pesanan masuk.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection