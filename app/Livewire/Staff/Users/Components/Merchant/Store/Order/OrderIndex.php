<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Order;

use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class OrderIndex extends Component
{
    #[Url]
    public $show=10;
    #[Url]
    public $search;
    #[Url]
    public $status='all';

    public $staff;

    public function mount()
    {
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
            })->latest()->paginate($this->show);

        return view('livewire.staff.users.components.merchant.store.order.order-index',[
            'orders' => $orders,
            'siteName' => GeneralSetting::find(1)->name,
        ]);
    }
}
