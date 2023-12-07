<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\DataTables\UsersPendingDataTable;
use App\DataTables\UsersCountyDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeCountyEmail;


class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user) {
            if ($user->status != 1) {
                return redirect()->route('user-management.county-users.show', $user);
            }
            $paymentReports = $user->paymentReport()->orderBy('created_at', 'desc')->get();
            $mracAracs = $user->mracArac()->orderBy('created_at', 'desc')->get();
            $w9Uploads = $user->w9Upload()->orderBy('created_at', 'desc')->get();
            return view('pages.apps.user-management.users.show', compact('user','w9Uploads', 'mracAracs', 'paymentReports'));
        } else {
            return view('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
          
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
    
        $user->delete();

        return redirect()->route('user-management.users.index')->with('success', 'User has been successfully deleted.');

    }

    public function destroyCounty(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
    
        $user->delete();

        return redirect()->route('user-management.county-users.index')->with('success', 'User has been successfully deleted.');

    }

    public function users_pending(UsersPendingDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users-pending.list');
    }

    public function county_users(UsersCountyDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users-county.list');
    }

    public function usersCountyShow($id)
    {
        $user = User::find($id);
        if (isset($user)) {

            $w9Uploads = $user->w9Upload()->orderBy('created_at', 'desc')->get();
            $paymentReports = $user->paymentReport()->orderBy('created_at', 'desc')->get();
            $mracAracs = $user->mracArac()->orderBy('created_at', 'desc')->get();
            if ($user->status == 1) {
                if (!$user->hasRole('county user')) {
                    return redirect()->route('user-management.users.show', $user); 
                }
                return view('pages.apps.user-management.users-county.show', compact('user','w9Uploads', 'paymentReports', 'mracAracs'));
            }else{
                return view('pages.apps.user-management.users-county.show-pending', compact('user','w9Uploads'));
            }
        } else {
            return view('errors.404');
        }
    }

    public function usersPendingShow($id)
    {
        $user = User::find($id);
        if (isset($user)) {
            if ($user->status == 1) {
                return redirect()->route('user-management.users.show', $user);
            }
            $w9Uploads = $user->w9Upload;
            return view('pages.apps.user-management.users-pending.show', compact('user','w9Uploads'));
        } else {
            return view('errors.404');
        }
    }

    public function usersPendingApprove($id)
    {
        if (auth()->user()->can('county users management')) {
            $user = User::find($id);
            if (!is_null($user)) {
                $user->email_verification_hash = md5(uniqid());
                $this->sendVerificationEmail($user);
                $user->assignRole('county user');
                $user->status = 1;
                $user->save();
                return redirect()->route('user-management.county-users.show', $user);
            }else{
                return route('user-management.county-users.index');
            }
        }else{
            return route('user-management.county-users.show', $user);
        }
    }

    public function usersPendingDeny($id)
    {
        if (auth()->user()->can('county users management')) {
             $user = User::find($id);
            if (!is_null($user)) {
               
                $user->status = 2;
                $user->save();
            }

            return redirect()->route('user-management.county-users.index');

        }else{
            return route('user-management.county-users.show', $user);
        }
    }

    public function profile(){
        $user = auth()->user();
        if ($user) {

            $w9Uploads = $user->w9Upload()->orderBy('created_at', 'desc')->get();
            $paymentReports = $user->paymentReport()->orderBy('created_at', 'desc')->get();
            $mracAracs = $user->mracArac()->orderBy('created_at', 'desc')->get();
            return view('pages.apps.user-management.users.profile.profile', compact('user','w9Uploads', 'paymentReports', 'mracAracs'));
        } else {
            return view('errors.404');
        }
    }
    public function profileDetails(){
        $user = auth()->user();
        if ($user) {
            $w9Uploads = $user->w9Upload;
            return view('pages.apps.user-management.users.profile.details');
        } else {
            return view('errors.404');
        }
    }

    protected function sendVerificationEmail(User $user)
    {
        $data = [
            'name' => $user->first_name,
            'link' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_hash]),
        ];
        try {
            Mail::to($user->email)->send(new WelcomeCountyEmail($data));
        } catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
        }
    }
}
