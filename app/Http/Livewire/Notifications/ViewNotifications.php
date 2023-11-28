<?php

namespace App\Http\Livewire\Notifications;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
class ViewNotifications extends Component
{
    public $notifications_id;
    public $title;
    public $location;
    public $schedule;
    public $type;
    public $status;

    protected $listeners = [
        'view_notifications' => 'viewNotifications',
    ];


    public function render()
    {
        return view('livewire.notifications.view-notifications');
    }

    public function viewNotifications($id){
        $notifications = Notifications::find($id);

        if (isset($notifications)) {
            $this->title = $notifications->title;
            $this->location = $notifications->location;
            $this->schedule = $notifications->schedule_start . 'to' . $notifications->schedule_end;
            $this->type = $notifications->type;
            $this->status = $notifications->status;
        }
    }

}
