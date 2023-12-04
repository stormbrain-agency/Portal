<?php

namespace App\Http\Livewire\Filters;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;;
use Select2;

class UserListID extends Component
{
    public $users_filter;
    public $selectedUserId;

    public function mount(Request $request)
    {
        $this->users_filter = User::where("status", 1)->get();
        $this->selectedUserId = $request->route('user_id');
    }

    public function render()
    {
        return view('livewire.filters/user-list-id', [
            'users_filter' => $this->users_filter,
            'selectedUserId' => $this->selectedUserId,

        ]);
    }

    public function search()
    {
        $this->users_filter = $this->users_filter->filter(function ($User) {
            return $User->first_name->toLowerCase().includes($this->searchTerm.toLowerCase());
        });
        $this->emit('users_filter-updated');
    }
}
