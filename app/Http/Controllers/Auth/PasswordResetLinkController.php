<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // addJavascriptFile('assets/js/custom/authentication/reset-password/reset-password.js');

        return view('pages.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);
 
        $user = User::where('email', $request->email)->first();
        
        dd(config('app.url'));
        if ($user) {
            $token = Password::createToken($user);
            $actionUrl = url(route('password.reset', ['token' => $token, 'email' => $request->email], false));

            Mail::to($request->email)->send(new ResetPasswordMail($actionUrl));

            return back()->with(['status' => __('Password reset email sent.')]);
        } else {
            return back()->withErrors(['email' => __('User not found.')]);
        }
    }
}
