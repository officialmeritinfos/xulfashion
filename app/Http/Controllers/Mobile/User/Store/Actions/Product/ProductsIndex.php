<?php

namespace App\Http\Controllers\Mobile\User\Store\Actions\Product;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Jobs\UploadStoreProductPhotosJob;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductSizeVariation;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductsIndex extends BaseController
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
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->firstOrFail();

        return view('mobile.users.store.actions.products.index')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => "{$store->name} Catalog Products",
            'store' => $store,
            'action'=>'list'
        ]);
    }
    //add product
    public function addProduct()
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->firstOrFail();

        return view('mobile.users.store.actions.products.add_new')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => "Add Product to {$store->name}",
            'store' => $store,
            'categories' => UserStoreCatalogCategory::where('store',$store->id)->get()
        ]);
    }
    //process new product
    public function processNewProduct(Request $request)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $store = UserStore::where('user', $user->id)->first();

        // Ensure the store is initialized
        if (empty($store)) {
            return $this->sendError('store.error', ['error' => 'Store not initialized.']);
        }

        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(),[
                'featuredPhoto' => ['required', 'image', 'max:5120'], // Max 5MB image
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
                'sizeName' => ['sometimes', 'required'],
                'sizeName.*' => ['sometimes', 'required', 'string', 'max:200'],
                'colorName' => ['sometimes', 'required'],
                'colorName.*' => ['sometimes', 'required', 'string', 'max:200'],
                'file' => ['nullable','array','max:'.$web->fileUploadAllowed],
                'file.*' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg,webp,avif', 'max:5120'], // Max 5MB per image
                'stockAlert' => ['nullable', 'numeric'],
                'alertQuantity' => ['nullable', 'integer', 'min:0'],
            ],[
                'file.max'=>'You can only upload a maximum of '.$web->fileUploadAllowed.' images.',
                'file.*.image' => 'Each file must be an image.',
                'file.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg,webp,avif.',
                'file.*.max' => 'Each image may not be larger than 5MB.',
                'sizeName.*.required' => 'You must provide a name for the size variant',
                'colorName.*.required' => 'You must provide a name for the color variant',
            ],[
                'file'=>'Product Images',
                'qty'=>'Quantity',
                'colorName.*'=>'Color variant',
                'sizeName.*'=>'Size variant',
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

            // Generate a unique reference for the product
            $reference = $this->generateUniqueReference('user_store_products', 'reference', 6);

            //ensure that compare price is greater than selling price
            if ($input['comparePrice'] >0 && $input['comparePrice'] < $input['sellingPrice']){
                return $this->sendError('category.error', ['error' => 'Selling price must be less than compare price']);
            }

            //check if the quantity available and stock alert quantity are less
            if ($request->has('stockAlert') && $input['alertQuantity'] >= $input['qty'] ){
                return $this->sendError('category.error', ['error' => 'Stock alert quantity must be less than quantity available']);
            }

            // Upload featured image to Google Cloud Storage
            $featuredPhoto = null;
            if ($request->hasFile('featuredPhoto')) {
                $result = $this->google->uploadGoogle($request->file('featuredPhoto'));

                if (!$result || empty($result['link'])) {
                    Log::error('File upload failed: No link returned from Google Drive API');
                    return $this->sendError('upload.error', ['error' => 'Image upload failed. Please try again.']);
                }

                $featuredPhoto = $result['link'];
            }

            // Create the product in the database
            $product = UserStoreProduct::create([
                'store' => $store->id,
                'reference' => $reference,
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
                'refundPolicy' => clean($store->refundPolicy), // Apply store refund policy
                'returnPolicy' => clean($store->returnPolicy), // Apply store return policy
                'currency' => $store->currency,
                'featured' => $request->has('featured') ? 1 : 2, // Featured status
                'stockAlert' => $input['stockAlert'] ?? 0,
                'alertQuantity' => $input['alertQuantity'] ?? 0,
            ]);
            if(!empty($product)){
                // Add product size variations if provided
                if ($request->has('sizeName')) {
                    foreach ($request->input('sizeName') as $size) {
                        UserStoreProductSizeVariation::create([
                            'product' => $product->id,
                            'name' => $size,
                        ]);
                    }
                }
                // Add product color variations if provided
                if ($request->has('colorName')) {
                    foreach ($request->input('colorName') as $color) {
                        UserStoreProductColorVariation::create([
                            'product' => $product->id,
                            'name' => $color,
                        ]);
                    }
                }

                // Upload additional product images to Google Cloud Storage (Queued for performance)
                if ($request->file('file')) {
                    $photoPaths = [];
                    foreach ($request->file('file') as $photo) {
                        $path = $photo->store('temp_photos'); // Store in storage/app/temp_photos
                        $photoPaths[] = $path;
                    }
                    UploadStoreProductPhotosJob::dispatch($product->id, $photoPaths);
                }

                DB::commit(); // Commit transaction

                // Redirect to add another product or product listing
                return $this->sendResponse([
                    'redirectTo' => $request->has('addAnother') ? url()->previous() : route('mobile.user.store.catalog.products')
                ], 'Product successfully added. Redirecting soon ...');
            }

        }catch (\Exception $exception){
            DB::rollBack();
            logger("Error adding product to store {$exception->getMessage()}");
            return $this->sendError('store.error',['error'=>$exception->getMessage()]);
        }
    }
}
