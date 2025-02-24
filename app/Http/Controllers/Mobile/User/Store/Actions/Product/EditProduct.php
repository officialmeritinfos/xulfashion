<?php

namespace App\Http\Controllers\Mobile\User\Store\Actions\Product;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EditProduct extends BaseController
{
    public $google;
    use Helpers;
    public function __construct()
    {
        $this->google = new GoogleUpload();
    }

    public function index($id)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->firstOrFail();

        $product = UserStoreProduct::where([
            'store' => $store->id,
            'reference' => $id
        ])->firstOrFail();

        return view('mobile.users.store.actions.products.edit_product')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => "Edit {$product->name}",
            'store' => $store,
            'product' => $product,
            'categories' => UserStoreCatalogCategory::where('store',$store->id)->get()
        ]);
    }

    //process edit product
    public function processEditProduct(Request $request,$id)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user', $user->id)->first();

        // Ensure the store is initialized
        if (empty($store)) {
            return $this->sendError('store.error', ['error' => 'Store not initialized.']);
        }

        $product = UserStoreProduct::where([
            'store' => $store->id,
            'reference' => $id
        ])->first();

        // Ensure the store is initialized
        if (empty($product)) {
            return $this->sendError('store.error', ['error' => 'Product not found.']);
        }

        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(),[
                'featuredPhoto' => ['nullable', 'image', 'max:5120'], // Max 5MB image
                'name' => ['required', 'string', 'max:200'],
                'manufacturer' => ['nullable', 'string', 'max:150'],
                'brand' => ['nullable', 'string', 'max:150'],
                'comparePrice' => ['nullable', 'numeric'],
                'sellingPrice' => ['required', 'numeric'],
                'qty' => ['required', 'numeric'],
                'category' => [
                    'required', 'numeric',
                    Rule::exists('user_store_catalog_categories', 'id')->where('store', $store->id)
                ],
                'description' => ['required', 'string'],
                'specifications' => ['required', 'string'],
                'features' => ['required', 'string'],
                'stockAlert' => ['nullable', 'numeric'],
                'alertQuantity' => ['nullable', 'integer', 'min:0'],
            ],[],[
                'qty'=>'Quantity',
            ])->stopOnFirstFailure();

            // Return validation errors if any
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }

            $input = $validator->validated();

            // Check if the category exists within the user's store
            $category = UserStoreCatalogCategory::where([
                'store' => $store->id,
                'id' => $input['category']
            ])->first();

            if (empty($category)) {
                return $this->sendError('category.error', ['error' => 'Category does not exist in store']);
            }

            //ensure that compare price is greater than selling price
            if ($input['comparePrice'] >0 && $input['comparePrice'] < $input['sellingPrice']){
                return $this->sendError('category.error', ['error' => 'Selling price must be less than compare price']);
            }

            //check if the quantity available and stock alert quantity are less
            if ($request->has('stockAlert') && $input['alertQuantity'] >= $input['qty'] ){
                return $this->sendError('category.error', ['error' => 'Stock alert quantity must be less than quantity available']);
            }

            // Upload featured image to Google Cloud Storage
            $featuredPhoto = $product->featuredImage;
            if ($request->hasFile('featuredPhoto')) {
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));

                if (!$result || empty($result['link'])) {
                    Log::error('File upload failed: No link returned from Google Drive API');
                    return $this->sendError('upload.error', ['error' => 'Image upload failed. Please try again.']);
                }

                $featuredPhoto = $result['link'];
            }

            // Create the product in the database
            $product->update([
                'featuredImage' => $featuredPhoto,
                'name' => $input['name'],
                'manufacturer' => $input['manufacturer'] ?? null,
                'brand' => $input['brand'] ?? null,
                'comparePrice' => $input['comparePrice'] ?? null,
                'amount' => $input['sellingPrice'],
                'quantity' => $input['qty'],
                'category' => $input['category'],
                'description' => clean($input['description']), // Clean input for security
                'specifications' => clean($input['specifications']),
                'keyFeatures' => clean($input['features']),
                'featured' => $request->has('featured') ? 1 : 2, // Featured status
                'stockAlert' => $input['stockAlert'] ?? 0,
                'alertQuantity' => $input['alertQuantity'] ?? 0,
            ]);
            DB::commit(); // Commit transaction

            // Redirect to add another product or product listing
            return $this->sendResponse([
                'redirectTo' => route('mobile.user.store.catalog.products.detail',['ref'=>$product->reference]),
            ], 'Product successfully updated. Redirecting soon ...');

        }catch (\Exception $exception){
            DB::rollBack();
            logger("Error adding product to store {$exception->getMessage()}");
            return $this->sendError('store.error',['error'=>$exception->getMessage()]);
        }
    }
}
