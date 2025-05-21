<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user_login')) {
            return $next($request);
        }

        // Kiểm tra cookie remember me
        if ($request->cookie('user_login')) {
            // Lấy user_id từ cookie rồi gán lại session
            session(['user_login' => $request->cookie('user_login')]);
            return $next($request);
        }

        // Nếu không có session, cookie thì redirect login
        return redirect()->route('login');
    }
}
