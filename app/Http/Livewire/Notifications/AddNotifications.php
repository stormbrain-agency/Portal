<?php

namespace App\Http\Livewire\Notifications;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Notifications;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class AddNotifications extends Component
{
    use WithFileUploads;

    public $notifications_id;
    public $title;
    public $location;
    public $schedule;
    public $type;
    public $status;

    public function render()
    {
        return view('livewire.notifications.add-notifications');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'location' => 'required',
            'schedule' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        $user = Auth::user();
        $notifications = Notifications::create([
            'title' => $this->title,
            'location' => $this->location,
            'schedule' => $this->schedule,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $this->reset();

        $this->emit('success', __('Notifications submitted successfully.'));
    }

}
