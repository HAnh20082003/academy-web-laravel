<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('user_login')) {
            return redirect()->route('admin.users.index'); // route dashboard của bạn
        }
        return $next($request);
    }
}
