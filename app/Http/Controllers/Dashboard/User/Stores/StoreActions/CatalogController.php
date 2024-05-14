<?php

namespace App\Http\Controllers\Dashboard\User\Stores\StoreActions;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatalogController extends BaseController
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

        return view('dashboard.users.stores.components.catalog.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Catalog',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
        ]);
    }
    //products
    public function products()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'products'      =>UserStoreProduct::where('store',$store->id)->paginate(15)
        ]);
    }
    //new products
    public function newProducts()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.new')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Add New Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'categories'    =>UserStoreCatalogCategory::where([
                'store'     =>$store->id,
                'status'    =>1
            ])->get()
        ]);
    }
    //process new product addition
    public function processNewProduct(Request $request)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $validator = Validator::make($request->all(),[
                'featuredPhoto'=>['required','image','max:2048'],
                'name'=>['required','string','max:200'],
                'manufacturer'=>['nullable','string','max:150'],
                'category'=>['required','numeric',Rule::exists('user_store_catalog_categories','id')->where('store',$store->id)],
                'brand'=>['nullable','string','max:150'],
                'price'=>['required','numeric'],
                'qty'=>['required','numeric'],
                'description'=>['required','string'],
                'specifications'=>['required','string'],
                'features'=>['required','string'],
                'file'=>['nullable'],
                'file.*'=>['nullable','image','max:2048'],
                'sizeName'=>['sometimes', 'required'],
                'sizeName.*'=>['sometimes','required','string','max:200'],
                'sizePrice'=>['sometimes','required'],
                'sizePrice.*'=>['sometimes','required','numeric'],
                'sizeQuantity'=>['sometimes','required'],
                'sizeQuantity.*'=>['sometimes','required','numeric'],
                'colorName'=>['sometimes','required'],
                'colorName.*'=>['sometimes','required','string','max:200'],
                'colorPrice'=>['sometimes','required'],
                'colorPrice.*'=>['sometimes','required','numeric'],
                'colorQuantity'=>['sometimes','required'],
                'colorQuantity.*'=>['sometimes','required','numeric'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //check that the category does not exists already
            $category = UserStoreCatalogCategory::where([
                'store'=>$store->id,'id'=>$input['category']
            ])->first();
            if (empty($category)){
                return $this->sendError('category.error',['error'=>'Category does not exist in store']);
            }

            $reference = $this->generateUniqueReference('user_store_products','reference',6);

            //upload featured image
            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }

            $product = UserStoreProduct::create([
                'store'=>$store->id,'name'=>$input['name'],
                'reference'=>$reference,'description'=>$input['description'],
                'featuredImage'=>$featuredPhoto,'amount'=>$input['price'],
                'currency'=>$store->currency,'keyFeatures'=>$input['features'],
                'specifications'=>$input['specifications'],'manufacturer'=>$input['manufacturer'],
                'brand'=>$input['brand'],'category'=>$input['category']
            ]);

            if(!empty($product)){
                //add the product specifications
                if ($request->has('sizeName')){
                    foreach ($request->input('sizeName') as $indexs =>$items ) {
                        UserStoreProductSizeVariation::create([
                            'product'=>$product->id,'name'=>$request->input('sizeName')[$indexs],
                            'price'=>$request->input('sizePrice')[$indexs],'quantity'=>$request->input('sizeQuantity')[$indexs],
                        ]);
                    }
                }
                //add the product specifications
                if ($request->has('colorName')){
                    foreach ($request->input('colorName') as $indexs =>$items ) {
                        UserStoreProductColorVariation::create([
                            'product'=>$product->id,'name'=>$request->input('colorName')[$indexs],
                            'price'=>$request->input('colorPrice')[$indexs],'quantity'=>$request->input('colorQuantity')[$indexs],
                        ]);
                    }
                }
                //let us upload the product images
                if ($request->file('file')){
                    foreach ($request->file('file') as $index => $item) {
                        $result = $this->google->uploadGoogle($item);
                        $fileName = $result['link'];

                        UserStoreProductImage::create([
                            'product'=>$product->id,'image'=>$fileName
                        ]);
                    }
                }

                return $this->sendResponse([
                    'redirectTo'=>($request->has('addAnother'))?url()->previous():route('user.stores.catalog.products')
                ],'Product successfully added. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
}
