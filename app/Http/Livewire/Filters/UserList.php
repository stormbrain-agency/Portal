<?php

namespace App\Http\Livewire\Filters;

use App\Models\User;
use Livewire\Component;
use Select2;

class UserList extends Component
{
    public $users_filter;

    protected $listeners = [
        'dropdown_search' => 'dropdownSearch'
    ];

    public function mount()
    {
        $this->users_filter = User::where("status", 1)->get();
    }

    public function render()
    {
        return view('livewire.filters/user-list', [
            'users_filter' => $this->users_filter,
        ]);
    }

    public function search()
    {
        $this->users_filter = $this->users_filter->filter(function ($User) {
            return $User->first_name->toLowerCase().includes($this->searchTerm.toLowerCase());
        });
        $this->emit('users_filter-updated');
    }

    public function dropdownSearch($search_item)
    {
        $this->users_filter = User::where('status', 1)
            ->where(function ($query) use ($search_item) {
                $query->where('first_name', 'like', '%' . $search_item . '%')
                    ->orWhere('last_name', 'like', '%' . $search_item . '%');
            })
            ->take(10)
            ->get();
    }

}
