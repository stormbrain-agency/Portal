<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $user = $request->user();


        $user->email_verification_hash = md5(uniqid());
        $user->save();
        $data = [
            'name' => $user->first_name,
            'link' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_hash]),
        ];
        try {
            Mail::to($user->email)->send(new VerifyEmail($data));
        } catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
        }

        return back()->with('status', 'verification-link-sent');
    }
}
