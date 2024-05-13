<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Categories extends BaseController
{
    use Helpers;
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

            $category = UserStoreCatalogCategory::create([
                'store'=>$store->id,'categoryName'=>$input['name'],
                'isDefault'=>2, 'status'=>1
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
            'pageName'      =>'New Store Category',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'category'      =>UserStoreCatalogCategory::where([
                'store'=>$store->id,'id'=>$id
            ])->firstOrFail()
        ]);
    }

    //process edit category
    public function processCategoryEdit(){

    }
}
