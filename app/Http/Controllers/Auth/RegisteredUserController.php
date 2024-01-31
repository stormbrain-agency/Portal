<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\State;
use App\Models\County;
use App\Models\W9Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Mail\RegisterEmail;


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
        $states = State::all();
        $counties = County::where("state_id", "=", "CA")->orderBy('county')->get();

        return view('pages.auth.register', compact('counties', 'states'));
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
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
            'business_phone' => ['required', 'string', 'max:255'],
            // 'mobile_phone' => ['required', 'string', 'max:255'],
            'mailing_address' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'string', 'max:255'],
            'county_designation' => ['required', 'string', 'max:255'],
        ]);

        $cleanedBusinessPhoneNumber = str_replace(['(', ')', ' ', '-'], '', $request->input('business_phone'));

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp(),
            'business_phone' => $cleanedBusinessPhoneNumber,
            'mailing_address' => $request->input('mailing_address'),
            'vendor_id' => $request->input('vendor_id'),
            'county_designation' => $request->input('county_designation'),
            'status' => 0,
        ]);

        $user->assignRole('county user');
        $userID = $user->id;

        $direct_sign_up_mail = env('SIGN_UP_MAIL', 'srp@cdasd.org');

        $county_designation = $user->county?->county;
        // Send Mail
        $adminEmails = User::whereHas('roles', function ($query) {
        $query->where('name', 'admin');
        })->pluck('email');

        $adminEmails[] = $direct_sign_up_mail;
        $data = [
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request -> input('email'),
            'county_designation' => $county_designation,
            'link' => url('/user-management/county-users/user/'. $userID .''),
            'time' => Carbon::now()->format('H:i:s - m/d/Y '),
            'list_mail' => $adminEmails,
        ];
        $dataMail = $data['list_mail'];

        foreach($dataMail as $emailAdress){
            try {
                Mail::to($emailAdress)->send(new RegisterEmail($data));
            } catch (\Exception $e) {
                Log::error('Error sending email to admins: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success', 'message' => 'successful']);
    }

    public function censoring(){
        return view('pages.auth.censoring');
    }

    public function confirm_email(){
        return view('pages.auth.confirm-email');
    }

    public function rejected(){
        return view('pages.auth.rejected');
    }
}
