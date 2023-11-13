<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserUpdatePassword extends Component
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    protected $rules = [
        'currentPassword' => 'required',
        'newPassword' => 'required|min:8|different:currentPassword',
        'confirmPassword' => 'required|same:newPassword',
    ];

    public function render()
    {
        return view('livewire.user.user-update-password');
    }

    public function submit()
    {
        // $this->emit('success', __('Password updated successfully.'));

        $this->validate();

        if (!Hash::check($this->currentPassword, Auth::user()->password)) {
            $this->addError('currentPassword', 'Current password is incorrect.');
            // $this->emit('success', __('Password updated successfully.'));
            // $this->emit('error', 'You do not have permission to edit!');
            return;
        }
        Auth::user()->update([
            'password' => Hash::make($this->newPassword),
        ]);

        // session()->flash('success', 'Password updated successfully.');
        $this->emit('success', __('Password updated successfully.'));
        $this->reset(['currentPassword', 'newPassword', 'confirmPassword']);
    }
}
