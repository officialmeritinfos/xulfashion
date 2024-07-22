<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Products;

use App\Custom\GoogleUpload;
use App\Models\GeneralSetting;
use App\Models\SystemStaffAction;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination,LivewireAlert,WithFileUploads,Helpers;
    public $storeId;
    public $store;
    public $staff;
    #[Url]
    public $show=10;
    #[Url]
    public $search;
    public $showEditForm=false;
    public $showNewForm=false;

    //Form data
    #[Validate]
    public $featuredPhoto;
    #[Validate]
    public $name;
    #[Validate]
    public $manufacturer;
    #[Validate]
    public $category;
    #[Validate]
    public $brand;
    #[Validate]
    public $price;
    #[Validate]
    public $qty = 0;
    #[Validate]
    public $description;
    #[Validate]
    public $specifications;
    #[Validate]
    public $features;
    #[Validate]
    public $returnPolicy;
    #[Validate]
    public $refundPolicy;
    #[Validate]
    public $sizeVariations = [];
    #[Validate]
    public $colorVariations = [];
    #[Validate]
    public $productImages = [];
    public $featured = false;
    public $addAnother = false;

    public $editedProduct;

    protected $listeners = [
        'renderPage' => 'render',
        'confirmDelete'=>'deleteConfirmed'
    ];
    public function mount($storeId)
    {
        $this->storeId = $storeId;
        $this->store = UserStore::where('reference',$this->storeId)->first();
        $this->staff = Auth::guard('staff')->user();
    }

    public function rules()
    {
        return [
            'featuredPhoto'=>['required','image','max:2048'],
            'name'=>['required','string','max:200'],
            'manufacturer'=>['nullable','string','max:150'],
            'category'=>['required','numeric',Rule::exists('user_store_catalog_categories','id')->where('store',$this->store->id)],
            'brand'=>['nullable','string','max:150'],
            'price'=>['required','numeric'],
            'qty'=>['required','numeric'],
            'description'=>['required','string'],
            'specifications'=>['required','string'],
            'features'=>['required','string'],
            'productImages.*'=>['nullable','image','max:2048'],
            'sizeVariations' => ['sometimes', 'required'],
            'sizeVariations.*' =>  ['sometimes', 'required','required','string','max:255'],
            'colorVariations' => ['sometimes', 'required'],
            'colorVariations.*' => ['sometimes', 'required','required','string','max:255'],
            'returnPolicy'=>['nullable','string'],
            'refundPolicy'=>['nullable','string']
        ];
    }

    public function toggleNewForm()
    {
        $this->showNewForm=!$this->showNewForm;
    }

    public function render()
    {
        $products = UserStoreProduct::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%');
            })->where('store',$this->store->id)->paginate($this->show);

        return view('livewire.staff.users.components.merchant.store.products.product-list',[
            'products'=>$products,
            'siteName' => GeneralSetting::find(1)->name,
            'categories'=>UserStoreCatalogCategory::where('status',1)->where('store',$this->store->id)->get()
        ]);
    }
    //update status
    public function updateProductStatus($id,$status)
    {
        //authorized to update?
        if ($this->staff->cannot('update UserStoreProduct')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $product = UserStoreProduct::where([
            'id'=>$id,'store'=>$this->store->id
        ])->first();
        if (empty($product)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product not found',
                'width' => '400',
            ]);
        }

        $product->update([
            'status' => $status
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product status updated',
            'width' => '400',
        ]);

    }
    //mark featured
    public function markProductAsFeatured($id,$status)
    {
        //authorized to update?
        if ($this->staff->cannot('update UserStoreProduct')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $product = UserStoreProduct::where([
            'id'=>$id,'store'=>$this->store->id
        ])->first();
        if (empty($product)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product not found',
                'width' => '400',
            ]);
        }

        $product->update([
            'featured' => $status
        ]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product Featuring updated',
            'width' => '400',
        ]);

    }
    //highlight product
    public function highlightProduct($id,$status)
    {
        //authorized to update?
        if ($this->staff->cannot('update UserStoreProduct')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $product = UserStoreProduct::where([
            'id'=>$id,'store'=>$this->store->id
        ])->first();
        if (empty($product)){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product not found',
                'width' => '400',
            ]);
        }

        $highlighted = UserStoreProduct::where([
            'store'=>$this->store->id,'highlighted' => 1
        ])->whereNot('id',$id)->first();

        if (!empty($highlighted)){
            $highlighted->highlighted=2;
            $highlighted->save();
        }

        $product->update([
            'highlighted' => $status
        ]);


        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product Highlighting updated',
            'width' => '400',
        ]);
    }
    //delete product
    public function delete($id)
    {
        //check if staff qualifies
        if ($this->staff->cannot('delete UserStoreProduct')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $product = UserStoreProduct::find($id);

        $this->alert('warning', '', [
            'text'=>'Do you want to delete '.$product->name,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'confirmDelete',
            'data' => [
                'id' => $id
            ],
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }
    //remove after confirmation
    public function deleteConfirmed($data)
    {
        $id = $data['id'];
        UserStoreProduct::find($id)->delete();
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Successfully deleted',
            'width' => '400',
        ]);
    }
    public function addSizeVariation()
    {
        $this->sizeVariations[] = '';
    }

    public function removeSizeVariation($index)
    {
        unset($this->sizeVariations[$index]);
        $this->sizeVariations = array_values($this->sizeVariations);
    }

    public function addColorVariation()
    {
        $this->colorVariations[] = '';
    }

    public function removeColorVariation($index)
    {
        unset($this->colorVariations[$index]);
        $this->colorVariations = array_values($this->colorVariations);
    }
    //submit
    public function submit()
    {
        if ($this->staff->cannot('create UserStoreProduct')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();

        DB::beginTransaction();
        try {
            $category = UserStoreCatalogCategory::where([
                'store'=>$this->store->id,'id'=>$this->category
            ])->first();

            if (empty($category)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category not found merchant store.',
                    'width' => '400',
                ]);
            }
            $reference = $this->generateUniqueReference('user_store_products','reference',6);
            if ($this->featuredPhoto){
                $google = new GoogleUpload();

                //lets upload the address proof
                $result = $google->uploadGoogle($this->featuredPhoto);
                $featuredImage  = $result['link'];
            }
            $merchant = User::where('id',$this->store->user)->first();
            $product = UserStoreProduct::create([
                'store'=>$this->store->id,'name'=>$this->name,
                'reference'=>$reference,'description'=>clean($this->description),
                'featuredImage'=>$featuredImage,'amount'=>$this->price,
                'currency'=>$this->store->currency,'keyFeatures'=>clean($this->features),
                'specifications'=>clean($this->specifications),'manufacturer'=>$this->manufacturer,
                'brand'=>$this->brand,'category'=>$this->category,'quantity'=>$this->qty,
                'refundPolicy'=>clean($this->refundPolicy),'returnPolicy'=>clean($this->returnPolicy),
                'featured'=>($this->featured)?1:2
            ]);
            if(!empty($product)) {
                //add the product specifications
                if ($this->sizeVariations) {
                    foreach ($this->sizeVariations as $indexs => $items) {
                        UserStoreProductSizeVariation::create([
                            'product' => $product->id, 'name' => $this->sizeVariations[$indexs],
                        ]);
                    }
                }
                //add the product specifications
                if ($this->colorVariations) {
                    foreach ($this->colorVariations as $indexs => $items) {
                        UserStoreProductColorVariation::create([
                            'product' => $product->id, 'name' => $this->colorVariations[$indexs],
                        ]);
                    }
                }

                if ($this->productImages){
                    foreach ($this->productImages as $index => $item) {
                        $result = $google->uploadGoogle($item);
                        $fileName = $result['link'];

                        UserStoreProductImage::create([
                            'product'=>$product->id,'image'=>$fileName
                        ]);
                    }
                }

                SystemStaffAction::create([
                    'staff' => $this->staff->id,
                    'action' => 'Added product to merchant store',
                    'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($merchant).'/'.get_class($product),
                    'model_id' => $merchant->id,
                ]);
                DB::commit();

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Product successfully added.',
                    'width' => '400',
                ]);

                (!$this->addAnother)?$this->showNewForm=false:$this->showNewForm=true;
                return;
            }

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' adding store product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //edit product
    public function edit($id)
    {
        $product = UserStoreProduct::find($id);
        $this->editedProduct = $product->id;
        //load the form value
        $this->name=$product->name;
        $this->manufacturer=$product->manufacturer;
        $this->category=$product->category;
        $this->brand=$product->brand;
        $this->qty=$product->quantity;
        $this->price=$product->amount;
        $this->description=$product->description;
        $this->specifications=$product->specifications;
        $this->features=$product->keyFeatures;
        $this->returnPolicy=$product->returnPolicy;
        $this->refundPolicy=$product->refundPolicy;

        $this->showEditForm = !$this->showEditForm;
    }
    //submit editing
    public function submitEditing()
    {
        if ($this->staff->cannot('update UserStoreProduct')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $this->validate([
            'featuredPhoto'=>['nullable','mimes:jpg,jpeg,png,gif,avif,webp,bmp','max:2048'],
            'name'=>['required','string','max:200'],
            'manufacturer'=>['nullable','string','max:150'],
            'category'=>['required','numeric',Rule::exists('user_store_catalog_categories','id')->where('store',$this->store->id)],
            'brand'=>['nullable','string','max:150'],
            'price'=>['required','numeric'],
            'qty'=>['required','numeric'],
            'description'=>['required','string'],
            'specifications'=>['required','string'],
            'features'=>['required','string'],
            'returnPolicy'=>['nullable','string'],
            'refundPolicy'=>['nullable','string']
        ]);

        $product = UserStoreProduct::where('id',$this->editedProduct)->first();

        DB::beginTransaction();
        try {
            $category = UserStoreCatalogCategory::where([
                'store'=>$this->store->id,'id'=>$this->category
            ])->first();

            if (empty($category)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category not found merchant store.',
                    'width' => '400',
                ]);
            }
            if ($this->featuredPhoto){
                $google = new GoogleUpload();

                //lets upload the address proof
                $result = $google->uploadGoogle($this->featuredPhoto);
                $featuredImage  = $result['link'];
            }else{
                $featuredImage = $product->featuredImage;
            }

            $merchant = User::where('id',$this->store->user)->first();
            $product->update([
                'name'=>$this->name,'description'=>clean($this->description),
                'featuredImage'=>$featuredImage,'amount'=>$this->price,
                'currency'=>$this->store->currency,'keyFeatures'=>clean($this->features),
                'specifications'=>clean($this->specifications),'manufacturer'=>$this->manufacturer,
                'brand'=>$this->brand,'category'=>$this->category,'quantity'=>$this->qty,
                'refundPolicy'=>clean($this->refundPolicy),'returnPolicy'=>clean($this->returnPolicy),
            ]);

            SystemStaffAction::create([
                'staff' => $this->staff->id,
                'action' => 'Updated product in merchant store',
                'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
                'model' => get_class($merchant).'/'.get_class($product),
                'model_id' => $merchant->id,
            ]);
            DB::commit();

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product successfully updated.',
                'width' => '400',
            ]);
            $this->showEditForm=false;

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' adding store product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
