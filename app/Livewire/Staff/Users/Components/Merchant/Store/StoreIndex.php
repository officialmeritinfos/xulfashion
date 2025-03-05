<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store;

use App\Models\UserStore;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class StoreIndex extends Component
{
    use WithPagination;
    #[Url]
    public $kycStatus='all';
    #[Url]
    public $search='';
    #[Url]
    public $show=10;

    public function render()
    {
        $stores = UserStore::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%');
            })
            ->when($this->kycStatus != 'all', function($query) {
                $query->where('isVerified', $this->kycStatus);
            })->with(['users','serviceType'])->latest()
            ->paginate($this->show);


        return view('livewire.staff.users.components.merchant.store.store-index',[
            'stores'=>$stores
        ]);
    }
}
