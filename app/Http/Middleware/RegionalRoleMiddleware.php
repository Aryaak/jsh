<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegionalRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'regional' && auth()->user()->role !== 'main') {
            return redirect('/login');
        }

        return $next($request);
    }
}
