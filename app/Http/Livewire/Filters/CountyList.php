<?php

namespace App\Http\Livewire\Filters;

use App\Models\County;
use Livewire\Component;
use Select2;

class CountyList extends Component
{
    public $counties;
    public $searchTerm;

    public function mount()
    {
        $this->counties = County::all();
        // $this->counties = County::take(4)->get();
    }

    public function render()
    {
        return view('livewire.filters/county-list', [
            'counties' => $this->counties,
        ]);
    }

    public function search()
    {
        $this->counties = $this->counties->filter(function ($county) {
            return $county->county->toLowerCase().includes($this->searchTerm.toLowerCase());
        });
        $this->emit('counties-updated');
    }
}
