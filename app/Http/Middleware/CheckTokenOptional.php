<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenOptional
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        // Suntikkan token ke header agar Laravel mengenali user
        $request->headers->set('Authorization', 'Bearer ' . $token);
        
        try {
            // Coba ambil user dari guard secara silent (tidak melempar jika tidak tersedia)
            // menggunakan user() yang aman dibandingkan authenticate() yang mungkin tidak ada
            auth()->guard('api')->user();
        } catch (\Exception $e) {
            // Jika terjadi kesalahan (mis. token kadaluwarsa), biarkan saja sebagai guest
        }
    }

    return $next($request);
}
}
