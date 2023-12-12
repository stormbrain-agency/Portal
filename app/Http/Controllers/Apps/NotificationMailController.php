<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\NotificationsEmailDataTable;
use App\Models\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class NotificationMailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NotificationsEmailDataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.notifications-email.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("pages.apps.notifications-email.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_form' => 'required|string|unique:notification_mails,name_form|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'button_title' => 'required|string|max:100',
        ], [
            'name_form.unique' => 'This form has been used.',
        ]);
        $notification = new NotificationMail([
            'name_form' => $request->input('name_form'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'button_title' => $request->input('button_title'),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $notification->save();
        // Notifications::create($request->all());

        return redirect()->route('notification-management.email.create')->with('success', 'Notification added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notification = NotificationMail::find($id);
        if($notification){
            return view('livewire.notifications-email.edit-notifications', compact('notification'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_form' => 'required|string|max:255|unique:notification_mails,name_form,' . $id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'button_title' => 'required|string|max:100',
        ], [
            'name_form.unique' => 'This form has been used.',
        ]);
        $notification = NotificationMail::findOrFail($id);
        $notification->update([
            'name_form' => $request->input('name_form'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'button_title' => $request->input('button_title'),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $notification->save();
        return redirect()->back()->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete(Request $request, string $id)
    {
        $notification = NotificationMail::findOrFail($id);
        $notification->delete();
        // Session::flash('success', 'Notification deleted successfully.');
        return response()->json(['success' => true, 'deleted_notification_id' => $id]);
    }


}
