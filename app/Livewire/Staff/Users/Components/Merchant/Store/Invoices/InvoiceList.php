<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Invoices;

use App\Models\UserStore;
use App\Models\UserStoreInvoice;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceList extends Component
{
    use WithPagination;

    public $storeId;
    public $store;

    #[Url]
    public $search;
    #[Url]
    public $status='all';
    #[Url]
    public $show=10;

    public function mount($storeId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$this->storeId)->first();
    }

    public function render()
    {
        $invoices = UserStoreInvoice::query()
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != 'all', function($query) {
                $query->where('status', $this->status);
            })->latest()
            ->paginate($this->show);


        return view('livewire.staff.users.components.merchant.store.invoices.invoice-list',[
            'invoices' => $invoices
        ]);
    }
}
