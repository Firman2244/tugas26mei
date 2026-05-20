<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\payments;
use App\Models\User;
use App\Models\Fields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil Total Lapangan
        $totalLapangan = Fields::count();

        // 2. Ambil Total Pengguna (Hanya yang rolenya 'user' jika ada)
        $totalPengguna = User::where('role', 'customer')->count();

        // 3. Hitung Total Pendapatan dari Payment yang statusnya 'paid'
        $totalPendapatan = payments::where('status_pembayaran', 'paid')->sum('jumlah_bayar');

        // 4. Ambil 5 Pesanan Terbaru dengan Relasi User dan Field
        $pesananTerbaru = Booking::with(['user', 'field'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalPengguna',
            'totalPendapatan',
            'pesananTerbaru'
        ));
    }






    public function orders(Request $request)
    {
        $query = Booking::with(['user', 'field', 'payment']);

        // Filter berdasarkan Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_main', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan Pencarian Nama/ID
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('id', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(10);

        // Ambil data pendukung untuk modal tambah pesanan
        $users = User::where('role', 'user')->get();
        $fields = Fields::all();

        // Statistik (Tetap sama seperti sebelumnya)
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders', compact('orders', 'stats', 'users', 'fields'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'field_id' => 'required|exists:fields,id',
            'tanggal_main' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'metode_bayar' => 'required',
        ]);

        // Format email otomatis dari No HP agar unik di database
        $emailOtomatis = $request->no_hp . '@manual.com';

        // Ambil atau buat akun berdasarkan No HP
        $user = User::firstOrCreate(
            ['email' => $emailOtomatis],
            [
                'name' => $request->nama_pelanggan,
                'password' => bcrypt('password123'),
                'role' => 'customer'
            ]
        );

        $field = Fields::find($request->field_id);

        // Hitung durasi & total harga
        $mulai = strtotime($request->jam_mulai);
        $selesai = strtotime($request->jam_selesai);
        $durasi = ($selesai - $mulai) / 3600;

        if ($durasi <= 0) {
            return back()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        $total_harga = $field->harga_per_jam * $durasi;

        // Simpan Booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'field_id' => $request->field_id,
            'tanggal_main' => $request->tanggal_main,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_harga' => $total_harga,
            'status' => 'pending'
        ]);

        // Simpan Payment
        Payments::create([
            'booking_id' => $booking->id,
            'metode_bayar' => $request->metode_bayar,
            'jumlah_bayar' => $total_harga,
            'status_pembayaran' => 'unpaid'
        ]);

        return back()->with('success', 'Pesanan manual untuk ' . $request->nama_pelanggan . ' berhasil disimpan!');
    }


    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'status_pembayaran' => 'required|in:unpaid,paid',
        ]);

        $booking = Booking::findOrFail($id);

        // 1. Update status di tabel bookings
        $booking->update([
            'status' => $request->status
        ]);

        // 2. Update status di tabel payments melalui relasi
        if ($booking->payment) {
            $booking->payment->update([
                'status_pembayaran' => $request->status_pembayaran
            ]);
        }

        return back()->with('success', 'Status pesanan #' . $id . ' berhasil diperbarui!');
    }

    public function deleteOrder($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->delete(); // Karena pakai onDelete('cascade'), payment terkait otomatis terhapus

        return back()->with('success', 'Pesanan berhasil dihapus dari sistem.');
    }



    // Menampilkan halaman daftar lapangan
    public function fields()
    {
        $fields = Fields::latest()->select('id', 'nama_lapangan', 'tipe_lapangan', 'harga_per_jam', 'ukuran_lapangan', 'image_url', 'deskripsi')->get();
        return view('admin.fields', compact('fields'));
    }

    // Menyimpan lapangan baru
    public function storeField(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'tipe_lapangan' => 'required|in:Matras,Sintetis,Vintl',
            'ukuran_lapangan' => 'required|in:Besar,Sedang,Kecil',
            'harga_per_jam' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('fields', 'public');
        }

        Fields::create($data);
        return back()->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function updateField(Request $request, $id)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'tipe_lapangan' => 'required|in:Matras,Sintetis,Vintl',
            'ukuran_lapangan' => 'required|in:Besar,Sedang,Kecil',
            'harga_per_jam' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $field = Fields::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada foto baru
            if ($field->image_url) {
                Storage::disk('public')->delete($field->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('fields', 'public');
        }

        $field->update($data);
        return back()->with('success', 'Data lapangan berhasil diperbarui!');
    }

    // Menghapus lapangan
    public function deleteField($id)
    {
        $field = Fields::findOrFail($id);
        if ($field->image_url) {
            Storage::disk('public')->delete($field->image_url);
        }
        $field->delete();
        return back()->with('success', 'Lapangan berhasil dihapus!');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
