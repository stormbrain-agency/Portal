<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\NotificationsDataTable;
use App\Models\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NotificationsDataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.notifications.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("pages.apps.notifications.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $notification = new Notifications([
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'location' => $request->input('where_to_show'),
            'type' => $request->input('type'),
            'schedule_status' => $request->input('schedule_status'),
            'schedule_start' => $request->input('schedule_start'),
            'schedule_end' => $request->input('schedule_end'),
            'status' => $request->input('status'),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        $notification->save();
        // Notifications::create($request->all());

        return redirect()->route('notification-management.create')->with('success', 'Notification added successfully.');
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
        $notification = Notifications::find($id);
        if($notification){
            return view('livewire.notifications.edit-notifications', compact('notification'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notification = Notifications::findOrFail($id);
        $notification->update([
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'location' => $request->input('where_to_show'),
            'type' => $request->input('type'),
            'schedule_status' => $request->input('schedule_status'),
            'schedule_start' => $request->input('schedule_start'),
            'schedule_end' => $request->input('schedule_end'),
            'status' => $request->input('status'),
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
        $notification = Notifications::findOrFail($id);
        $notification->delete();
        // Session::flash('success', 'Notification deleted successfully.');
        return response()->json(['success' => true, 'deleted_notification_id' => $id]);
    }


    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $notification = Notifications::find($id);

        if ($notification) {
            $notification->status = $status;
            $notification->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.']);
    }

    // Mails
    public function viewMails()
    {
        return view("pages.apps.notifications.mail.view_mail");
    }
}
