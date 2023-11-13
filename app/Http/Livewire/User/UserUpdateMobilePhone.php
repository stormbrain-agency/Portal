<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserUpdateMobilePhone extends Component
{
    public $newMobilePhone;
    public $currentMobilePhone;

    protected $rules = [
        'newMobilePhone' => 'required|numeric|unique:users,mobile_phone',
    ];

    public function mount()
    {
        $this->currentMobilePhone = Auth::user()->mobile_phone;
    }

    public function render()
    {
        return view('livewire.user.user-update-mobile-phone');
    }

    public function submit()
    {
        $this->validate();

        Auth::user()->update([
            'mobile_phone' => $this->newMobilePhone,
        ]);

        $this->emit('success', __('Mobile phone number updated successfully.'));
        $this->reset(['newMobilePhone']);
    }
}