<?php

namespace App\Livewire\Mobile\Users\Store\Components\Actions\Category;

use App\Models\UserSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,LivewireAlert,WithFileUploads;

    #[Url]
    public $listPerPage=10;
    #[Url]
    public $search;
    public $status = 'all';
    public $showEdit = false;
    public $showNew = false;

    public $categoryId;
    public $store;
    public $shareUrl;
    public $catalogImage;

    public $name;
    public $file;
    public $categoryStatus;

    protected $listeners = [
        'deleteConfirmed'
    ];
    public function mount()
    {
        $this->store = UserStore::where('user', auth()->id())->first();
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
        $store = UserStore::where('user', auth()->id())->first();

        $categories = UserStoreCatalogCategory::where('store', $store->id)
            ->when($this->search, function ($query) {
                $query->where('categoryName', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })->with('products')
            ->paginate($this->listPerPage);

        return view('livewire.mobile.users.store.components.actions.category.index', [
            'categories' => $categories,
        ]);
    }
    public function editCategory($id)
    {

        if ($this->showEdit){
            $this->showNew = false;
            $this->showEdit = false;
        }else{
            $this->showNew = false;
            $category = UserStoreCatalogCategory::where([
                'id'=> $id,
                'store' => $this->store->id,
            ])->first();
            if (!$category){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Catalog not found',
                    'width' => '400',
                ]);
                return;
            }

            $this->categoryId = $id;
            $this->name = $category->categoryName;
            $this->categoryStatus = $category->status;

            $this->showEdit = true;
        }
    }

    public function shareCategory($id)
    {
        $category = UserStoreCatalogCategory::where([
            'id'=> $id,
            'store' => $this->store->id,
        ])->first();
        if (!$category){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Catalog not found',
                'width' => '400',
            ]);
            return;
        }
        $this->shareUrl = route('merchant.store.category',['subdomain'=>$this->store->slug,'id'=>$id]);
        $this->catalogImage = $category->photo;
        $this->dispatch('open-share-modal');
    }
    //delete Category
    public function deleteCategory($id)
    {
        try {
            $category = UserStoreCatalogCategory::where([
                'id' => $id,'store' => $this->store->id
            ])->with('products')->first();

            if (!$category){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Catalog not found',
                    'width' => '400',
                ]);
                return;
            }
            if ($category->products->count()>0){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Please remove the products associated with this catalog first.',
                    'width' => '400',
                ]);
                return;
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $category->categoryName,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteConfirmed',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete a store category');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while deleting catalog category.',
                'width' => '400',
            ]);
            return;
        }
    }

    //delete confirmed
    public function deleteConfirmed($data)
    {
        $id = $data['id'] ?? null;

        if ($id) {
            $category = UserStoreCatalogCategory::where([
                'id' => $id,
                'store' => $this->store->id,
            ])->first();

            if ($category) {
                $category->delete();

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Catalog has been deleted.',
                    'width' => '400',
                ]);
            }
        }
        $this->dispatch('render');

    }

    public function cancelEdit()
    {
        $this->showEdit = false;
        $this->showNew = false;
        $this->reset(['name','categoryStatus','categoryId','file']);
    }

    public function toggleNewCategory()
    {
        if ($this->showNew){
            $this->showNew = false;
            $this->showEdit = false;
        }else{
            $this->showEdit = false;
            $this->showNew = true;
        }
    }
    //add new catalog
    public function addNewCatalog()
    {
        $this->validate([
            'name' => ['required','string','max:200'],
            'categoryStatus'=>['required','numeric','integer','in:1,2'],
            'file'=>['required','image','max:5120'],
        ]);

        DB::beginTransaction();
        try {
            //check that the category does not exists already
            $categoryExists = UserStoreCatalogCategory::where([
                'store'=>$this->store->id,'categoryName'=>$this->name,
            ])->first();

            if (!empty($categoryExists)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category already exists in store',
                    'width' => '400',
                ]);
                return;
            }
            if ($this->file){
                $imageResult = googleUpload($this->file);
                if (!$imageResult || empty($imageResult['link'])) {
                    $this->alert('error', '', [
                        'position' => 'top-end',
                        'timer' => 5000,
                        'toast' => true,
                        'text' => 'There was an error uploading your catalog image',
                        'width' => '400',
                    ]);
                    return;
                }
                $logo = $imageResult['link'];
            }

            $category = UserStoreCatalogCategory::create([
                'categoryName' => $this->name,
                'status' => $this->categoryStatus,
                'photo' => $logo,
                'store' => $this->store->id,
            ]);

            DB::commit();
            //Catalog category update
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Category successfully added.',
                'width' => '400',
            ]);
            $this->showNew = false;
            $this->showEdit = false;
            $this->dispatch('render');
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            logger($exception->getMessage());

        }
    }
    //upload new catalog
    public function updateCatalog()
    {
        $this->validate([
            'name' => ['required','string','max:200'],
            'categoryStatus'=>['required','numeric','integer','in:1,2'],
            'file'=>['nullable','image','max:5120'],
        ]);

        DB::beginTransaction();
        try {
            //check that the category does not exists already
            $categoryExists = UserStoreCatalogCategory::where([
                'store'=>$this->store->id,'categoryName'=>$this->name,
            ])->where('id','!=', $this->categoryId)->first();

            if (!empty($categoryExists)){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category already exists in store',
                    'width' => '400',
                ]);
                return;
            }
            $category = UserStoreCatalogCategory::where([
                'store' => $this->store->id,
                'id'=>$this->categoryId,
            ])->first();

            if ($this->file){
                $imageResult = googleUpload($this->file);
                if (!$imageResult || empty($imageResult['link'])) {
                    $this->alert('error', '', [
                        'position' => 'top-end',
                        'timer' => 5000,
                        'toast' => true,
                        'text' => 'There was an error uploading your catalog image',
                        'width' => '400',
                    ]);
                    return;
                }
                $logo = $imageResult['link'];
            }else{
                $logo = $category->photo;
            }

            $category->update([
                'categoryName' => $this->name,
                'status' => $this->categoryStatus,
                'photo' => $logo,
            ]);

            DB::commit();
            //Catalog category update
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Category successfully updated.',
                'width' => '400',
            ]);
            $this->showNew = false;
            $this->showEdit = false;
            $this->dispatch('render');
            $this->resetForm();
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => $exception->getMessage(),
                'width' => '400',
            ]);
            logger($exception->getMessage());

        }
    }

    public function resetForm()
    {
        $this->reset('name','categoryStatus','categoryId','file','catalogImage');
    }
}
