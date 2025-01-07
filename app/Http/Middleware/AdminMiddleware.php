<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        dd(Auth::guard('admin')->user());


        // if (Auth::guard('admin')->check()) {
        //     return $next($request);
        // }

        // return redirect()->route('admin.auth.login')->with('error', 'Access denied! Please log in as an admin.');
    }
}
