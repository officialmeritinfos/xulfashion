<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Categories extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.category.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Catalog Categories',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'categories'    =>UserStoreCatalogCategory::where('store',$store->id)->paginate(15)
        ]);
    }
    //process new category
    public function processNewCategory(Request $request){
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'name'=>['required','string','max:200'],
                'photo'=>['required','image','max:2048'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //check that the category does not exists already
            $categoryExists = UserStoreCatalogCategory::where([
                'store'=>$store->id,'categoryName'=>$input['name']
            ])->first();
            if (!empty($categoryExists)){
                return $this->sendError('category.error',['error'=>'Category already exists in store']);
            }
            //upload featured image
            if ($request->hasFile('photo')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('photo'));
                $featuredPhoto  = $result['link'];
            }

            $category = UserStoreCatalogCategory::create([
                'store'=>$store->id,'categoryName'=>$input['name'],
                'isDefault'=>2, 'status'=>1,'photo'=>$featuredPhoto
            ]);

            if(!empty($category)){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Category successfully added. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store category: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

    //edit category
    public function editCategory($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.category.edit')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Category',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'category'      =>UserStoreCatalogCategory::where([
                'store'=>$store->id,'id'=>$id
            ])->firstOrFail()
        ]);
    }

    //process edit category
    public function processCategoryEdit(Request $request,$id){
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'name'=>['required','string','max:200'],
                'status'=>['required','numeric','integer'],
                'photo'=>['nullable','image','max:2048'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //check that the category does not exists already
            $categoryExists = UserStoreCatalogCategory::where([
                'store'=>$store->id,'categoryName'=>$input['name']
            ])->whereNot('id',$id)->first();
            if (!empty($categoryExists)){
                return $this->sendError('category.error',['error'=>'Category already exists in store']);
            }

            $category=UserStoreCatalogCategory::where([
                'store'=>$store->id,'id'=>$id
            ])->first();
            if (empty($category)){
                return $this->sendError('category.error',['error'=>'Category not found in store']);
            }

            if ($request->hasFile('photo')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('photo'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto = $category->photo;
            }

            if(UserStoreCatalogCategory::where('id',$category->id)->update([
                'categoryName'=>$input['name'], 'status'=>$input['status'],'photo'=>$featuredPhoto
            ])){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Category successfully updated. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' updating store category: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }

    public function deleteCategory($id): RedirectResponse
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized');
        }

        $category = UserStoreCatalogCategory::where([
            'store'=>$store->id,'id'=>$id
        ])->first();
        if (empty($category)){
           return back()->with('error','Category not found in store');
        }
        //check if category is found in any product
        $productWithCategory = UserStoreProduct::where('category',$category->id)->count();
        if ($productWithCategory >0){
            return back()->with('error','Unable to delete category because some products have this category in their details - update instead');
        }

        $category->delete();

        return back()->with('success','Category successfully deleted.');
    }
}
