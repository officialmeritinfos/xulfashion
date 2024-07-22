<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Invoices;

use App\Models\Fiat;
use App\Models\UserStore;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use Livewire\Component;

class InvoiceDetail extends Component
{
    public $storeId;
    public $store;
    public $invoice;
    public $invoiceId;

    public function mount($storeId,$invoiceId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$this->storeId)->first();
        $this->invoiceId = $invoiceId;
        $this->invoice = UserStoreInvoice::where([
            'store'=>$this->store->id,
            'reference' => $this->invoiceId
        ])->first();
    }
    public function render()
    {
        return view('livewire.staff.users.components.merchant.store.invoices.invoice-detail',[
            'customer'=>UserStoreCustomer::where('id',$this->invoice->customer)->first(),
            'fiat'    =>Fiat::where('code',$this->invoice->currency)->first()
        ]);
    }
}
