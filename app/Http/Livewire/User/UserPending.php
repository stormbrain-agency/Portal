<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
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
        'delete_user' => 'deleteUser',
    ];

    public function approveUser($id)
    {
        if (auth()->user()->can('county users management')) {
            $user = User::find($id);
            if (!is_null($user)) {
                $user->email_verification_hash = md5(uniqid());
                $this->sendVerificationEmail($user);
                $user->assignRole('county user');
                $user->status = 1;
                $user->save();
                $this->emit('success', 'User successfully approved');
            }
        }else{
            $this->emit('error', 'You do not have permission to perform this action');
        }
    }

    protected function sendVerificationEmail(User $user)
    {
        $data = [
            'name' => $user->name,
            'link' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_hash]),
        ];
        try {
            Mail::send('mail.confirm-account', ['data' => $data], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Confirm Your Account');
            });
        } catch (\Exception $e) {
            Log::error('Error sending email to user: ' . $e->getMessage());
        }

    }

    public function denyUser($id)
    {
        if (auth()->user()->can('county users management')) {
             $user = User::find($id);
            if (!is_null($user)) {
               
                $user->status = 2;
                $user->save();
                $this->emit('success', 'User has been successfully rejected');
            }
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
