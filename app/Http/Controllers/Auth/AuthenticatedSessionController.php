<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');

        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $checkUser = $request->user();
        if (!$checkUser) {
            return redirect()->route('login')->withErrors(['notfounduser' => 'Login information is incorrect']);
        }
        if ($checkUser) {
            $request->session()->regenerate();
            
            $request->user()->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);
            
            return redirect()->intended(RouteServiceProvider::HOME);
        
        }
    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        \App\Models\User::where('id', Auth::user()->id)
        ->update([
            'phone_verified' => false
        ]);

        Auth::guard('web')->logout();

        $request->session()->forget('url.intended');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
