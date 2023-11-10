<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SendRegisterInfo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Role;
class RegisterNotificationController extends Controller
{   
    public function sendEmail(Request $request)
    {
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
    } 
 
}
