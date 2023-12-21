<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\WelcomeCountyEmail;
use Illuminate\Support\Facades\Password;
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
        $loggedInUserId = auth()->id();
        if ($loggedInUserId == $id) {
            $user = User::find($id);
    
            if (!$user->isEmailVerified()) {
                if ($user->email_verification_hash === $hash) {
                    $user->email_verified_at = now();
                    $user->email_verification_hash = null;
                    $user->save();
                    if($user->first_login == true || $user->first_login == 1){
                        $token = Password::createToken($user);
                        $user->first_login = false;
                        $user->save();
                        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email]);
                    }
                    return redirect()->route('dashboard')->with('success', 'Email has been successfully verified.');
                } else {
                    return redirect()->route('verification.notice')->with('error', 'The verification link is not valid.');
                }
            } else {
                return redirect()->route('dashboard')->with('error', 'Your email has been previously verified.');
            }
        }else{
            return redirect()->route('verification.notice')->with('error', 'The verification link is not valid.');
        }
    }

    public function verify_first_login($id, $hash, $first_login)
    {
        if (isset($first_login) && $first_login == true) {
            $user = User::find($id);
            if (isset($user)) {
                if (!$user->isEmailVerified()) {
                    if ($user->email_verification_hash === $hash) {
                        if($user->first_login == true || $user->first_login == 1){
                            $token = Password::createToken($user);
                            return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email]);
                        }else{
                            return redirect()->route('login')->with('error', 'Your email has been previously verified.');
                        }
                    } else {
                        return redirect()->route('verification.notice')->with('error', 'The verification link is not valid.');
                    }
                }else {
                    if (auth()->check()) {
                        return redirect()->route('dashboard')->with('error', 'Your email has been previously verified.');
                    } else {
                        return redirect()->route('login')->with('error', 'Your email has been previously verified.');
                    }
                }
            }else{
                return redirect()->route('login')->with('error', 'User not found.');
            }
        }else{
            return redirect()->route('login')->with('error', 'Link is incorrect.');
        }
    
    }
    public function welcome_email($user){
        $data = [
            "id" => $user->id,
            "email" => $user->email,
            "name" => $user->first_name,
            'link' => url('/login'),
        ];

        $emailAdress = $data['email'];
        try {
            Mail::to($emailAdress)->send(new WelcomeCountyEmail($data));  
        }catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
        }
    }
}
