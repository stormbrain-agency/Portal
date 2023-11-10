<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersPendingDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        return view('pages.apps.user-management.users.show', compact('user'));
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
        //
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
            return view('errors.user_not_found');
        }
    }

    public function usersPendingApprove($id)
    {
        if (auth()->user()->can('county users management')) {
            User::where('id', $id)->update(['status' => 1, 'email_verified_at' => now()]);
            $user = User::find($id);
            $user->assignRole('county user');

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
}
