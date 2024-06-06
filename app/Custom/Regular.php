<?php

namespace App\Custom;

use App\Models\Country;
use App\Models\Fiat;
use App\Models\Job;
use App\Models\JobType;
use App\Models\RateType;
use App\Models\ServiceType;
use App\Models\State;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserAd;
use App\Models\UserBank;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    public function userById($id): User
    {
        return User::where('id',$id)->first();
    }

    //fetch customer id
    public function customerById($id): UserStoreCustomer
    {
        return UserStoreCustomer::where('id',$id)->first();
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
        ])->sum('amountPaid');
    }

    //revenue in store
    public function invoiceRevenueInStore($store)
    {
        return UserStoreInvoice::where([
            'store'=>$store,
            'paymentStatus'=>1,
        ])->whereNot('paymentMethod','offline')->sum('amountCredit');
    }
    //calculate charge
    public function calculateChargeOnAmount($amount,$currency)
    {
        $fiat = Fiat::where('code',$currency)->orWhere('code','USD')->first();

        $charge = (($fiat->charge/100)*$amount)+$fiat->transactionCharge;

        if ($charge > $fiat->maxCharge){
            $charge = $fiat->maxCharge;
        }

        return $charge;

    }
    //most ordered products in a store
    public function mostOrderProducts($store)
    {
        $mostPurchasedProducts = UserStoreOrderBreakdown::select('product', DB::raw('SUM(quantity) as total_quantity'))
            ->where('store', $store)
            ->groupBy('product')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get();

        // Retrieve the product details
        $products = [];
        foreach ($mostPurchasedProducts as $item) {
            $product = UserStoreProduct::find($item->product);
            $products[] = [
                'product' => $product->name,
                'quantity' => $item->total_quantity,
                'amount'=>$product->amount,
                'photo'=>$product->featuredImage,
                'currency'=>$product->currency,
            ];
        }

        return $products;
    }
    //top ten sales
    public function topSales($store)
    {
        return UserStoreOrder::where([
            'store'=>$store,
        ])->orderBy('id','desc')->take(10)->get();
    }

    public function serviceTypeById($id)
    {
        return ServiceType::where('id',$id)->first();
    }
    //top performing Ads by user
    public function topUsersByView($number=12)
    {
        $topUserViews = UserAd::select('user', DB::raw('SUM(numberOfViews) as totalViews'))
            ->groupBy('user')
            ->orderByDesc('totalViews')
            ->take($number)
            ->get();

        $userIds = $topUserViews->pluck('user');
        $users = User::whereIn('id', $userIds)->get();

        $usersWithViews = $users->map(function ($user) use ($topUserViews) {
            $user->totalViews = $topUserViews->firstWhere('user', $user->id)->totalViews;
            return $user;
        });

        return$usersWithViews;
    }

    //fetch product by Id
    public function fetchProductById($id)
    {
        return UserStoreProduct::where('id',$id)->first();
    }
    //user store analytics
    public function fetchTotalRevenue($store)
    {
        // Start of the week (Assuming week starts on Monday)
        return UserStoreOrder::where([
            'store'=>$store->id,'paymentStatus'=>1,'status'=>1
        ])->sum('amountPaid');
    }
    public function fetchTotalOrders($store)
    {
        // Start of the week (Assuming week starts on Monday)
        return UserStoreOrder::where([
            'store'=>$store->id,'paymentStatus'=>1,'status'=>1
        ])->count();
    }
    public function fetchSalesOfWeek($store)
    {
        // Start of the week (Assuming week starts on Monday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        return UserStoreOrder::where('created_at', '>=', $startOfWeek)->where([
            'store'=>$store->id,'paymentStatus'=>1
        ])->sum('amountPaid');
    }
    public function fetchOrdersOfWeek($store)
    {
        // Start of the week (Assuming week starts on Monday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        return UserStoreOrder::where('created_at', '>=', $startOfWeek)->where([
            'store'=>$store->id,'paymentStatus'=>1
        ])->count();
    }
    public function fetchCompletedOrders($store)
    {
        // Start of the week (Assuming week starts on Monday)
        return UserStoreOrder::where([
            'store'=>$store->id,'paymentStatus'=>1,'status'=>1
        ])->count();
    }
    public function fetchPendingOrders($store)
    {
        // Start of the week (Assuming week starts on Monday)
        return UserStoreOrder::where([
            'store'=>$store->id,'status'=>2
        ])->count();
    }
    public function fetchProcessingOrders($store)
    {
        // Start of the week (Assuming week starts on Monday)
        return UserStoreOrder::where([
            'store'=>$store->id,'status'=>4,'paymentStatus'=>1
        ])->count();
    }
    public function fetchNewCustomers($store)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        return UserStoreCustomer::where('created_at', '>=', $oneMonthAgo)->where('store',$store->id)->count();
    }
    public function fetchTodayOrders($store)
    {
        $today = Carbon::today();
        return UserStoreOrder::whereDate('created_at', $today)->where('store',$store->id)->count();
    }
    public function fetchTodayMoney($store)
    {
        $today = Carbon::today();
        return UserStoreOrder::whereDate('created_at', $today)->where([
            'store'=>$store->id,
            'paymentStatus'=>1
        ])->sum('amountPaid');
    }

    public function fetchCurrentMonthSales($store)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return UserStoreOrder::where([
            'store'=>$store->id,
        ])->where(function($query) {
            $query->where('status', 1)
                ->orWhere('paymentStatus', 1);
        })->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amountPaid');
    }
    //fetch current month sale
    public function fetchLastMonthSales($store)
    {
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        return UserStoreOrder::where([
            'store'=>$store->id,
        ])->where(function($query) {
            $query->where('status', 1)
                ->orWhere('paymentStatus', 1);
        })->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('amountPaid');
    }
    //calculate percentage sales change
    public function fetchPercentageSaleChange($store)
    {
        $lastMonthSales = $this->fetchLastMonthSales($store);
        $monthlySales = $this->fetchCurrentMonthSales($store);
        if ($lastMonthSales > 0) {
            $percentageChange = (($monthlySales - $lastMonthSales) / $lastMonthSales) * 100;
        } else {
            $percentageChange = $monthlySales > 0 ? 100 : 0;
        }
        return $percentageChange;
    }
    //fetch most recent orders that have not been completed
    public function latestUncompletedOrders($store)
    {
        return UserStoreOrder::where([
            'store'=>$store->id,
        ])->whereNot('status',1)->whereNot('status',3)->limit(10)->get();
    }
    //user activities
    public function fetchUserActivities($user)
    {
        return UserActivity::where([
            'user'=>$user->id,'status'=>2
        ])->orderBy('id','desc')->get();
    }
    //top countries
    public function fetchTopCustomerCountry($store)
    {
        $topCountries = UserStoreCustomer::select(DB::raw('country, COUNT(*) as count'))
            ->where('store', $store->id)->whereNot('country',null)
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(4) // Limit to top 4 countries
            ->get();
        $countryLabels = $topCountries->pluck('country')->toArray();
        $countryCounts = $topCountries->pluck('count')->toArray();

        return [
            'countryLabels' => $countryLabels,
            'countryCounts' => $countryCounts
        ];
    }
    //fetch total store customers
    public function totalStoreUsers($store)
    {
        return UserStoreCustomer::where([
            'store'=>$store->id,
        ])->get()->count();
    }

    public function fetchAveragePurchaseAmount($store)
    {
        $customersPurchases = UserStoreOrder::select('customer', DB::raw('SUM(amountPaid) as totalSpent'), DB::raw('COUNT(*) as orderCount'))
            ->where('store', $store->id)
            ->where(function($query) {
                $query->where('status', 1)
                    ->orWhere('paymentStatus', 1);
            })
            ->groupBy('customer')
            ->get();

        $totalSpent = 0;
        $totalOrders = 0;

        foreach ($customersPurchases as $purchase) {
            $totalSpent += $purchase->totalSpent;
            $totalOrders += $purchase->orderCount;
        }

        $averagePurchaseAmount = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        return $averagePurchaseAmount;
    }
}
