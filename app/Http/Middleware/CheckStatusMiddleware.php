<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 

    public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();

    if ($user) {
        if ($user->status == 0) {
            return redirect()->route('censoring');
        } elseif ($user->status == 2) {
            return redirect()->route('rejected');
        }elseif ($user->status == 3) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been disabled');
        } elseif (!$user->isEmailVerified()) {
            return redirect()->route('verification.notice');
        }
    }

    return $next($request);
}

}
