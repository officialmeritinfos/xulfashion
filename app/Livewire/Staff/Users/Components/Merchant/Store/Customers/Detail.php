<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Customers;

use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreOrder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination;
    public $storeId;
    public $store;
    public $customerId;
    public $customer;
    #[Url]
    public $orderStatus='all';
    #[Url]
    public $orderSearch;
    #[Url]
    public $orderShow=10;
    #[Url]
    public $invoiceStatus='all';
    #[Url]
    public $invoiceSearch;
    #[Url]
    public $invoiceShow=10;

    public function mount($storeId,$customerId)
    {
        $this->storeId=$storeId;
        $this->customerId = $customerId;

        $this->store = UserStore::where('reference',$this->storeId)->first();
        $this->customer = UserStoreCustomer::where([
            'reference' => $this->customerId,'store' => $this->store->id
        ])->first();
    }

    public function render()
    {
        $orders = UserStoreOrder::query()
            ->when($this->orderSearch, function($query) {
                $query->where('reference', 'like', '%' . $this->orderSearch . '%');
            })
            ->when($this->orderStatus != 'all', function($query) {
                $query->where('status', $this->orderStatus);
            })->where(['store'=>$this->store->id,'customer'=>$this->customer->id])->latest()
            ->paginate($this->orderShow);

        $invoices =UserStoreInvoice::query()
            ->when($this->invoiceSearch, function($query) {
                $query->where('title', 'like', '%' . $this->invoiceSearch . '%')
                ->orWhere('reference', 'like', '%' . $this->invoiceSearch . '%');
            })
            ->when($this->invoiceStatus != 'all', function($query) {
                $query->where('status', $this->invoiceStatus);
            })->where(['store'=>$this->store->id,'customer'=>$this->customer->id])->latest()
            ->paginate($this->orderShow,'*','invoice');

        return view('livewire.staff.users.components.merchant.store.customers.detail',[
            'orders'    =>$orders,
            'invoices'  =>$invoices,
        ]);
    }
}
