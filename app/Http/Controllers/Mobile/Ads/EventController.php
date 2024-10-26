<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class EventController extends BaseController
{
    //landing page
    public function landingPage(Request $request)
    {
        // Fetch General Settings
        $web = GeneralSetting::find(1);

        // Country Resolution Logic
        $countryIso = $this->resolveCountryIso($request);
        $hasCountry = $countryIso ? 1 : 2;

        // Fetch Country and Update Session
        $country = $this->getCountryByIso($countryIso);
        if ($country) {
            $this->updateCountrySession($country);
        }

        $countrySearch = $request->input('country', $country->iso2 ?? null);
        $query = $request->input('query');
        $state = $request->input('state');

        // Set Page Name
        $pageName = $hasCountry === 1 ? 'Fashion Events in ' . $country->name : 'Fashion Events';

        // Retrieve Countries List
        $countries = Country::where('status', 1)->get();

        // Filter Events
        $events = UserEvent::query()
            ->where('status', 1)
            ->when($countrySearch, fn($q) => $q->where('country', $countrySearch))
            ->when($state, fn($q) => $q->where('state', $state))
            ->when($query, fn($q) => $q->where('title', 'like', '%' . $query . '%'))
            ->latest()
            ->paginate(1);

        // Handle AJAX Request
        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.events.components.event_lists', compact('events', 'country', 'countries'))->render(),
                'nextPage' => $events->currentPage() + 1,
                'hasMorePages' => $events->hasMorePages(),
            ]);
        }

        return view('mobile.ads.events.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$pageName,
            'country'       =>$country,
            'events'        =>$events,
            'countries'     =>Country::where('status',1)->get(),
            'countrySearch' =>$countrySearch
        ]);
    }
    //event detail
    public function eventDetail(Request $request, $eventId)
    {

    }

    /**
     * Resolve Country ISO based on request or cache
     */
    private function resolveCountryIso(Request $request)
    {
        // Check if country is passed in request
        if ($request->has('country')) {
            $country = Country::where('iso2', $request->input('country'))->first();
            return $country->iso3 ?? null;
        }
        // If country not in cache, get from Location API
        if (!Cache::has('hasAdsCountry')) {
            $position = config('location.testing.enabled') ? Location::get() : Location::get($request->ip());
            $countryIso = optional(Country::where('iso2', $position->countryCode)->first())->iso3;
            Cache::put('hasAdsCountry', $countryIso, now()->addDays(7));
            return $countryIso;
        }
        // Retrieve country from cache
        return Cache::get('hasAdsCountry');
    }
    /**
     * Get Country by ISO
     */
    private function getCountryByIso($countryIso)
    {
        return $countryIso ? Country::where('iso3', strtoupper($countryIso))->first() : null;
    }

    /**
     * Update Country Session
     */
    private function updateCountrySession($country)
    {
        session([
            'country' => $country->iso2,
            'iso3' => $country->iso3,
        ]);
    }
}
