<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Models\Booking;
use App\Models\payments;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Fields::query();

        if ($request->has('ukuran') && $request->ukuran != 'Semua') {
            $query->where('ukuran_lapangan', $request->ukuran);
        }

        $fields = $query->latest()->limit(6)->get();

        $popularFields = Fields::withCount('bookings') // Asumsi relasi di model Field bernama 'bookings'
        ->orderBy('bookings_count', 'desc')
        ->limit(4)
        ->get();

        if ($request->ajax()) {
            return view('partials.field_list', compact('fields'))->render();
        }

        return view('home', compact(['fields', 'popularFields']));
    }


    public function explore(Request $request)
    {
        $query = Fields::query();

        // Logika Filter jika ada
        if ($request->filled('ukuran')) {
            $query->where('ukuran_lapangan', $request->ukuran);
        }

        if ($request->filled('search')) {
            $query->where('nama_lapangan', 'like', '%' . $request->search . '%');
        }

        $fields = $query->latest()->paginate(12);
        return view('explore', compact('fields'));
    }


    
}
