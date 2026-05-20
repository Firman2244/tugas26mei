<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.signin');
    }

    public function showRegister()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'no_hp' => 'required'
            ],
            [
                'name.required' => 'Nama lengkap wajib diisi, jangan dikosongkan!',
                'email.required' => 'Email harus diisi agar bisa masuk.',
                'email.email' => 'Format email yang kamu masukkan salah.',
                'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
                'password.required' => 'Kata sandi tidak boleh kosong.',
                'password.min' => 'Kata sandi minimal harus 8 karakter ya!',
            ]
        );

        // 2. Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'customer'
        ]);

        return redirect()->route('LoginPage')->with('success', 'Akun berhasil dibuat!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // 3. Cek kredensial via JWT Guard
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return back()->with('error', 'Email atau Password salah!');
        }

        // 4. SIMPAN TOKEN KE SESSION (Kunci utama agar Blade mengenali user)
        session(['jwt_token' => $token]);


        return $this->CekLogin();

    // $token = auth()->guard('api')->attempt($credentials);
    // return response()->json(['original_jwt' => $token]);
    }

    public function CekLogin()
    {
        // Mengambil data user yang sedang login melalui guard API
        $user = auth()->guard('api')->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika bukan admin (customer)
        return redirect()->route('customer.dashboard');
    }

    public function logout() {
        auth()->guard('api')->logout();
        session()->forget('jwt_token');
        return redirect()->route('home');
    }
}
