<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\DataTables\UsersPendingDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\resources\views\mail\emailAuthenticationSuccess;

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
            $w9Uploads = $user->w9Upload()->orderBy('created_at', 'desc')->get();
            return view('pages.apps.user-management.users.show', compact('user','w9Uploads'));
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

    public function users_pending(UsersPendingDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users-pending.list');
    }

    public function usersPendingShow($id)
    {
        $user = User::find($id);
        if ($user) {
            $w9Uploads = $user->w9Upload;
            return view('pages.apps.user-management.users-pending.show', compact('user','w9Uploads'));
        } else {
            return view('errors.404');
        }
    }

    public function usersPendingApprove($id)
    {
        if (auth()->user()->can('county users management')) {
            User::where('id', $id)->update(['status' => 1]);
            $user = User::find($id);
            $data = [
                "id" => $user,
                "email" => $user->email,
                'link' => url('/welcome'),
            ];
            $user->assignRole('county user');
            $emailAdress = $data['email'];
            Mail::send('mail.emailAuthentication',$data , function ($message) use ($emailAdress) {
                $message->to($emailAdress);
                $message->subject('Confirm Your Account');
            });
            return redirect()->route('user-management.users.show', $user);
        }else{
            return route('user-management.users-pending.show', $user);
        }
    }

    public function usersPendingDeny($id)
    {
        if (auth()->user()->can('county users management')) {
            User::destroy($id);

            return redirect()->route('user-management.users-pending.index');

        }else{
            return route('user-management.users-pending.show', $user);
        }
    }

    public function profile(){
        $user = auth()->user();

        if ($user) {
            $w9Uploads = $user->w9Upload;
            return view('pages.apps.user-management.users.show', compact('user','w9Uploads'));
        } else {
            return view('errors.404');
        }
    }

    protected function sendVerificationEmail(User $user)
    {
        $data = [
            'name' => $user->name,
            'link' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_hash]),
        ];
        $stormbrainEmail = env('STORMBRAIN', 'support@stormbrain.com');
        Mail::send('mail.confirm-account', ['data' => $data], function ($message) use ($user) {
            $message->to($user->email);
            $message->cc($stormbrainEmail);
            $message->subject('Verify Account');
        });
    }
}
