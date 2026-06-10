<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kalau poin sudah 3, ATAU statusnya di database sudah 'banned'
            if ($user->violation_count >= 3 || $user->status === 'banned') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'AKUN DIBLOKIR PERMANEN! Kamu telah menyebarkan tautan Phishing/Malware.');
            }
        }
        return $next($request);
    }
}