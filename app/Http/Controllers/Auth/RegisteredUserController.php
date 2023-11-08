<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-up/general.js');

        return view('pages.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_phone' => ['required', 'string', 'max:255'],
            'mobile_phone' => ['required', 'string', 'max:255'],
            'mailing_address' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'string', 'max:255'],
            'county_designation' => ['required', 'string', 'max:255'],
            'w9_file_path' => ['required', 'file', 'mimes:zip'], 


        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp(),
            'business_phone' => $request->business_phone,
            'mobile_phone' => $request->mobile_phone,
            'mailing_address' => $request->mailing_address,
            'vendor_id' => $request->vendor_id,
            'county_designation' => $request->county_designation,
            'status' => 0,

        ]);

        event(new Registered($user));

        return response()->json(['status' => 'success', 'message' => 'successful']);
    }

    public function censoring(){
        return view('pages.auth.censoring');
    }

    public function confirm_email(){
        return view('pages.auth.confirm-email');
    }
}
