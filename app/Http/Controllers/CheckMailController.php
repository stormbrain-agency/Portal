<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CheckMailController extends Controller
{
    public function MailCheck($email)
    {
        User::where('email', )->update(['email_verified_at' => now()]);
    }
}
