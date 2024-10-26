<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getStatesByCountry(Request $request)
    {
        $countryCode = $request->country_code;
        // Fetch states for the selected country
        $states = State::where('country_code', $countryCode)->orderBy('name')->get(['name', 'iso2']);
        // Return response as JSON
        return response()->json($states);
    }

    public function fetchStates(Request $request)
    {
        $countryIso = $request->input('country');
        $states = State::where('country_code', $countryIso)->orderBy('name')->get(['iso2', 'name']);
        return response()->json(['states' => $states]);
    }


}
