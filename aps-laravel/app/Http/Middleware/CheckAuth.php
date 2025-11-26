<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user') || !session('user')['logged_in']) {
            return redirect()->route('login')->with('error', 'Faça login para acessar o sistema.');
        }

        return $next($request);
    }
}