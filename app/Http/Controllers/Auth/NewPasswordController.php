<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->has('first_login')) {
            $firstLogin = $request->input('first_login');

            if ($request->has('email')) {
                $user = User::where('email', $request->input('email'))->first();
                if ($user) {
                    if ($user->status == 3) {
                        Auth::logout();
                        return redirect()->route('login')->with('error', 'Your account has been disabled');
                    }
                    if ($user->first_login != $firstLogin) {
                        return redirect()->route('dashboard')->with('error', 'Your email has been previously verified.');
                    }
                }
            }
        }
       
        return view('pages.auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[A-Za-z]/', $value) || !preg_match('/\d/', $value)) {
                        $fail(__('The :attribute must contain at least one letter and one number.', ['attribute' => $attribute]));
                    }
                },
            ],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                if ($user->status == 3) {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Your account has been disabled');
                }

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                if ($user->first_login == true || $user->first_login == 1) {
                    $user->first_login = false;
                    $user->email_verified_at = now();
                    $user->email_verification_hash = null;
                    $user->save();
                    Auth::login($user);
                }

                event(new PasswordReset($user));
            }
        );
        $request->session()->forget('url.intended');
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
