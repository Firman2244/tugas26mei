@extends('layouts.admin_layouts')

@section('title', 'Pesanan Masuk')
@section('page_title', 'Manajemen Reservasi')

@section('content')
@if(session('success'))
<div id="alert-success" class="mb-6 flex items-center p-4 rounded-2xl bg-cyan-50 border border-cyan-100 shadow-sm shadow-cyan-50" data-aos="fade-down">
    <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center text-white mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <div class="flex-1 italic text-sm font-bold text-cyan-800">{{ session('success') }}</div>
    <button onclick="this.parentElement.remove()" class="text-cyan-400 hover:text-cyan-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8" data-aos="fade-up">
    <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</p>
        <h4 class="text-2xl font-black text-gray-900">{{ $stats['total'] }}</h4>
    </div>
    <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm border-l-4 border-l-yellow-400">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pending</p>
        <h4 class="text-2xl font-black text-yellow-600">{{ $stats['pending'] }}</h4>
    </div>
    <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm border-l-4 border-l-green-400">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Confirmed</p>
        <h4 class="text-2xl font-black text-green-600">{{ $stats['confirmed'] }}</h4>
    </div>
    <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm border-l-4 border-l-red-400">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Cancelled</p>
        <h4 class="text-2xl font-black text-red-600">{{ $stats['cancelled'] }}</h4>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-4 mb-6" data-aos="fade-up">
    <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm w-4/5">
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase ml-2 mb-1 block tracking-widest">Rentang Tanggal</label>
            <div class="flex items-center gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-4 py-2 rounded-xl bg-gray-50 border-none text-xs font-bold outline-none focus:ring-2 focus:ring-cyan-500/20">
                <span class="text-gray-300 text-xs">s/d</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-4 py-2 rounded-xl bg-gray-50 border-none text-xs font-bold outline-none focus:ring-2 focus:ring-cyan-500/20">
            </div>
        </div>
        <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-xs font-black hover:bg-gray-800 transition-all">Filter</button>
        @if(request('start_date') || request('search'))
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-red-400 px-2 py-2.5">Reset</a>
        @endif
    </form>

    <button onclick="openModal('modal-tambah-order')" class="bg-cyan-500 text-white px-8 py-4 rounded-[2rem] font-black text-sm hover:bg-cyan-600 shadow-lg shadow-cyan-100 transition-all flex items-center justify-center gap-3 w-1/5">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Input Manual
    </button>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Data Reservasi</h3>
        <form action="{{ route('admin.orders') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/ID..." class="px-5 py-2.5 rounded-xl bg-gray-50 border-none text-sm font-semibold outline-none focus:ring-2 focus:ring-cyan-500/20">
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelanggan</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jadwal</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status Pembayaran</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Bukti</th>
                    <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-cyan-50/10 transition-colors">
                    <td class="p-6 font-black text-cyan-600 text-sm">#BK-{{ $order->id }}</td>
                    <td class="p-6">
                        <div class="text-sm font-black text-gray-900">{{ $order->user->name }}</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $order->field->nama_lapangan }}</div>
                    </td>
                    <td class="p-6 text-center">
                        <div class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($order->tanggal_main)->format('d M Y') }}</div>
                        <div class="text-[10px] font-black text-cyan-500 uppercase">{{ $order->jam_mulai }} - {{ $order->jam_selesai }}</div>
                    </td>
                    <td class="p-6 text-center">
                        @php $colors = ['pending' => 'bg-yellow-100 text-yellow-600', 'confirmed' => 'bg-green-100 text-green-600', 'cancelled' => 'bg-red-100 text-red-600']; @endphp
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $colors[$order->status] }}">
                            {{ $order->status }}
                        </span>
                    </td>
                   <td class="p-6 text-center">
                        @php 
                            $statusBayar = $order->payment->status_pembayaran ?? 'unpaid';
                            $colors = [
                                'unpaid' => 'bg-red-100 text-red-600', 
                                'paid'   => 'bg-green-100 text-green-600',
                            ]; 
                        @endphp

                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $colors[$statusBayar] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $statusBayar }}
                        </span>
                    </td>
                    <td class="p-6 text-center">
                        @if($order->payment && $order->payment->bukti_transfer)
                            <button onclick="showBukti('{{ asset('storage/' . $order->payment->bukti_transfer) }}')" 
                                    class="group relative inline-block">
                                <div class="overflow-hidden rounded-lg w-12 h-12 border border-gray-100 shadow-sm group-hover:border-cyan-500 transition-all">
                                    <img src="{{ asset('storage/' . $order->payment->bukti_transfer) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute inset-0 bg-cyan-500/20 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-all">
                                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                                </div>
                            </button>
                        @else
                            <span class="text-[10px] font-bold text-gray-300 italic uppercase">No File</span>
                        @endif
                    </td>
                    <td class="p-6">
                        <div class="flex justify-center gap-2">
                            <button onclick="showOrderDetail({{ $order->toJson() }}, {{ $order->user->toJson() }}, {{ $order->field->toJson() }}, {{ $order->payment ? $order->payment->toJson() : 'null' }})" 
                                    class="p-2 bg-gray-50 text-indigo-500 rounded-xl hover:bg-indigo-500 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2.5"/>
                                </svg>
                            </button>
                            <button onclick="openEditOrder({{ $order }}, {{ $order->payment }})" class="p-2 bg-gray-50 text-cyan-500 rounded-xl hover:bg-cyan-500 hover:text-white transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">@csrf @method('DELETE')<button type="submit" class="p-2 bg-gray-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-20 text-center text-gray-400 font-bold italic underline">Belum ada pesanan ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-8 border-t border-gray-50">{{ $orders->links() }}</div>
