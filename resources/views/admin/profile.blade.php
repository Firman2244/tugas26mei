@extends('layouts.admin_layouts')

@section('title', 'Profil Admin')
@section('page_title', 'Master Profile Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-0" data-aos="fade-up">
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-2xl mb-6 shadow-sm">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="font-bold text-sm uppercase tracking-wider">Periksa Kembali:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-semibold space-y-1 ml-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div id="alert-success" class="mb-6 flex items-center p-4 rounded-2xl bg-cyan-50 border border-cyan-100 shadow-sm shadow-cyan-50/50" data-aos="fade-down">
            <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center text-white mr-3 shadow-lg shadow-cyan-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1 italic text-sm font-bold text-cyan-800">{{ session('success') }}</div>
            <button onclick="this.parentElement.remove()" class="text-cyan-400 hover:text-cyan-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6 md:space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3.5rem] shadow-sm border border-gray-100">
            
            <div class="flex flex-col sm:flex-row items-center gap-6 mb-10 pb-8 border-b border-gray-50 text-center sm:text-left">
                <div class="relative group">
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-900 rounded-[2rem] flex items-center justify-center text-white text-3xl md:text-4xl font-black shadow-xl shadow-gray-200 uppercase italic">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-cyan-500 text-white p-2 rounded-xl shadow-lg border-4 border-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{ $user->name }}</h3>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-1">
                        <span class="text-[9px] font-black bg-red-50 text-red-500 px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Super Admin</span>
                        <span class="text-[9px] font-black bg-cyan-50 text-cyan-600 px-3 py-1 rounded-full uppercase tracking-widest border border-cyan-100 italic">FutsalArena Team</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Nama Lengkap Admin</label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Email Instansi</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-4 block">Password Baru</label>
                    <div class="relative group">
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-7 py-4 rounded-2xl bg-gray-50 border-2 border-transparent font-bold text-sm focus:bg-white focus:border-cyan-500/20 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <p class="text-[9px] text-gray-400 font-bold ml-4 italic">* Kosongkan jika tidak ingin mengganti password</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-4">
            <p class="text-[10px] font-bold text-gray-400 italic order-2 sm:order-1">Pastikan data yang Anda masukkan sudah benar.</p>
            <button type="submit"
                class="w-full sm:w-auto bg-gray-900 text-white px-12 py-5 rounded-[2rem] font-black text-[10px] uppercase tracking-[0.3em] shadow-xl hover:bg-cyan-600 hover:shadow-cyan-100 transition-all active:scale-95 order-1 sm:order-2">
                Simpan Perubahan Akun
            </button>
        </div>
    </form>
</div>
@endsection