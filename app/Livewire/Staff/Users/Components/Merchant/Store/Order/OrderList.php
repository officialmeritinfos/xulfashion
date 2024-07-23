<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Order;

use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public $storeId;
    public $store;
    public $staff;
    #[Url]
    public $show=10;
    #[Url]
    public $search;
    #[Url]
    public $status='all';

    public function mount($storeId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$this->storeId)->first();
        $this->staff = Auth::guard('staff')->user();
    }
    public function render()
    {
        $orders = UserStoreOrder::query()
            ->when($this->search, function($query) {
                $query->where('reference', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('status', $this->status);
            })->where('store',$this->store->id)->paginate($this->show);


        return view('livewire.staff.users.components.merchant.store.order.order-list',[
            'orders'=>$orders,
            'siteName' => GeneralSetting::find(1)->name,
        ]);
    }
}
