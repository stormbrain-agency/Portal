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
        'newPassword' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
        'confirmPassword' => 'required|same:newPassword',
    ];

    protected $messages = [
        'currentPassword.required' => 'Please enter your current password.',
        'newPassword.required' => 'Please enter a new password.',
        'newPassword.min' => 'The new password must be at least 8 characters.',
        'newPassword.regex' => 'The new password must contain at least one letter and one number.',
        'confirmPassword.required' => 'Please confirm the new password.',
        'confirmPassword.same' => 'The new password and confirmation password do not match.',
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