</div>
<div id="modal-tambah-order" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-tambah-order')"></div>

    <div class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all border border-gray-100">
        <div class="absolute top-0 left-0 w-full h-2"></div>

        <div class="p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-2">Input Pesanan Manual</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Booking Langsung Admin</p>
                </div>
                <button onclick="closeModal('modal-tambah-order')"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.orders.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <div class="col-span-1 space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Nama Pelanggan</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-300 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <input type="text" name="nama_pelanggan" placeholder="Nama Tamu..." required 
                            class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300">
                    </div>
                </div>

                <div class="col-span-1 space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Nomor HP (WhatsApp)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-300 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <input type="number" name="no_hp" placeholder="0812..." required 
                            class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300">
                    </div>
                </div>

                <div class="col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Pilih Lapangan</label>
                    <div class="relative">
                        <select name="field_id" required class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none transition-all cursor-pointer">
                            @foreach($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->nama_lapangan }} — Rp {{ number_format($field->harga_per_jam) }}/jam</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Tanggal Main</label>
                    <div class="relative group">
                        <input type="date" name="tanggal_main" required 
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-bold text-gray-700 cursor-pointer transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Metode Bayar</label>
                    <div class="relative">
                        <select name="metode_bayar" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none transition-all cursor-pointer">
                            <option value="Cash">Cash (Ditempat)</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Jam Mulai</label>
                    <div class="relative group">
                        <input type="time" name="jam_mulai" required 
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-black text-gray-700 transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Jam Selesai</label>
                    <div class="relative group">
                        <input type="time" name="jam_selesai" required 
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-black text-gray-700 transition-all">
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 flex flex-col md:flex-row gap-4 pt-4">
                    <button type="button" onclick="closeModal('modal-tambah-order')" 
                        class="order-2 md:order-1 flex-1 py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-red-500 transition-colors uppercase text-xs tracking-[0.2em]">Batal</button>
                    <button type="submit" 
                        class="order-1 md:order-2 flex-[2] py-4 bg-gray-900 text-white rounded-2xl font-black shadow-xl shadow-gray-200 hover:bg-cyan-500 hover:shadow-cyan-200 transition-all duration-300 uppercase text-xs tracking-[0.3em]">
                        Input Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-edit-order" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-edit-order')"></div>

    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all border border-gray-100">
        <div class="absolute top-0 left-0 w-full h-2"></div>

        <div class="p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-2">Update Pesanan</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Kelola Status & Pembayaran</p>
                </div>
                <button onclick="closeModal('modal-edit-order')"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form id="form-edit-order" method="POST" class="space-y-6">
                @csrf 
                @method('PUT')

                <div class="bg-gray-50 rounded-[2rem] p-6 flex justify-between items-center border border-gray-100 shadow-inner">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Tagihan</p>
                        <p id="edit-total" class="font-black text-cyan-600 text-xl tracking-tight"></p>
                    </div>
                    <div class="text-right space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Metode Bayar</p>
                        <p id="edit-metode" class="font-bold text-gray-800 bg-white px-3 py-1 rounded-lg border border-gray-100 inline-block"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Status Reservasi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300 group-focus-within:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <select name="status" id="edit-status-booking" 
                                class="w-full pl-12 pr-10 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-orange-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none transition-all">
                                <option value="pending">🟡 Pending (Menunggu)</option>
                                <option value="confirmed">🟢 Confirmed (Disetujui)</option>
                                <option value="cancelled">🔴 Cancelled (Dibatalkan)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Status Pembayaran</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <select name="status_pembayaran" id="edit-status-pembayaran" 
                                class="w-full pl-12 pr-10 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none transition-all">
                                <option value="unpaid">❌ Unpaid (Belum Bayar)</option>
                                <option value="paid">✅ Paid (Lunas)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="button" onclick="closeModal('modal-edit-order')" 
                        class="order-2 md:order-1 flex-1 py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-red-500 transition-colors uppercase text-xs tracking-[0.2em]">Batal</button>
                    <button type="submit" 
                        class="order-1 md:order-2 flex-[2] py-4 bg-gray-900 text-white rounded-2xl font-black shadow-xl shadow-gray-200 hover:bg-cyan-500 hover:shadow-cyan-200 transition-all duration-300 uppercase text-xs tracking-[0.3em]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-detail-order" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md" onclick="closeModal('modal-detail-order')"></div>
    <div class="relative bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden transform transition-all">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
            <h3 class="text-xl font-black text-gray-900 tracking-tight">Rincian Reservasi</h3>
            <button onclick="closeModal('modal-detail-order')"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
        </div>
        
        <div class="p-8 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div class="grid grid-cols-2 gap-8">
                <div class="col-span-2 md:col-span-1 space-y-4">
                    <p class="text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em]">Data Pelanggan</p>
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Nama</p>
                        <p id="det-nama" class="font-black text-gray-900"></p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-3">Kontak</p>
                        <p id="det-email" class="font-bold text-gray-700 text-sm"></p>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1 space-y-4">
                    <p class="text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em]">Informasi Lapangan</p>
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Nama Arena</p>
                        <p id="det-lapangan" class="font-black text-gray-900"></p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-3">Waktu Main</p>
                        <p id="det-waktu" class="font-bold text-gray-700 text-sm"></p>
                    </div>
                </div>

                <div class="col-span-2 space-y-4">
                    <p class="text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em]">Rincian Biaya & Status</p>
                    <div class="grid grid-cols-3 gap-4 bg-gray-900 p-6 rounded-[2rem] text-white">
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase">Metode</p>
                            <p id="det-metode" class="font-bold text-sm"></p>
                        </div>
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase">Total Bayar</p>
                            <p id="det-total" class="font-black text-lg text-cyan-400"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-gray-400 font-bold uppercase">Status Booking</p>
                            <p id="det-status" class="font-black text-xs uppercase italic"></p>
                        </div>
                    </div>
                </div>

                <div id="det-bukti-section" class="col-span-2 space-y-4 flex flex-col items-center border-t border-dashed border-gray-100 pt-6">
    <p class="text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] w-full text-center">Lampiran Bukti Transfer</p>
    
    <div class="relative group">
        <img id="det-img-bukti" src="" 
             class="max-w-[200px] h-auto rounded-2xl shadow-md border-4 border-white transform transition-transform group-hover:scale-105 cursor-zoom-in"
             onclick="window.open(this.src, '_blank')">
        
        {{-- Tooltip kecil --}}
        <p class="text-[8px] text-gray-400 font-bold text-center mt-2 uppercase tracking-tighter italic">
            Klik gambar untuk memperbesar
        </p>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.body.style.overflow = 'auto'; }
    
    function openEditOrder(order, payment) {
        document.getElementById('form-edit-order').action = `/admin/orders/${order.id}`;
        document.getElementById('edit-metode').innerText = payment ? payment.metode_bayar : 'N/A';
        document.getElementById('edit-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(order.total_harga);
        document.getElementById('edit-status-booking').value = order.status;
        document.getElementById('edit-status-pembayaran').value = payment ? payment.status_pembayaran : 'unpaid';
        openModal('modal-edit-order');
    }


    function showOrderDetail(order, user, field, payment) {
    // Isi data ke modal
    document.getElementById('det-nama').innerText = user.name;
    document.getElementById('det-email').innerText = user.email + (user.no_hp ? ' / ' + user.no_hp : '');
    
    document.getElementById('det-lapangan').innerText = field.nama_lapangan;
    document.getElementById('det-waktu').innerText = `${new Date(order.tanggal_main).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'})} (${order.jam_mulai} - ${order.jam_selesai})`;
    
    document.getElementById('det-metode').innerText = payment ? payment.metode_bayar : 'N/A';
    document.getElementById('det-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(order.total_harga);
    document.getElementById('det-status').innerText = order.status;

    // Logika Gambar Bukti
    const buktiSection = document.getElementById('det-bukti-section');
    const imgBukti = document.getElementById('det-img-bukti');
    
    if (payment && payment.bukti_transfer) {
        buktiSection.classList.remove('hidden');
        imgBukti.src = `/storage/${payment.bukti_transfer}`;
    } else {
        buktiSection.classList.add('hidden');
    }

    openModal('modal-detail-order');
}
</script>
@endsection