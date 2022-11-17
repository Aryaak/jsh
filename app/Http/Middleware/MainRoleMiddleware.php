<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MainRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'main') {
            return redirect('/login');
        }

        return $next($request);
    }
}
