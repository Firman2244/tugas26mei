@extends('layouts.admin_layouts') {{-- Gunakan layout sidebar yang sudah ada --}}

@section('title', 'Dashboard Customer')
@section('page_title', 'Dashboard Saya')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-aos="fade-up">
    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-2xl flex items-center justify-center font-bold text-xl">Σ</div>
        <div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pesanan</p>
            <h4 class="text-2xl font-black text-gray-900">{{ $stats['total'] }}</h4>
        </div>
    </div>
    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-50 text-yellow-500 rounded-2xl flex items-center justify-center font-bold text-xl">!</div>
        <div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Menunggu</p>
            <h4 class="text-2xl font-black text-yellow-600">{{ $stats['pending'] }}</h4>
        </div>
    </div>
    <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center font-bold text-xl">✓</div>
        <div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Berhasil</p>
            <h4 class="text-2xl font-black text-green-600">{{ $stats['confirmed'] }}</h4>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
    <div class="p-5 md:p-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6">
    <div class="text-center md:text-left">
        <h3 class="text-lg md:text-xl font-black text-gray-900 tracking-tight">Riwayat Booking Anda</h3>
        <p class="text-[10px] md:text-xs font-bold text-gray-400 mt-1 uppercase tracking-tighter">
            Kelola jadwal tanding timmu di sini
        </p>
    </div>
    
    <a href="{{ route('fields.explore') }}" 
       class="w-full md:w-auto bg-gray-900 text-white px-8 py-3.5 rounded-2xl font-black text-[10px] md:text-xs hover:bg-cyan-500 transition-all flex items-center justify-center gap-2 shadow-xl shadow-gray-200 uppercase tracking-widest">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Cari Lapangan Lagi
    </a>
</div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b">
                    <th class="p-6">Order ID</th>
                    <th class="p-6">Lapangan</th>
                    <th class="p-6 text-center">Jadwal Main</th>
                    <th class="p-6 text-center">Status</th>
                    <th class="p-6 text-center">Pembayaran</th>
                    <th class="p-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-cyan-50/10 transition-colors">
                    <td class="p-6 font-black text-cyan-600 text-sm">#BK-{{ $order->id }}</td>
                    <td class="p-6">
                        <div class="text-sm font-black text-gray-900 uppercase">{{ $order->field->nama_lapangan }}</div>
                        <div class="text-[10px] font-bold text-gray-400 italic">Total: Rp {{ number_format($order->total_harga) }}</div>
                    </td>
                    <td class="p-6 text-center">
                        <div class="text-xs font-bold text-gray-700 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($order->tanggal_main)->format('d M Y') }}</div>
                        <div class="text-[10px] font-black text-cyan-500">{{ $order->jam_mulai }} - {{ $order->jam_selesai }}</div>
                    </td>
                    <td class="p-6 text-center">
                        @php 
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-600', 
                                'confirmed' => 'bg-green-100 text-green-600', 
                                'cancelled' => 'bg-red-100 text-red-600'
                            ]; 
                        @endphp
                        <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $statusColors[$order->status] }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-6 text-center text-xs">
                        <div class="font-bold text-gray-700 italic">{{ $order->payment->metode_bayar ?? 'N/A' }}</div>
                        <span class="text-[9px] font-black {{ ($order->payment->status_pembayaran ?? '') == 'paid' ? 'text-green-500' : 'text-red-400' }} uppercase tracking-tighter">
                            {{ $order->payment->status_pembayaran ?? 'unpaid' }}
                        </span>
                    </td>
                    <td class="p-6 text-center">
                        @if($order->status == 'pending')
                            <button onclick="alert('Pesanan sedang diproses admin. Silakan tunggu.')" class="p-3 bg-gray-50 text-gray-400 rounded-2xl hover:bg-yellow-50 hover:text-yellow-600 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        @else
                             <button onclick="alert('Terima kasih! Pesanan sudah selesai/dikonfirmasi.')" class="p-3 bg-cyan-50 text-cyan-500 rounded-2xl shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 italic text-2xl text-gray-300">?</div>
                            <p class="text-gray-400 font-bold italic tracking-tighter">Anda belum pernah melakukan booking lapangan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50">
        {{ $orders->links() }}
    </div>
</div>
@endsection