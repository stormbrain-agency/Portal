<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PhoneVerify
{
   public function handle(Request $request, Closure $next): Response
   {
        $userEmail = auth()->user()->email;

        if ($userEmail == 'test2fa@demo.com' && Auth::user()->phone_verified == 0) {
        // if (Auth::user()->phone_verified == 0) {
            // dd("middleware phoneverify");
            return redirect(route('verify.phone'));
        }
       return $next($request);
   }
}