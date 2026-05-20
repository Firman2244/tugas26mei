@extends('layouts.admin_layouts')

@section('title', 'Kelola Lapangan')
@section('page_title', 'Manajemen Lapangan')

@section('content')

    @if(session('success'))
        <div id="alert-success"
            class="mb-6 flex items-center p-4 rounded-2xl bg-cyan-50 border border-cyan-100 shadow-sm shadow-cyan-50"
            data-aos="fade-down">
            <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center text-white mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-cyan-800">{{ session('success') }}</p>
            </div>
            <button onclick="closeAlert()" class="text-cyan-400 hover:text-cyan-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div data-aos="fade-right">
            <h2 class="text-xl font-bold text-gray-800">Daftar Lapangan Aktif</h2>
            <p class="text-sm text-gray-500 italic">Total {{ $fields->count() }} lapangan tersedia untuk disewa</p>
        </div>
        <button onclick="openModal('modal-tambah')"
            class="bg-cyan-500 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-cyan-600 shadow-lg shadow-cyan-100 transition-all flex items-center justify-center gap-3 group"
            data-aos="fade-left">
            <div class="bg-white/20 p-1 rounded-lg group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            Tambah Lapangan Baru
        </button>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Informasi Lapangan</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Spesifikasi</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-widest">Harga Sewa</th>
                        <th class="p-6 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($fields as $field)
                        <tr class="hover:bg-cyan-50/30 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-24 h-16 rounded-xl overflow-hidden bg-gray-100 shadow-inner">
                                        <img src="{{ asset('storage/' . $field->image_url) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $field->nama_lapangan }}</h4>
                                        <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ $field->deskripsi }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="text-[10px] font-black px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full uppercase tracking-tighter">
                                        {{ $field->tipe_lapangan }}
                                    </span>
                                    <span
                                        class="text-[10px] font-black px-3 py-1 bg-gray-100 text-gray-600 rounded-full uppercase tracking-tighter">
                                        {{ $field->ukuran_lapangan }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900">Rp
                                        {{ number_format($field->harga_per_jam, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium italic">per 60 menit</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center gap-2">
                                    <button onclick="editField({{ $field }})"
                                        class="p-2 text-cyan-500 hover:bg-cyan-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.fields.delete', $field->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus lapangan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-400 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all active:scale-90">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center text-gray-400 italic">Belum ada data lapangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal tambah -->
    <div id="modal-tambah" class="fixed inset-0 hidden z-999 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-tambah')"></div>

    <div class="relative bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all border border-gray-100">
        <div class="absolute top-0 left-0 w-full h-2 bg-linear-to-r from-cyan-400 to-blue-500"></div>

        <div class="p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-2">Tambah Lapangan</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Informasi Arena Baru</p>
                </div>
                <button onclick="closeModal('modal-tambah')"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Nama Lapangan</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <input type="text" name="nama_lapangan" placeholder="Contoh: Arena Pro A" required
                                class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Tipe Rumput</label>
                        <div class="relative">
                            <select name="tipe_lapangan"
                                class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none">
                                <option value="Matras">Rumput Matras</option>
                                <option value="Sintetis">Rumput Sintetis</option>
                                <option value="Vinyl">Lantai Vinyl</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Ukuran</label>
                        <div class="relative">
                            <select name="ukuran_lapangan"
                                class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none">
                                <option value="Besar">Besar (Internasional)</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Kecil">Kecil</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Harga / Jam</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-black group-focus-within:text-cyan-500 transition-colors">Rp</span>
                            </div>
                            <input type="number" name="harga_per_jam" placeholder="0" required
                                class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-black text-gray-700">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Foto Lapangan</label>
                        <div id="preview-container"
                            class="hidden mb-3 relative w-full h-32 rounded-2xl overflow-hidden border-2 border-cyan-500 shadow-inner">
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                            <button type="button" onclick="resetImage()"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-xl shadow-lg hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <label for="imageInput" id="label-input"
                            class="w-full flex items-center gap-3 px-5 py-4 rounded-2xl bg-cyan-50 border-2 border-dashed border-cyan-200 cursor-pointer hover:bg-cyan-100 hover:border-cyan-300 transition-all">
                            <div class="p-2 bg-white rounded-xl shadow-sm">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span class="text-xs font-black text-cyan-700 uppercase tracking-tighter" id="fileName">Pilih Foto...</span>
                        </label>
                        <input type="file" name="image_url" id="imageInput" accept="image/*" class="hidden" required onchange="previewImage(this)">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Fasilitas & Deskripsi</label>
                        <textarea name="deskripsi" placeholder="Sebutkan fasilitas (Wifi, Locker, dll)..." rows="3" required
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-semibold text-gray-700 resize-none transition-all"></textarea>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="button" onclick="closeModal('modal-tambah')"
                        class="order-2 md:order-1 flex-1 py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-red-500 transition-colors uppercase text-xs tracking-[0.2em]">Batal</button>
                    <button type="submit"
                        class="order-1 md:order-2 flex-[2] py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-cyan-500 hover:shadow-cyan-200 transition-all duration-300 uppercase text-xs tracking-[0.3em]">
                        Simpan Lapangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- modal edit -->
    <div id="modal-edit" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-edit')"></div>

    <div class="relative bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all border border-gray-100">
        <div class="absolute top-0 left-0 w-full h-2"></div>

        <div class="p-8 md:p-10">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-2">Edit Lapangan</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Perbarui Informasi Arena</p>
                </div>
                <button onclick="closeModal('modal-edit')"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form id="form-edit" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Nama Lapangan</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <input type="text" name="nama_lapangan" id="edit-nama" required
                                class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all font-bold text-gray-700 placeholder:text-gray-300">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Tipe Rumput</label>
                        <div class="relative">
                            <select name="tipe_lapangan" id="edit-tipe"
                                class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none">
                                <option value="Matras">Rumput Matras</option>
                                <option value="Sintetis">Rumput Sintetis</option>
                                <option value="Vinyl">Lantai Vinyl</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Ukuran</label>
                        <div class="relative">
                            <select name="ukuran_lapangan" id="edit-ukuran"
                                class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-bold text-gray-700 appearance-none">
                                <option value="Besar">Besar (Internasional)</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Kecil">Kecil</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Harga / Jam</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-400 font-black group-focus-within:text-cyan-500 transition-colors">Rp</span>
                            </div>
                            <input type="number" name="harga_per_jam" id="edit-harga" required
                                class="w-full pl-12 pr-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-black text-gray-700">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Foto Lapangan (Opsional)</label>
                        <div id="preview-container-edit" class="hidden mb-3 relative w-full h-32 rounded-2xl overflow-hidden border-2 border-cyan-500 shadow-inner">
                            <img id="image-preview-edit" src="#" alt="Preview" class="w-full h-full object-cover">
                            <button type="button" onclick="resetImageEdit()"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-xl shadow-lg hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <label for="imageInputEdit" id="label-input-edit"
                            class="w-full flex items-center gap-3 px-5 py-4 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 cursor-pointer hover:bg-cyan-50 hover:border-cyan-200 transition-all text-gray-400 hover:text-cyan-600">
                            <div class="p-2 bg-white rounded-xl shadow-sm">
                                <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-tighter" id="fileNameEdit">Klik ganti foto...</span>
                        </label>
                        <input type="file" name="image_url" id="imageInputEdit" accept="image/*" class="hidden" onchange="previewImageEdit(this)">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-1">Deskripsi</label>
                        <textarea name="deskripsi" id="edit-deskripsi" rows="3" required
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-cyan-500 focus:bg-white outline-none font-semibold text-gray-700 resize-none transition-all"></textarea>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="button" onclick="closeModal('modal-edit')"
                        class="order-2 md:order-1 flex-1 py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-red-500 transition-colors uppercase text-xs tracking-[0.2em]">Batal</button>
                    <button type="submit"
                        class="order-1 md:order-2 flex-[2] py-4 bg-gray-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-gray-200 hover:bg-cyan-500 hover:shadow-cyan-200 transition-all duration-300 uppercase text-xs tracking-[0.3em]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function closeAlert() {
            const alert = document.getElementById('alert-success');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }

        // Auto close alert setelah 3 detik
        setTimeout(() => {
            closeAlert();
        }, 3000);


        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Image Preview Logic
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const labelInput = document.getElementById('label-input');
        const fileNameText = document.getElementById('fileName');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    labelInput.classList.remove('py-4');
                    labelInput.classList.add('py-2');
                    fileNameText.textContent = "Ganti Foto";
                }
                reader.readAsDataURL(file);
            }
        });

        function resetImage() {
            imageInput.value = "";
            previewContainer.classList.add('hidden');
            labelInput.classList.remove('py-2');
            labelInput.classList.add('py-4');
            fileNameText.textContent = "Pilih Foto...";
        }

        function editField(field) {
            // Set Action Form URL secara dinamis
            const form = document.getElementById('form-edit');
            form.action = `/admin/fields/${field.id}`;

            // Isi data ke dalam input modal
            document.getElementById('edit-nama').value = field.nama_lapangan;
            document.getElementById('edit-tipe').value = field.tipe_lapangan;
            document.getElementById('edit-ukuran').value = field.ukuran_lapangan;
            document.getElementById('edit-harga').value = field.harga_per_jam;
            document.getElementById('edit-deskripsi').value = field.deskripsi;

            // Buka Modal
            openModal('modal-edit');
        }
    </script>
@endsection