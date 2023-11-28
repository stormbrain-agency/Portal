<?php

namespace App\Http\Livewire\Notifications;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationStatus extends Component
{
    public $notification;
    public $isChecked;

    public function mount(Notifications $notification)
    {
        $this->notification = $notification;
        $this->isChecked = $this->notification->status === 'active';
    }

    public function toggleStatus()
    {
        $this->notification->status = $this->isChecked ? 'inactive' : 'active';
        $this->notification->save();
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.notifications.notification-status');
    }
}


