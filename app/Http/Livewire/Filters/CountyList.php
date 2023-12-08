<?php

namespace App\Http\Livewire\Filters;

use App\Models\County;
use Livewire\Component;
use Select2;

class CountyList extends Component
{
    public $counties;
    public $searchTerm;
    public $counties_filter;
    public $selectedCounty;
    

    protected $listeners = [
        'dropdown_search_county' => 'dropdownSearchCounty',
        'option_selected' => 'optionSelected',
    ];

    public function mount()
    {
        $this->counties = County::all();
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

    public function dropdownSearchCounty($search_item)
    {
        if ($search_item == "") {
            $this->counties_filter = County::take(20)->get();
        }else{
            $this->counties_filter  = County::where('county', 'like', '%' . $search_item . '%')
                ->take(20)
                ->get();
        }

        $this->emit('dropdownSearchCountyResponse', $this->counties_filter);
    }

    public function optionSelected($selectedValue)
    {
        // dd($selectedValue);
        $this->selectedCounty = $selectedValue;
    }
}
