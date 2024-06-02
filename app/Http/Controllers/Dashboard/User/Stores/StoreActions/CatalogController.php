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
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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
    public function landingPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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
    //products
    public function deletedProducts()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.deleted_products')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Deleted Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'products'      =>UserStoreProduct::onlyTrashed()->where('store',$store->id)->paginate(15)
        ]);
    }
    //new products
    public function newProducts(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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
                'colorName'=>['sometimes','required'],
                'colorName.*'=>['sometimes','required','string','max:200'],
                'returnPolicy'=>['nullable','string'],
                'refundPolicy'=>['nullable','string']
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
                'reference'=>$reference,'description'=>clean($input['description']),
                'featuredImage'=>$featuredPhoto,'amount'=>$input['price'],
                'currency'=>$store->currency,'keyFeatures'=>clean($input['features']),
                'specifications'=>clean($input['specifications']),'manufacturer'=>$input['manufacturer'],
                'brand'=>$input['brand'],'category'=>$input['category'],'quantity'=>$input['qty'],
                'refundPolicy'=>clean($input['refundPolicy']),'returnPolicy'=>clean($input['returnPolicy']),
                'featured'=>($request->has('featured'))?1:2
            ]);

            if(!empty($product)){
                //add the product specifications
                if ($request->has('sizeName')){
                    foreach ($request->input('sizeName') as $indexs =>$items ) {
                        UserStoreProductSizeVariation::create([
                            'product'=>$product->id,'name'=>$request->input('sizeName')[$indexs],
                        ]);
                    }
                }
                //add the product specifications
                if ($request->has('colorName')){
                    foreach ($request->input('colorName') as $indexs =>$items ) {
                        UserStoreProductColorVariation::create([
                            'product'=>$product->id,'name'=>$request->input('colorName')[$indexs],
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
    //edit product status
    public function editProductStatus(Request $request, $id): RedirectResponse
    {
        $status = $request->get('status');
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        $product->status=$status;
        $product->save();

        return back()->with('success','Product Status updated');
    }
    //delete product
    public function deleteProduct($id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        $product->delete();

        return back()->with('success','Product successfully deleted');
    }
    //restore product
    public function restoreProduct($id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::onlyTrashed()->where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        $product->restore();

        return back()->with('success','Product successfully restored');
    }
    //restore product
    public function permanentlyDeleteProduct($id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::onlyTrashed()->where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        UserStoreProductImage::where('product',$product->id)->delete();
        UserStoreProductColorVariation::where('product',$product->id)->delete();
        UserStoreProductSizeVariation::where('product',$product->id)->delete();

        $product->forceDelete();

        return redirect()->to(route('user.stores.catalog.products'))->with('success','Product successfully permanently trashed.');
    }
    //edit product page
    public function editProducts($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }

        return view('dashboard.users.stores.components.catalog.products.edit')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Products',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'categories'    =>UserStoreCatalogCategory::where([
                'store'     =>$store->id,
                'status'    =>1
            ])->get(),
            'product'       =>UserStoreProduct::where(['store'=>$store->id,'reference'=>$id])->firstOrFail()
        ]);
    }
    //process product edit
    public function processProductEdit(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $product = UserStoreProduct::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($product)){
                return $this->sendError('product.error',['error'=>'Product not found.']);
            }
            $validator = Validator::make($request->all(),[
                'featuredPhoto'=>['nullable','image','max:2048'],
                'name'=>['required','string','max:200'],
                'manufacturer'=>['nullable','string','max:150'],
                'category'=>['required','numeric',Rule::exists('user_store_catalog_categories','id')->where('store',$store->id)],
                'brand'=>['nullable','string','max:150'],
                'price'=>['required','numeric'],
                'qty'=>['required','numeric'],
                'description'=>['required','string'],
                'specifications'=>['required','string'],
                'features'=>['required','string'],
                'returnPolicy'=>['nullable','string'],
                'refundPolicy'=>['nullable','string']
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
            //upload featured image
            if ($request->hasFile('featuredPhoto')) {
                //lets upload the address proof
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));
                $featuredPhoto  = $result['link'];
            }else{
                $featuredPhoto=$product->featuredImage;
            }


            if(UserStoreProduct::where('id',$product->id)->update([
                'name'=>$input['name'],'description'=>clean($input['description']),
                'featuredImage'=>$featuredPhoto,'amount'=>$input['price'],
                'currency'=>$store->currency,'keyFeatures'=>clean($input['features']),
                'specifications'=>clean($input['specifications']),'manufacturer'=>$input['manufacturer'],
                'brand'=>$input['brand'],'category'=>$input['category'],'quantity'=>$input['qty'],
                'refundPolicy'=>clean($input['refundPolicy']),'returnPolicy'=>clean($input['returnPolicy'])
            ])){

                return $this->sendResponse([
                    'redirectTo'=>($request->has('addAnother'))?route('user.stores.catalog.products.new'):route('user.stores.catalog.products')
                ],'Product successfully updated. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' updating store product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //edit product page
    public function editProductsImages($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $product = UserStoreProduct::where(['store'=>$store->id,'reference'=>$id])->firstOrFail();

        return view('dashboard.users.stores.components.catalog.products.product_images')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Products Images',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'categories'    =>UserStoreCatalogCategory::where([
                'store'     =>$store->id,
                'status'    =>1
            ])->get(),
            'product'       =>$product,
            'images'        =>UserStoreProductImage::where('product',$product->id)->paginate()
        ]);
    }
    //edit product page
    public function editProductsSpecs($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        $product = UserStoreProduct::where(['store'=>$store->id,'reference'=>$id])->firstOrFail();
        return view('dashboard.users.stores.components.catalog.products.product_specs')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Edit Store Products Specifications',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'store'         =>$store,
            'categories'    =>UserStoreCatalogCategory::where([
                'store'     =>$store->id,
                'status'    =>1
            ])->get(),
            'product'       =>$product,
            'colors'        =>UserStoreProductColorVariation::where('product',$product->id)->paginate(),
            'sizes'         =>UserStoreProductSizeVariation::where('product',$product->id)->paginate()
        ]);
    }
    //delete product image
    public function deleteProductImage($ref,$id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$ref
        ])->firstOrFail();

        $image = UserStoreProductImage::where([
            'product'=>$product->id,'id'=>$id
        ])->firstOrFail();

        $image->delete();

        return back()->with('success','Product Image successfully deleted');
    }

    //delete product sizes
    public function deleteProductSize($ref,$id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$ref
        ])->firstOrFail();

        $size = UserStoreProductSizeVariation::where([
            'product'=>$product->id,'id'=>$id
        ])->firstOrFail();

        $size->delete();

        return back()->with('success','Product Size Variant successfully deleted');
    }
    //delete product color
    public function deleteProductColor($ref,$id): RedirectResponse
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$ref
        ])->firstOrFail();

        $color = UserStoreProductColorVariation::where([
            'product'=>$product->id,'id'=>$id
        ])->firstOrFail();

        $color->delete();

        return back()->with('success','Product Color Variant successfully deleted');
    }
    //process new product addition
    public function processNewProductImage(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $product = UserStoreProduct::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($product)){
                return $this->sendError('product.error',['error'=>'Product not found.']);
            }

            $validator = Validator::make($request->all(),[
                'file'=>['required'],
                'file.*'=>['required','image','max:2048'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            if(!empty($product)){

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
                    'redirectTo'=>url()->previous()
                ],'Product Image successfully added. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store product images: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //process new product addition
    public function processNewProductVariant(Request $request,$id)
    {
        try {
            $web = GeneralSetting::find(1);
            $user = Auth::user();
            $store = UserStore::where('user',$user->id)->first();
            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not initialized.']);
            }
            $product = UserStoreProduct::where([
                'store'=>$store->id,'reference'=>$id
            ])->first();
            if (empty($product)){
                return $this->sendError('product.error',['error'=>'Product not found.']);
            }

            $validator = Validator::make($request->all(),[
                'sizeName'=>['sometimes', 'required'],
                'sizeName.*'=>['sometimes','required','string','max:200'],
                'colorName'=>['sometimes','required'],
                'colorName.*'=>['sometimes','required','string','max:200'],
            ])->stopOnFirstFailure();

            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            if(!empty($product)){

                //add the product specifications
                if ($request->has('sizeName')){
                    foreach ($request->input('sizeName') as $indexs =>$items ) {
                        UserStoreProductSizeVariation::create([
                            'product'=>$product->id,'name'=>$request->input('sizeName')[$indexs],
                        ]);
                    }
                }
                //add the product specifications
                if ($request->has('colorName')){
                    foreach ($request->input('colorName') as $indexs =>$items ) {
                        UserStoreProductColorVariation::create([
                            'product'=>$product->id,'name'=>$request->input('colorName')[$indexs],
                        ]);
                    }
                }

                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Product Variants successfully added. Redirecting soon ...');
            }
        }catch (\Exception $exception){
            Log::info('Error in  ' . __METHOD__ . ' adding store product variants: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }
    }
    //mark product as featured
    public function markFeatured($id)
    {
        $user = Auth::user();

        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        $product->featured=1;
        $product->save();

        return back()->with('success','Product Marked Featured');
    }
    //remove product as featured
    public function removeFeatured($id)
    {
        $user = Auth::user();
        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        $product->featured=2;
        $product->save();

        return back()->with('success','Product Featured removed');
    }
    //mark product as highlighted
    public function highlightProduct($id)
    {
        $user = Auth::user();
        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        if ($product->highlighted==1){
            return back()->with('error','Product already highlighted');
        }

        //another is highlighted
        $highlighted = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->whereNot('id',$id)->first();

        if (!empty($highlighted)){
            $highlighted->highlighted=2;
            $highlighted->save();
        }
        $product->highlighted=1;
        $product->save();

        return back()->with('success','Product Highlighted');
    }
    //remove product as highlighted
    public function removeHighlightProduct($id)
    {
        $user = Auth::user();
        //check if the store has already been initialized
        $store = UserStore::where('user',$user->id)->first();
        if (empty($store)){
            return back()->with('error','Store not initialized - initialize store first.');
        }
        //find product
        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$id
        ])->firstOrFail();

        if ($product->highlighted!=1){
            return back()->with('error','Product not highlighted');
        }

        $product->highlighted=2;
        $product->save();

        return back()->with('success','Product Removed as Highlight');
    }
}
