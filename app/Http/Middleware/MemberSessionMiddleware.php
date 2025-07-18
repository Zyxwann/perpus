<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MemberSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('member')) {
            return redirect()->route('member.login.form')->with('error', 'Silakan login dulu.');
        }

        return $next($request);
    }
}
