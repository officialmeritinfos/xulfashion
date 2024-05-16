<?php

namespace App\Custom;

use App\Models\Country;
use App\Models\Job;
use App\Models\JobType;
use App\Models\RateType;
use App\Models\State;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Regular
{
    use Helpers;
    //check where to redirect user to
    public function userDashboard($user): string
    {
        //check the route to redirect user to
        if ($user->completedProfile!=1){
            return route('complete-account-setup');
        }
        //based-off on the account type, lets redirect to the proper dashboard
        switch ($user->accountType){
            case 1:
            default:
            $url = route('user.dashboard');
                break;
        }
        return $url;
    }
    //fetch employer id
    public function employerById($id): User
    {
        return $this->userById($id);
    }
    //fetch employer id
    public function userById($id): User
    {
        return User::where('id',$id)->first();
    }
    //fetch job by Id
    public function fetchJobById($id): Job
    {
        return Job::where('id',$id)->first();
    }
    public function userPayoutAccounts(User $user)
    {

        if (strtoupper($user->countryCode)=='NGA'){
            return UserBank::where('user',$user->id)->get();
        }else{

        }
    }
    //fetch a particular payout account
    public function fetchPayoutAccountByReference($id): UserBank
    {
        return UserBank::where('reference',$id)->first();
    }

    //get user age
    public function convertToAge($timestamp): int
    {
        $birthdate = Carbon::createFromTimestamp($timestamp);
        return $birthdate->diffInYears(Carbon::now());
    }
    //abridge sentence
    public function abridgeSentence($word,$length=10): string
    {
        return Str::words($word,$length);
    }
    //get time ago
    public function getTimeAgo($date): string
    {
        return Carbon::parse($date)->diffForHumans();
    }
    //shorten number to letter
    public function shortenNumberToLetters($number): string
    {
        return $this->shortenNumberToLetter($number);
    }
    //fetch recruiter detail
    public function fetchRecruiterName($id)
    {
        $user = User::where('id',$id)->first();
        return empty($user->companyName)?$user->name:$user->companyName;
    }
    //job type
    public function jobTypeById($id)
    {
        return JobType::where('id',$id)->first();
    }
    //payment type
    public function paymentType($id)
    {
        return RateType::where('id',$id)->first();
    }
    //fetch country by ISO3
    public function fetchCountryIso3($iso3)
    {
        return Country::where('iso3',$iso3)->first();
    }
    //fetch country by ISO2
    public function fetchCountryIso2($iso2)
    {
        return Country::where('iso2',$iso2)->first();
    }
    //fetch state
    public function fetchState($country,$state)
    {
        return State::where([
            'country_code'=>$country,
            'iso2'=>$state
        ])->first();
    }

    public function openToNegotiation($state)
    {
        switch ($state){
            case 1:
                $text='Yes';
                break;
            case 2:
                $text='No';
                break;
            default:
                $text='Not Sure';
                break;
        }
        return $text;
    }
    //number of products in a category in a store
    public function numberOfProductInStoreCategory($store,$category)
    {
        return UserStoreProduct::where([
            'store'=>$store,'category'=>$category
        ])->count();
    }
    //fetch category by id
    public function fetchCategoryById($id)
    {
        return UserStoreCatalogCategory::where('id',$id)->first();
    }
    // total product purchase amount
    public function totalProductPurchasedAmount()
    {

    }
    public function formatNumber($number, $decimals = 2)
    {
        $abbreviations = array('', 'K', 'M', 'B', 'T', 'Q', 'Qn', 'Sx', 'Sp', 'Oc', 'Nn');

        if ($number <1000){
            $decimals = 0;
        }

        $absNumber = abs($number);

        $index = 0;
        while ($absNumber >= 1000 && $index < count($abbreviations) - 1) {
            $absNumber /= 1000;
            $index++;
        }

        $formattedNumber = number_format($number >= 0 ? $absNumber : -$absNumber, $decimals) . $abbreviations[$index];

        return $formattedNumber;
    }
    //number of products in store
    public function numberOfProductInStore($store)
    {
        return UserStoreProduct::where('store',$store)->count();
    }
    //number of customers in store
    public function numberOfCustomersInStore($store)
    {
        return UserStoreCustomer::where('store',$store)->count();
    }
    //number of sales in store
    public function numberOfSalesInStore($store)
    {
        return UserStoreOrder::where('store',$store)->where('status',1)->count();
    }
    //fetch currency sign from currency
    public function fetchCurrencySign($currency)
    {
        return Country::select(['currency_symbol'])->where('currency',$currency)->first();
    }

    //revenue in store
    public function revenueInStore($store)
    {
        return UserStoreOrder::where([
            'store'=>$store,
            'status'=>1,
            'completedOnWhatsapp'=>2,
        ])->sum('amountToCredit');
    }
}
