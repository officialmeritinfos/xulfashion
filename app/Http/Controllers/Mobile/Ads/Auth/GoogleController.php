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
            // Try to retrieve user from Google
            try {
                $googleUser = Socialite::driver('google')->user();
            } catch (\Exception $e) {
                Log::error('Google authentication failed: ' . $e->getMessage(), [
                    'request' => $request->all()
                ]);
                return redirect()->route('mobile.login')->with('error', 'Google authentication failed. Please try again.');
            }

            // Ensure the Google response contains an email
            if (empty($googleUser->email)) {
                Log::error('Google authentication failed: No email returned', [
                    'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                ]);
                return redirect()->route('mobile.login')->with('error', 'Google did not return an email. Try another method.');
            }

            // Attempt to find existing user
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if ($user) {
                // User exists, log them in
                Auth::login($user,true);
                $user->update(['loggedIn' => 1]);

                // Determine redirection URL
                $url = Cookie::has('redirect') ? Cookie::get('redirect') :
                    ($user->completedProfile != 1 ? route('mobile.user.profile.settings.complete-profile.socialite') : route('mobile.user.profile.landing-page'));

                // Notify login
                $this->notifyLogin($request, $user);
            } else {
                // New user registration
                $countryData = null;
                if (Cookie::has('hasAdsCountry')) {
                    $countryData = Country::where('iso3', Cookie::get('hasAdsCountry'))->first();
                }

                $newUser = User::create([
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'reference' => $this->generateUniqueId('users', 'reference'),
                    'username' => $googleUser->getNickname() ?? str_replace(' ', '', $googleUser->name),
                    'email' => $googleUser->email,
                    'country' => $countryData->name ?? null,
                    'mainCurrency' => $countryData->currency ?? null,
                    'email_verified_at' => now(),
                    'countryCode' => Cookie::get('hasAdsCountry'),
                    'loggedIn' => 1,
                    'photo' => $googleUser->getAvatar(),
                ]);

                // Initialize user settings
                $this->initializeUserSettings($newUser);

                // Log user in
                Auth::login($newUser,true);

                // Redirect to complete profile page
                $url = Cookie::has('redirect') ? Cookie::get('redirect') : route('mobile.user.profile.settings.complete-profile.socialite');
            }

            DB::commit();
            return redirect()->intended($url);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error handling Google callback: ' . $exception->getMessage(), [
                'request' => $request->all()
            ]);

            return redirect()->route('mobile.login')->with('error', 'Something went wrong while authenticating your request. Please try again.');
        }
    }
}
