<?php

namespace App\Livewire\Mobile\Users\Store\Components;

use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use Livewire\Component;

class BusinessData extends Component
{
    public $store;

    public function mount(UserStore $store)
    {
        $this->store = $store;
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }
    public function render()
    {
        $statistics = $this->getStatistics();
        $popularProducts = $this->getMostOrderedProducts();
        $recentOrders = $this->getRecentOrders();
        return view('livewire.mobile.users.store.components.business-data',[
            'statistics' => $statistics,
            'popularProducts' => $popularProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
    // Optimized Statistics Data
    private function getStatistics()
    {
        return [
            'totalSales' => UserStoreOrder::where('store', $this->store->id)->where('status', 1)->count(),
            'invoiceRevenue' => UserStoreInvoice::where('store', $this->store->id)
                ->where('paymentStatus', 1)
                ->where('paymentMethod', '!=', 'offline')
                ->sum('amountCredit'),
            'totalRevenue' => UserStoreOrder::where('store', $this->store->id)
                ->where('status', 1)
                ->sum('amountPaid'),
            'totalCustomers' => UserStoreCustomer::where('store', $this->store->id)->count(),
            'totalProducts' => UserStoreProduct::where('store', $this->store->id)->count(),
        ];
    }

    // Optimized Popular Products
    private function getMostOrderedProducts()
    {
        return UserStoreOrderBreakdown::with('products')
            ->select('product', \DB::raw('SUM(quantity) as total_quantity'))
            ->where('store', $this->store->id)
            ->groupBy('product')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'product' => $item->products->name,
                    'quantity' => $item->total_quantity,
                    'amount' => $item->products->amount,
                    'photo' => $item->products->featuredImage,
                    'currency' => $item->products->currency,
                ];
            });
    }

    // Optimized Recent Orders
    private function getRecentOrders()
    {
        return UserStoreOrder::with('customers')
            ->where('store', $this->store->id)
            ->orderByDesc('id')
            ->take(10)
            ->get();
    }
}
