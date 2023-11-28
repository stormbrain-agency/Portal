<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->status == 0) {
            return redirect()->route('censoring');
        }
        if ($request->user() && $request->user()->status == 2) {
            return redirect()->route('rejected');
        }
        if ($request->user() && !$request->user()->isEmailVerified()) {
            return redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
