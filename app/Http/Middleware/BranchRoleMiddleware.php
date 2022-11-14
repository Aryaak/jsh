<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BranchRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'branch' && auth()->user()->role !== 'regional' && auth()->user()->role !== 'main') {
            return redirect('/login');
        }

        return $next($request);
    }
}
