<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request)  $next
     */
    public function handle(Request $request, Closure $next)
    {
          if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK PUNYA AKSES');
        }

        return $next($request);
    }
}
