<?php

namespace App\Livewire\Staff\Users\Components\Merchant\Store\Categories;

use App\Custom\GoogleUpload;
use App\Models\SystemStaffAction;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination, WithFileUploads, LivewireAlert;

    #[Validate]
    public $name;
    #[Validate]
    public $photo;
    public $isDefault;
    public $store;
    public $storeId;
    public $staff;
    public $showAddNewForm=false;
    public $showEditForm=false;
    public $editFeaturedImage=false;
    public $editingId ;

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
            'name'=>['required','string','max:200',Rule::unique('user_store_catalog_categories','categoryName')->where('store',$this->store->id)],
            'photo'=>['required','image','max:2048'],
        ];
    }

    public function toggleNewForm()
    {
        $this->showAddNewForm=!$this->showAddNewForm;
    }

    //submit new category
    public function submit()
    {
        if ($this->staff->cannot('create UserStoreCatalogCategory')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to perform this action.',
                'width' => '400',
            ]);
            return;
        }
        $this->validate();
        DB::beginTransaction();

        try {
            if ($this->photo) {
                $google = new GoogleUpload();

                //lets upload the address proof
                $result = $google->uploadGoogle($this->photo);
                $image  = $result['link'];
            }

            $category = UserStoreCatalogCategory::create([
                'store'=>$this->store->id,'categoryName'=>$this->name,
                'isDefault'=>2, 'status'=>1,'photo'=>$image
            ]);

            if(!empty($category)){
                SystemStaffAction::create([
                    'staff' => $this->staff->id,
                    'action' => 'Added Catalog category to merchant store',
                    'isSuper' => $this->staff->role == 'superadmin' ? 1 : 2,
                    'model' => get_class($this->store).'/'.get_class($category),
                    'model_id' => $this->store->id,
                ]);
                DB::commit();
                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Category successfully added.',
                    'width' => '400',
                ]);
                $this->dispatch('renderPage');
                $this->reset(['name','photo']);
                $this->showAddNewForm=false;
            }
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while adding merchant store catalog category',
                'width' => '400',
            ]);
            Log::error('Error adding merchant store catalog category: ' . $exception->getMessage().' on line: '.$exception->getLine());
        }
    }

    public function edit($id)
    {
        //check if staff qualifies
        if ($this->staff->cannot('update UserStoreCatalogCategory')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $category = UserStoreCatalogCategory::find($id);
        $this->editingId = $category->id;
        $this->name = $category->categoryName;
        $this->showEditForm=!$this->showEditForm;
    }

    public function submitEdit()
    {
        $category = UserStoreCatalogCategory::find($this->editingId);

        $this->validate([
           'name'=>['required','string', 'max:200',Rule::unique('user_store_catalog_categories','categoryName')->ignore($this->editingId)],
            'photo'=>['nullable','image','max:2048'],
        ]);


        try {
            if ($this->photo){
                $google = new GoogleUpload();

                //lets upload the address proof
                $result = $google->uploadGoogle($this->photo);
                $image  = $result['link'];
            }else{
                $image = $category->photo;
            }

            $category->update([
                'categoryName' => $this->name,
                'photo' => $image,
            ]);

            $this->reset(['editingId', 'name','photo']);
            $this->dispatch('renderPage');
            $this->showEditForm=false;

            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Category successfully updated.',
                'width' => '400',
            ]);
        }catch (\Exception $exception){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while updating merchant store catalog category',
                'width' => '400',
            ]);
            Log::error('Error updating merchant store catalog category: ' . $exception->getMessage().' on line: '.$exception->getLine());
        }
    }

    //delete category
    public function delete($id)
    {
        //check if staff qualifies
        if ($this->staff->cannot('delete UserStoreCatalogCategory')){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have this permission',
                'width' => '400',
            ]);
            return;
        }
        $category = UserStoreCatalogCategory::find($id);

        if ($category->isDefault==1){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You cannot delete a default category',
                'width' => '400',
            ]);
            return;
        }

        $this->alert('warning', '', [
            'text'=>'Do you want to delete '.$category->categoryName,
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

    public function render()
    {
        return view('livewire.staff.users.components.merchant.store.categories.category-list',[
            'categories'=>UserStoreCatalogCategory::where('store',$this->store->id)->paginate(15)
        ]);
    }

    //confirm delete
    public function deleteConfirmed($data)
    {
        $id = $data['id'];
        UserStoreCatalogCategory::find($id)->delete();
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Successfully deleted',
            'width' => '400',
        ]);
    }
}
