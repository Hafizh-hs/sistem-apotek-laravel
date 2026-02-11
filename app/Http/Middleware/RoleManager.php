<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta route
        if (Auth::user()->role !== $role) {
            // Jika bukan admin tapi coba akses menu admin, lempar ke kasir
            return redirect('/kasir')->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }

        return $next($request);
    }
}