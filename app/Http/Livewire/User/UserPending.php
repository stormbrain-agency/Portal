<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserPending extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.user.user-pending');
    }

    protected $listeners = [
        'approve_user' => 'approveUser',
        'deny_user' => 'denyUser',
    ];

    public function approveUser($id)
    {
        
        User::where('id', $id)->update(['status' => 1]);

        $this->emit('success', 'User successfully approved');
    }

    public function denyUser($id)
    {
        
        User::where('id', $id)->update(['status' => 2]);
        
        $this->emit('success', 'User successfully denied');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
