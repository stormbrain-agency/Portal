<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\State;
use App\Models\W9Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


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

        return view('pages.auth.register', compact('states'));
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_phone' => ['required', 'string', 'max:255'],
            'mobile_phone' => ['required', 'string', 'max:255'],
            'mailing_address' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'string', 'max:255'],
            'county_designation' => ['required', 'string', 'max:255'],
            'w9_file_path' => ['required', 'file', 'mimes:zip'], 


        ]);

        if ($request->hasFile('w9_file_path')) {
            $file = $request->file('w9_file_path');
            
            if ($file->getClientOriginalExtension() === 'zip') {
                $originalName = $file->getClientOriginalName();
                
                $counter = 0;
                $uniqueName = $originalName;
                
                while (file_exists(storage_path('app/uploads/' . $uniqueName))) {
                    $counter++;
                    $pathInfo = pathinfo($originalName);
                    $uniqueName = $pathInfo['filename'] . "($counter)." . $pathInfo['extension'];
                }
                $path = $file->storeAs('uploads', $uniqueName, 'local');

                $user = User::create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp(),
                    'business_phone' => $request->input('business_phone'),
                    'mobile_phone' => $request->input('mobile_phone'),
                    'mailing_address' => $request->input('mailing_address'),
                    'vendor_id' => $request->input('vendor_id'),
                    'county_designation' => $request->input('county_designation'),
                    'status' => 0,
                ]);
                // Send Mail
                $id = DB::table('users')->max('id');
                $adminEmails = User::whereHas('roles', function ($query) {
                    $query->where('name', 'admin');
                })->pluck('email');
                $data = [
                    'name' => $request -> input('name'),
                    'email' => $request -> input('email'),
                    'county_designation' => $request -> input('county_designation'),
                    'link' => url('/user-management/users/'. $id .''), 
                    'time' => Carbon::now()->format('H:i:s - m/d/Y '),
                    'list_mail' => $adminEmails,
                ];
                $dataMail = $data['list_mail'];
                foreach($dataMail as $emailAdress){
                    Mail::send('mail.emailRegister', $data, function ($message) use ($emailAdress) {
                        $message->to($emailAdress);
                        $message->subject('Alert: County User Registration - Approval
                        Needed!');
                    });
                }
                //
                $userID = $user->id;

                $newFile = new W9Upload();
                $newFile->date = now();
                $newFile->country = $request->county_designation;
                $newFile->user_id = $userID; 
                $newFile->original_name = $uniqueName;
                $newFile->save();

                // event(new Registered($user));
                return response()->json(['status' => 'success', 'message' => 'successful']);
            } else{
                return response()->json(['status' => 'error', 'message' => 'Error with W-9 File Upload']);
            }


        }
    }

    public function censoring(){
        return view('pages.auth.censoring');
    }

    public function confirm_email(){
        return view('pages.auth.confirm-email');
    }
}
