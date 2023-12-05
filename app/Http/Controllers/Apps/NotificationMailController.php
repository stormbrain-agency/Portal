<?php

namespace App\Http\Controllers\Apps;

use App\Models\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class NotificationMailController extends Controller
{
        // Mails
        public function index()
        {
            return view("pages.apps.notifications.mail.view_mail");
        }
}
