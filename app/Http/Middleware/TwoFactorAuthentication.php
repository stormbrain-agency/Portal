<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

class TwoFactorAuthentication
{
    public function handle($request, Closure $next)
    {
      
        if (Auth::check() && Session::has('verification_code')) {
           
            $userEnteredCode = $request->input('verification_code');

            if ($userEnteredCode === Session::get('verification_code')) {
                
                Session::forget('verification_code'); 
                return $next($request);
            } else {
              
                return redirect()->back()->with('error', 'Invalid verification code');
            }
        }
        
        return redirect('login');
    }
}