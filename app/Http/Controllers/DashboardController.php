<?php

namespace App\Http\Controllers;
use App\Models\Notifications;

use App\Models\Notifications;
use Carbon\Carbon;




class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $notifications = Notifications::all();

        return view('pages.dashboards.index', ['notifications' => $notifications]);
    }
}

