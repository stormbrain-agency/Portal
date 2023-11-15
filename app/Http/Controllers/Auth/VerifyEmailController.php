<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    public function verify($id, $hash)
    {
        if (!auth()->check()) {
            $user = User::find($id);

            if (!is_null($user)) {
                if (!$user->isEmailVerified()) {
                    if ($user->email_verification_hash === $hash) {
                        $user->email_verified_at = now();
                        $user->email_verification_hash = null;
                        $user->save();
                        $this->welcome_email($user);


                        return redirect()->route('login')->with('success', 'Email has been successfully verified.');
                    } else {
                        return redirect()->route('login')->with('error', 'The verification link is not valid.');
                    }
                } else {
                    return redirect()->route('login')->with('error', 'Your email has been previously verified.');
                }
            } else {
                return redirect()->route('login')->with('error', 'Invalid user.');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'You are already logged in and your email has been verified.');
        }
    }

    public function welcome_email($user){
        $data = [
            "id" => $user->id,
            "email" => $user->email,
            'link' => url('/login'),
        ];

        $emailAdress = $data['email'];
        Mail::send('mail.welcome-email',['data' => $data] , function ($message) use ($emailAdress) {
            $message->to($emailAdress);
            $message->subject('Account authentication successful');
        });
    }

}
