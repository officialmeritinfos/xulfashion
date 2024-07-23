<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Order;

use App\Models\Fiat;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    public $storeId;
    public $store;
    public $orderId;
    public $order;
    public $staff;

    public function mount($storeId,$orderId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$this->storeId)->first();
        $this->orderId = $orderId;
        $this->order = UserStoreOrder::where([
            'store' => $this->store->id,
            'reference' => $this->orderId
        ])->first();

        $this->staff = Auth::guard('staff')->user();
    }

    public function render()
    {
        return view('livewire.staff.users.components.merchant.store.order.order-detail',[
            'customer'=>UserStoreCustomer::where('id',$this->order->customer)->first(),
            'breakdowns'=>UserStoreOrderBreakdown::where('orderId',$this->order->id)->get(),
            'fiat'=>Fiat::where('code',$this->order->currency)->first(),
            'coupon' => UserStoreCoupon::where('id',$this->order->coupon)->first()
        ]);
    }
}
