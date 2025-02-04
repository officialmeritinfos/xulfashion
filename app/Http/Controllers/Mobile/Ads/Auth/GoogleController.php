<?php

namespace App\Http\Controllers\Mobile\Ads\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    use Helpers;
    //redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    //handle google callback
    public function handleGoogleCallback(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();


            if ($finduser){
                Auth::login($finduser);
                $finduser->update([
                    'loggedIn' => 1,
                ]);

                //check if user has completed account
                if ($finduser->completedProfile!=1){
                    $url = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.settings.complete-profile.socialite');
                }else{
                    $url = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.landing-page');
                }
                //notify of login
                $this->notifyLogin($request, $finduser);

            }else{
                if (Cookie::has('hasAdsCountry')){
                    $country = Country::where('iso3', Cookie::get('hasAdsCountry'))->first();
                    $countryName = $country->name;
                    $currency = $country->currency;
                }else{
                    $countryName = null;
                    $currency = null;
                }
                $newUser = User::updateOrCreate(['email' => $user->email],[
                    'name' => $user->name,
                    'google_id'=> $user->id,
                    'reference' => $this->generateUniqueId('users','reference'),
                    'username' => $user->getNickname()??textToSlug($user->name),
                    'country' => $countryName,
                    'mainCurrency' => $currency,
                    'email_verified_at' => now(),
                    'countryCode' => Cookie::get('hasAdsCountry'),
                    'loggedIn' => 1,
                    'photo' => $user->getAvatar(),
                ]);
                // Initialize User Settings
                $this->initializeUserSettings($newUser);
                //log user in to complete their profile
                Auth::login($newUser);

                $url = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.settings.complete-profile.socialite');

            }

            DB::commit();

            //return to intended url or  to complete profile
            return redirect()->intended($url);

        }catch (\Exception $exception){
            DB::rollBack();
            logger('Error authenticating with Google: '.$exception->getMessage());

            return redirect()->route('mobile.login')->with('error','Something went wrong while authenticating your request. Please try again.');
        }
    }
}
