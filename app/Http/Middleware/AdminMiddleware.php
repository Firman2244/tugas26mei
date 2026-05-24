<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki role admin
        $user = $request->user();
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang ke dashboard customer atau login
        return redirect()->route('customer.dashboard')->with('error', 'Akses ditolak! Anda bukan Admin.');
    }
}
