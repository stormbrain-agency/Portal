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
use Illuminate\Support\Facades\Mail;
use Illuminate\resources\views\mail\emailAuthenticationSuccess;
use Illuminate\Support\Facades\Crypt;
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
            User::where('id', $id)->update(['status' => 1]);
            $user = User::find($id);
            $HashId = Crypt::encrypt($id);
            
            $data = [
                "id" => $user,
                "hash" => $HashId,
                "email" => $user->email, 
            ];
            $user->assignRole('county user');
            $emailAdress = $data['email'];
            Mail::send('mail.emailAuthentication',$data , function ($message) use ($emailAdress) {
                $message->to($emailAdress);
                $message->subject('Confirm Your Account');
            });
            $this->emit('success', 'User successfully approved');
        }else{
            $this->emit('error', 'You do not have permission to perform this action');
        }
    }

    public function MailCheck($token)
    {
        $id = Crypt::decrypt($token);
        User::where('id', $id)->update(['email_verified_at' => now()]);
        $user = User::find($id);
        $data = [
            "id" => $id,
            "email" => $user->email,
            'link' => url('/login'),
        ];
        // $user->assignRole('county user');
        $emailAdress = $data['email'];
        Mail::send('mail.emailAuthenticationSuccess',$data , function ($message) use ($emailAdress) {
            $message->to($emailAdress);
            $message->subject('Confirm Your Account');
        });
        return redirect('/');
    }

    public function denyUser($id)
    {
        if (auth()->user()->can('county users management')) {
            // Delete the user record with the specified ID
            User::destroy($id);

            // Emit a success event with a message
            $this->emit('success', 'User successfully deleted');
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
