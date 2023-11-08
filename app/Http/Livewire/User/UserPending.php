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
        if (auth()->user()->can('county users management')) {
            User::where('id', $id)->update(['status' => 1, 'email_verified_at' => now()]);
            $user = User::find($id);
            $user->assignRole('county user');

            $this->emit('success', 'User successfully approved');
        }else{
            $this->emit('error', 'You do not have permission to perform this action');
        }
    }

    public function denyUser($id)
    {
        if (auth()->user()->can('county users management')) {
            User::where('id', $id)->update(['status' => 2]);
            $this->emit('success', 'User successfully denied');
        }else{
            $this->emit('error', 'You do not have permission to perform this action');
        }
    }

    public function deleteUser($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', 'User cannot be deleted');
            return;
        }

        if (auth()->user()->can('county users management')) {
            // Delete the user record with the specified ID
            User::destroy($id);

            // Emit a success event with a message
            $this->emit('success', 'User successfully deleted');
        }else{
            $this->emit('error', 'You do not have permission to perform this action');
        }

       
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
