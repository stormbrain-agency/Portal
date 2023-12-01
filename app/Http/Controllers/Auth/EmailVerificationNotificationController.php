<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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

        // $request->user()->sendEmailVerificationNotification();

        $user = $request->user();

        // dd($user);

        $user->email_verification_hash = md5(uniqid());
        $user->save();
        $data = [
            'name' => $user->name,
            'link' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_hash]),
        ];
        try {
            Mail::send('mail.confirm-account', ['data' => $data], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Confirm Your Account');
            });
        } catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
        }

        return back()->with('status', 'verification-link-sent');
    }
}
