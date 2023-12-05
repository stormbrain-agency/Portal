<?php

namespace App\Http\Livewire\NotificationsEmail;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\NotificationMail;
use Illuminate\Support\Facades\Auth;
class EditNotifications extends Component
{
    public $notifications_id;
    public $title;
    public $message;
    public $location;
    public $schedule;
    public $type;
    public $status;

    protected $listeners = [
        'edit_notifications' => 'editNotifications',
    ];


    public function render()
    {
        return view('livewire.notifications.edit-notifications');
    }

    public function editNotifications($id){
        $notifications = NotificationMail::find($id);

        if (isset($notifications)) {
            $this->title = $notifications->title;
            $this->message = $notifications->message;
            $this->location = $notifications->location;
            $this->schedule = $notifications->schedule_start . 'to' . $notifications->schedule_end;
            $this->type = $notifications->type;
            $this->status = $notifications->status;
        }
    }

}
