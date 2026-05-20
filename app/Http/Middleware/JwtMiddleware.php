<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah ada token di session
        if (!session()->has('jwt_token')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            // 2. Ambil token dari session
            $token = session()->get('jwt_token');

            // 3. Masukkan token ke Header secara otomatis agar terbaca oleh sistem Auth
            $request->headers->set('Authorization', 'Bearer ' . $token);

            // 4. Validasi apakah tokennya masih aktif atau sudah kadaluwarsa
            $user = JWTAuth::parseToken()->authenticate();
            
        } catch (Exception $e) {
            // Jika token bermasalah (kadaluwarsa/salah), hapus session dan tendang ke login
            session()->forget('jwt_token');
            return redirect()->route('login')->with('error', 'Sesi anda telah berakhir.');
        }

        return $next($request);
    }
}
