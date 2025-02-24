<?php

namespace App\Livewire\Mobile\Users\Store\Components\Actions\Products;

use App\Models\UserStore;
use App\Models\UserStoreOrder;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    public $listPerPage = 10;
    public $search;
    public $status = 'all';

    public $store;
    public $user;
    public $shareUrl;
    public $productId;

    protected $listeners = [
        'productDeleteConfirm'
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->store = UserStore::where('user', $this->user->id)->first();
    }
    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
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

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
    }
    public function render()
    {
        $products = UserStoreProduct::where('store',$this->store->id)
            ->when($this->search,function ($query){
                $query->where('name', 'like', '%' . $this->search . '%');
            }) ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })->with('productCategory')
            ->paginate($this->listPerPage);

        return view('livewire.mobile.users.store.components.actions.products.index',[
            'products' => $products
        ]);
    }

    public function shareProduct($id)
    {
        $product = UserStoreProduct::where([
            'id'=> $id,
            'store' => $this->store->id,
        ])->first();
        if (!$product){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product not found',
                'width' => '400',
            ]);
            return;
        }
        $this->shareUrl = route('merchant.store.product.detail',['subdomain'=>$this->store->slug,'id'=>$product->reference]);
        $this->dispatch('open-share-modal');
    }
    public function deleteProduct($id)
    {
        $product = UserStoreProduct::where([
            'id'=> $id, 'store' => $this->store->id,
        ])->first();
        if (!$product){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product not found',
                'width' => '400',
            ]);
            return;
        }
        //check if there is an order for this product
        $orderExists = UserStoreOrder::whereHas('breakdowns', function ($q) use($id) {
            $q->where('product', $id);
        })->with(['breakdowns.products']);
        if ($orderExists->count() > 0){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product already has some orders.',
                'width' => '400',
            ]);
            return;
        }
        //open a dialog to confirm action
        $this->alert('warning', '', [
            'text' => 'Do you want to delete '.$product->name.' ?',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'productDeleteConfirm',
            'data' => [
                'id' => $id
            ],
            'timer' => null
        ]);
    }
    //confirm product delete
    public function productDeleteConfirm($data)
    {
        $id = $data['id'] ?? null;
        if ($id) {
            DB::beginTransaction();
            try {
                $product = UserStoreProduct::where([
                    'id' => $id,
                    'store' => $this->store->id,
                ])->first();
                if ($product) {
                    UserStoreProduct::where(['id' => $product->id])->delete();

                    DB::commit();
                    $this->alert('success', '', [
                        'position' => 'top-end',
                        'timer' => 5000,
                        'toast' => true,
                        'text' => "Product successfully deleted",
                        'width' => '400',
                    ]);
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                logger("Error delete product size: {$exception->getMessage()}");
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => "{$exception->getMessage()}",
                    'width' => '400',
                ]);
            }
        }
    }
}
