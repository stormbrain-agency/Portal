<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\County;

class LocationController extends Controller
{
    public function getStates()
    {
        $states = State::all();

        return $states;
    }

  public function getCountiesByState($stateId)
    {
        $counties = County::where('state_id', $stateId)->get();

        if ($counties->isEmpty()) {
            return response()->json(['message' => 'No counties found for the selected state']);
        }
        return response()->json($counties);
    }


}
