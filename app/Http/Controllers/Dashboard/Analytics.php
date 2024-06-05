<?php

namespace App\Http\Controllers\Dashboard;

use App\Custom\Regular;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Analytics extends BaseController
{
    public $analyticsService;
    public function __construct()
    {
        $this->analyticsService = new Regular();
    }
    //fetch customers on country basis
    public function fetchCountryAnalyticsData()
    {
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        // Fetch top customer countries
        $topCustomerCountries = $this->analyticsService->fetchTopCustomerCountry($store);
        $countryLabels = $topCustomerCountries['countryLabels'];
        $countryCounts = $topCustomerCountries['countryCounts'];

        return response()->json([
            'countryLabels' => $countryLabels,
            'countryCounts' => $countryCounts,
        ]);
    }
    //fetch orders
    public function fetchOrderData()
    {
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();

        $currency = $store->currency;

        $completedOrders = UserStoreOrder::where('store', $store->id)
            ->where(function($query) {
                $query->where('status', 1)
                    ->orWhere('paymentStatus', 1);
            })
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amountPaid) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')->toArray();

        $pendingOrders = UserStoreOrder::where('store', $store->id)
            ->where(function($query) {
                $query->where('status', 2)
                    ->orWhere('paymentStatus', 2);
            })
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amountPaid) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')->toArray();

        // Create an array with 12 months initialized to 0
        $completedOrderData = array_fill(1, 12, 0);
        $pendingOrderData = array_fill(1, 12, 0);

        // Fill the data arrays with actual values
        foreach ($completedOrders as $month => $total) {
            $completedOrderData[$month] = $total;
        }

        foreach ($pendingOrders as $month => $total) {
            $pendingOrderData[$month] = $total;
        }

        return response()->json([
            'completedOrderData' => array_values($completedOrderData),
            'pendingOrderData' => array_values($pendingOrderData),
            'currency' => $currency
        ]);
    }
    //fetch customer anqlytics
    public function fetchCustomerAnalytics()
    {
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        $customers = UserStoreCustomer::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
            ->where('store', $store->id)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $customerData = [];
        foreach ($customers as $customer) {
            $customerData[] = [
                'year' => $customer->year,
                'month' => $customer->month,
                'count' => $customer->count
            ];
        }

        return response()->json($customerData);
    }
    //fetch offline and online checkout Analytics
    public function onlineOfflineAnalytics()
    {
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();

        $onlineSales = UserStoreOrder::select(DB::raw('MONTH(created_at) as month, SUM(amountPaid) as total'))
            ->where('store', $store->id)
            ->where('channelPaymentId', '!=', '')
            ->where(function($query) {
                $query->where('paymentStatus', 1)
                    ->orWhere('status', 1);
            })
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Fetch monthly offline sales
        $offlineSales = UserStoreOrder::select(DB::raw('MONTH(created_at) as month, SUM(amountPaid) as total'))
            ->where('store', $store->id)
            ->where('channelPaymentId', null)
            ->where(function($query) {
                $query->where('paymentStatus', 1)
                    ->orWhere('status', 1);
            })
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return response()->json([
            'onlineSales' => $onlineSales,
            'offlineSales' => $offlineSales,
        ]);
    }
}
