@extends('layouts.admin_layouts')

@section('title', 'Profil Saya')
@section('page_title', 'Pengaturan Akun')

@section('content')
    <div class="max-w-4xl mx-auto px-4 md:px-0" data-aos="fade-up">
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6 md:space-y-8">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-2xl mb-4 shadow-sm">
                    <p class="font-bold text-sm uppercase tracking-wider mb-1">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-xs font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div id="alert-success"
                    class="mb-6 flex items-center p-4 rounded-2xl bg-cyan-50 border border-cyan-100 shadow-sm shadow-cyan-50/50"
                    data-aos="fade-down">
                    <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center text-white mr-3 shadow-lg shadow-cyan-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1 italic text-sm font-bold text-cyan-800">
                        {{ session('success') }}
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-cyan-400 hover:text-cyan-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3.5rem] shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-10 pb-8 border-b border-gray-50 text-center sm:text-left">
                    <div class="relative">
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-cyan-500 rounded-[2rem] flex items-center justify-center text-white text-3xl md:text-4xl font-black shadow-xl shadow-cyan-100 uppercase">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 bg-green-500 border-4 border-white w-6 h-6 md:w-8 md:h-8 rounded-full flex items-center justify-center shadow-lg" title="Status Aktif">
                            <svg class="w-3 h-3 md:w-4 md:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-tight">{{ $user->name }}</h3>
                        <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-2">
                            <span class="text-[9px] font-black bg-cyan-50 text-cyan-500 px-3 py-1 rounded-full uppercase tracking-widest border border-cyan-100 italic">Member FutsalArena</span>
                            <span class="text-[9px] font-black bg-gray-50 text-gray-400 px-3 py-1 rounded-full uppercase tracking-widest border border-gray-100 uppercase">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">No. HP (WhatsApp)</label>
                        <div class="relative">
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-cyan-500 opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Ganti Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                        <p class="text-[9px] text-gray-400 font-bold ml-4 italic">* Kosongkan jika tidak ingin mengganti password</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="order-2 sm:order-1 text-center sm:text-left">
                     <p class="text-[10px] font-bold text-gray-400 italic">Terakhir diperbarui: <span class="text-cyan-500">{{ $user->updated_at->diffForHumans() }}</span></p>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto order-1 sm:order-2 bg-cyan-500 text-white px-12 py-5 rounded-[2rem] font-black text-[10px] uppercase tracking-[0.3em] shadow-xl shadow-cyan-100 hover:bg-cyan-600 hover:shadow-cyan-200 transition-all active:scale-95">
                    Simpan Profil Saya
                </button>
            </div>
        </form>
    </div>
@endsection