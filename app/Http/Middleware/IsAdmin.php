<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // 1. Tambahkan import ini di atas

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Tambahkan trim() untuk membuang spasi yang tidak sengaja terketik di database
        if (Auth::check() && trim(strtolower(Auth::user()->role)) === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, tendang ke halaman depan!
        return redirect('/')->with('error', 'Hayo, kamu bukan admin ya! 🕵️‍♂️');
    }
}