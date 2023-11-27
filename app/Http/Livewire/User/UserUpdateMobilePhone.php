<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserUpdateMobilePhone extends Component
{
    public $newMobilePhone;
    public $currentMobilePhone;

    protected $rules = [
        'newMobilePhone' => ['required', 'string', 'max:255', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/', 'unique:users,mobile_phone'],
    ];

    protected $messages = [
        'newMobilePhone.regex' => 'Please use the format (XXX) XXX-XXXX.',
    ];

    public function mount()
    {
        $this->currentMobilePhone = Auth::user()->getFormattedMobilePhoneAttribute();
    }

    public function render()
    {
        return view('livewire.user.user-update-mobile-phone');
    }

    public function submit()
    {
        $this->validate();
        $cleanedMobilePhoneNumber = str_replace(['(', ')', ' ', '-'], '', $this->newMobilePhone);
        Auth::user()->update([
            'mobile_phone' => $cleanedMobilePhoneNumber,
        ]);

        $this->emit('success', __('Mobile phone number updated successfully.'));
        $this->reset(['newMobilePhone']);
    }
}