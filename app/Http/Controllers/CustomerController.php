<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Models\Booking;
use App\Models\payments;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $userId = auth()->guard('api')->id();

        // Ambil pesanan milik user ini saja
        $orders = Booking::with(['field', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        // Statistik sederhana untuk user
        $stats = [
            'total' => Booking::where('user_id', $userId)->count(),
            'pending' => Booking::where('user_id', $userId)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('user_id', $userId)->where('status', 'confirmed')->count(),
        ];

        return view('customer.dashboard', compact('orders', 'stats'));
    }



    public function bookingPage($id)
    {
        $field = Fields::findOrFail($id);

        // Ambil pesanan yang sudah ada (Pending & Confirmed)
        $existingBookings = Booking::where('field_id', $id)
            // Ambil yang statusnya confirmed ATAU pending
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('tanggal_main', '>=', now()->toDateString())
            ->orderBy('tanggal_main')
            ->orderBy('jam_mulai')
            ->get();

        return view('booking', compact('field', 'existingBookings'));
    }

    public function storeBooking(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'tanggal_main' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'metode_bayar' => 'required|in:Cash,Transfer',
            'bukti_transfer' => 'required_if:metode_bayar,Transfer|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Hitung Durasi dan Validasi Jam
        $mulai = strtotime($request->jam_mulai);
        $selesai = strtotime($request->jam_selesai);
        $durasiJam = ($selesai - $mulai) / 3600;

        if ($durasiJam <= 0) {
            return back()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        // Kita cek apakah ada booking yang tumpang tindih (overlap)
        $isBooked = Booking::where('field_id', $request->field_id)
            ->where('tanggal_main', $request->tanggal_main)
            ->where('status', '!=', 'cancelled') // Booking yang dibatalkan tidak dianggap bentrok
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    // Jam mulai baru berada di antara jadwal yang sudah ada
                    $q->where('jam_mulai', '<=', $request->jam_mulai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                })
                    ->orWhere(function ($q) use ($request) {
                        // Jam selesai baru berada di antara jadwal yang sudah ada
                        $q->where('jam_mulai', '<', $request->jam_selesai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    })
                    ->orWhere(function ($q) use ($request) {
                        // Jadwal baru menelan jadwal yang sudah ada secara keseluruhan
                        $q->where('jam_mulai', '>=', $request->jam_mulai)
                            ->where('jam_selesai', '<=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Maaf, lapangan ini sudah dibooking pada jam tersebut. Silakan pilih jadwal lain.');
        }

        // --- SELESAI LOGIKA CEK BENTROK ---

        // 3. Ambil Data Lapangan & Hitung Total Harga
        $field = Fields::findOrFail($request->field_id);
        $totalHarga = $field->harga_per_jam * $durasiJam;

        // 4. Simpan ke Tabel Bookings
        $booking = Booking::create([
            'user_id' => auth()->guard('api')->id(),
            'field_id' => $request->field_id,
            'tanggal_main' => $request->tanggal_main,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_harga' => $totalHarga,
            'status' => 'pending'
        ]);

        // 5. Handle Bukti Transfer
        $pathBukti = null;
        if ($request->hasFile('bukti_transfer')) {
            $pathBukti = $request->file('bukti_transfer')->store('bukti_bayar', 'public');
        }

        // 6. Simpan ke Tabel Payments
        payments::create([
            'booking_id' => $booking->id,
            'metode_bayar' => $request->metode_bayar,
            'jumlah_bayar' => $totalHarga,
            'bukti_transfer' => $pathBukti,
            'status_pembayaran' => ($request->metode_bayar === 'Transfer') ? 'paid' : 'unpaid'
        ]);

        return back()->with('success', 'Booking berhasil! Menunggu konfirmasi admin.');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('customer.profile', compact('user'));
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

        return back()->with('success', 'Profil Customer berhasil diperbarui!');
    }
}
